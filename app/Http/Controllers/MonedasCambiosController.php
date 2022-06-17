<?php

namespace App\Http\Controllers;

use App\Models\Monedas;
use App\Models\MonedasCambios;
use App\Models\MonedasCambiosTazas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class MonedasCambiosController extends Controller
{
    public function index()
    {
        $select = [
            'wse_paises.id_pais',
            'wse_paises.nombre AS nombre_pais',
            'wse_monedas.id_moneda',
            'wse_monedas.nombre as nombre_nc',
            'wse_monedas.abreviatura as abreviatura_nc',
            'money.nombre as nombre_divisa',
            'money.abreviatura as abreviatura_divisa',  
            'wse_monedas_cambios.id_moneda_cambio',
            'wse_monedas_cambios.id_moneda_nc',
            'wse_monedas_cambios.id_moneda_divisa'
        ];

        extract(request()->only(['query', 'limit', 'page', 'orderBy', 'ascending',]));

        $limit = (isset($limit) && $limit != '') ? $limit : 8;
        $page = (isset($page) && $page != 1) ? $page : 1;
        $query = isset($query) ? json_decode($query) : null;

        $this->search = ( $query != null && isset($query->search) && $query->search != '' ) ? $query->search : "";
        $id_pais = ( $query != null && isset($query->id_pais) && $query->id_pais != '' ) ? $query->id_pais : '';

        $records = DB::table('wse_monedas_cambios')
        ->leftJoin('wse_monedas', 'wse_monedas.id_moneda', '=', 'wse_monedas_cambios.id_moneda_nc')
        ->leftJoin('wse_monedas as money', 'money.id_moneda', '=', 'wse_monedas_cambios.id_moneda_divisa')
        ->leftJoin('wse_paises', 'wse_paises.id_pais', '=', 'wse_monedas.id_pais')
        ->where('wse_monedas_cambios.eliminado', '=', false)
        ->where('wse_monedas.eliminado', '=', false)
        ->where('wse_paises.eliminado', '=', false);

        if( $id_pais != '' ){
            $records = $records->where('wse_paises.id_pais', '=', $id_pais);
        }

        $records = $records->Where(function($query) {
            $query->orWhere('wse_monedas.nombre',  'LIKE', '%'.$this->search.'%')
            ->orWhere('wse_monedas.abreviatura',  'LIKE', '%'.$this->search.'%');
        })->select($select);

        $count = $records->count();
        $records->limit($limit)
            ->skip($limit * ($page - 1));

        if (isset($orderBy)) {
            $direction = $ascending == 1 ? 'ASC' : 'DESC';
            $records->orderBy($orderBy, $direction);
        }

        $results = $records->get()->toArray();
        for ($i=0; $i < count($results) ; $i++) { 
            $taza = DB::table('wse_monedas_cambios_tazas')->where('id_moneda_cambio', '=', $results[$i]->id_moneda_cambio)
                ->where('eliminado', '=', false)
                ->orderBy('fecha_editado', 'DESC')
                ->select(['id_cambio_taza','monto_tc', 'fecha_editado'])
                ->first();

            $results[$i]->id_cambio_taza = ( $taza != null ) ? $taza->id_cambio_taza : '';
            $results[$i]->monto_tc = ( $taza != null ) ? $taza->monto_tc : '';
            $results[$i]->fecha_editado = ( $taza != null ) ? $taza->fecha_editado : '';
        }

        return response()->json([
            'status' => 200,
            'results' => $results,
            'pagination' => [
                'numPage' => intval($page),
                'resultPage' => count($results),
                'totalResult' => $count
            ]
        ], 200);
    }

    public function cambios_disponibles()
    {
        $results = DB::table('wse_monedas_cambios')
        ->leftJoin('wse_monedas', 'wse_monedas.id_moneda', '=', 'wse_monedas_cambios.id_moneda_nc')
        ->leftJoin('wse_monedas as money', 'money.id_moneda', '=', 'wse_monedas_cambios.id_moneda_divisa')
        ->where('wse_monedas_cambios.eliminado', '=', false)
        ->where('wse_monedas.eliminado', '=', false)
        ->select([
            'wse_monedas.nombre as nombre_nc',
            'wse_monedas.abreviatura as abreviatura_nc',
            'money.nombre as nombre_divisa',
            'money.abreviatura as abreviatura_divisa',  
            'wse_monedas_cambios.id_moneda_cambio',
        ])->get()->toArray();

        return response()->json([
            'status' => 200,
            'results' => $results
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_moneda_nc' => ['required'],
            'id_moneda_divisa' => ['required'],
            'monto_tc' => ['required']
        ]);

        $consul = MonedasCambios::where('id_moneda_nc', '=', $request->id_moneda_nc)
        ->where('id_moneda_divisa', '=', $request->id_moneda_divisa)
        ->where('eliminado', '=', false)->count();
        
        if( $consul > 0 ){
            return response()->json([
                'status' => 422,
                'message' => 'Ya existe un cambio para estas monedas',
            ], 422);
        }

        if ( isset($validator) && $validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $moneda = new MonedasCambios;

        $moneda->id_moneda_nc = $request->id_moneda_nc;
        $moneda->id_moneda_divisa = $request->id_moneda_divisa;

        $moneda->save();

        $taza = new MonedasCambiosTazas();

        $taza->id_moneda_cambio = $moneda->id_moneda_cambio;
        $taza->monto_tc = $request->monto_tc;

        $taza->save();

        return response()->json([
            'status' => 200,
            'message' => 'El Cambio fue agregado con éxito'
        ], 200);
    }

    public function edit($id)
    {
        $monedacambio = MonedasCambios::where('id_moneda_cambio', '=', $id)
        ->where('eliminado', '=', false)
        ->select([
            'id_moneda_cambio', 
            'id_moneda_nc',
            'id_moneda_divisa'
        ])->first();

        $taza = MonedasCambiosTazas::where('id_moneda_cambio', '=', $monedacambio->id_moneda_cambio)
        ->where('eliminado', '=', false)
        ->orderBy('fecha_editado', 'ASC')
        ->select(['monto_tc'])
        ->first();

        $monedacambio->monto_tc = ( $taza != null ) ? $taza->monto_tc : '';

        return response()->json([
            'status' => 200,
            'results' =>  $monedacambio
        ], 200);

    }

    public function update($id, Request $request)
    {
        $monedacambio = MonedasCambios::find($id);
        $consul = 0;

        if( $request->id_moneda_nc != $monedacambio->id_moneda_nc){
            $consul = MonedasCambios::where('id_moneda_nc', '=', $request->id_moneda_nc)
            ->where('id_moneda_divisa', '=', $request->id_moneda_divisa)
            ->where('eliminado', '=', false)->count();
        }else if( $request->id_moneda_divisa != $monedacambio->id_moneda_divisa ){
            $consul = MonedasCambios::where('id_moneda_nc', '=', $request->id_moneda_nc)
            ->where('id_moneda_divisa', '=', $request->id_moneda_divisa)->count();
        }else if( $request->id_moneda_nc != $monedacambio->id_moneda_nc &&  $request->id_moneda_divisa != $monedacambio->id_moneda_divisa){
            $consul = MonedasCambios::where('id_moneda_nc', '=', $request->id_moneda_nc)
            ->where('id_moneda_divisa', '=', $request->id_moneda_divisa)->count();
        }

        if( $consul > 0 ){
            return response()->json([
                'status' => 422,
                'message' => 'Ya existe un cambio para estas monedas',
            ], 422);
        }

        
        $validator = Validator::make($request->all(), [
            'id_moneda_nc' => ['required'],
            'id_moneda_divisa' => ['required'],
            'monto_tc' => ['required']
        ]);
        

        if ( isset($validator) && $validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $monedacambio->id_moneda_nc = $request->id_moneda_nc;
        $monedacambio->id_moneda_divisa = $request->id_moneda_divisa;

        $monedacambio->update();

        return response()->json([
            'status' => 200,
            'message' => 'El cambio fue actualizada con éxito'
        ], 200);
        
    }

    public function delete($id)
    {
        $moneda = MonedasCambios::find($id);

        $moneda->eliminado = true;
        $moneda->fecha_eliminado = Carbon::now();

        $moneda->update();

        return response()->json([
            'status' => 200,
            'message' => 'El tipo de cambio fue eliminado con éxito'
        ], 200);
    }
}
