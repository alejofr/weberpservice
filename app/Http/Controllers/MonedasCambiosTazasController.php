<?php

namespace App\Http\Controllers;

use App\Models\Monedas;
use App\Models\MonedasCambios;
use App\Models\MonedasCambiosTazas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class MonedasCambiosTazasController extends Controller
{
    //
    public function index()
    {


        $select = [
            'wse_monedas.id_moneda',
            'wse_monedas.nombre as nombre_nc',
            'wse_monedas.abreviatura as abreviatura_nc',
            'money.nombre as nombre_divisa',
            'money.abreviatura as abreviatura_divisa',  
            'wse_monedas_cambios.id_moneda_cambio',
            'wse_monedas_cambios.id_moneda_nc',
            'wse_monedas_cambios.id_moneda_divisa',
            'wse_monedas_cambios_tazas.id_cambio_taza',
            'wse_monedas_cambios_tazas.monto_tc',
            'wse_monedas_cambios_tazas.fecha_editado'
        ];

        extract(request()->only(['query', 'limit', 'page', 'orderBy', 'ascending',]));

        $limit = (isset($limit) && $limit != '') ? $limit : 8;
        $page = (isset($page) && $page != 1) ? $page : 1;
        $query = isset($query) ? json_decode($query) : null;

        $this->search = ( $query != null && isset($query->search) && $query->search != '' ) ? $query->search : "";
        $id_tipo_cambio = ( $query != null && isset($query->id_cambio) && $query->id_cambio != '' ) ? $query->id_cambio : '';

        if( $id_tipo_cambio == '' ){
            $cambio = MonedasCambios::where('eliminado', '=', false)
            ->orderBy('fecha_editado', 'DESC')->first();

            $id_tipo_cambio = ( $cambio != null ) ? $cambio->id_moneda_cambio : $id_tipo_cambio;
        }


        $records = DB::table('wse_monedas_cambios_tazas')
        ->leftJoin('wse_monedas_cambios', 'wse_monedas_cambios.id_moneda_cambio', '=', 'wse_monedas_cambios_tazas.id_moneda_cambio')
        ->leftJoin('wse_monedas', 'wse_monedas.id_moneda', '=', 'wse_monedas_cambios.id_moneda_nc')
        ->leftJoin('wse_monedas as money', 'money.id_moneda', '=', 'wse_monedas_cambios.id_moneda_divisa')
        ->where('wse_monedas_cambios.eliminado', '=', false)
        ->where('wse_monedas.eliminado', '=', false)
        ->where('wse_monedas_cambios_tazas.eliminado', '=', false)
        ->where('wse_monedas_cambios.id_moneda_cambio', '=', $id_tipo_cambio)
        ->Where(function($query) {
            $query->orWhere('wse_monedas.nombre',  'LIKE', '%'.$this->search.'%')
            ->orWhere('wse_monedas.abreviatura',  'LIKE', '%'.$this->search.'%');
        })
        ->select($select);

        $count = $records->count();
        $records->limit($limit)
            ->skip($limit * ($page - 1));

        if (isset($orderBy)) {
            $direction = $ascending == 1 ? 'ASC' : 'DESC';
            $records->orderBy($orderBy, $direction);
        }

        $results = $records->get()->toArray();

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

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_moneda_cambio' => ['required', 'unique:wse_monedas_cambios_tazas'],
            'monto_tc' => ['required']
        ]);

        if ( isset($validator) && $validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $taza = new MonedasCambiosTazas();

        $taza->id_moneda_cambio = $request->id_moneda_cambio;
        $taza->monto_tc = $request->monto_tc;

        $taza->save();

        return response()->json([
            'status' => 200,
            'message' => 'Taza de cambio fue agregado con éxito'
        ], 200);
    }

    public function edit($id)
    {
        $taza = MonedasCambiosTazas::where('id_cambio_taza', '=', $id)
        ->where('eliminado', '=', false)
        ->select([
            'id_moneda_cambio',
            'id_cambio_taza',
            'monto_tc',
        ])->first();


        return response()->json([
            'status' => 200,
            'results' =>  $taza
        ], 200);

    }

    public function update($id, Request $request)
    {

        $taza_before = MonedasCambiosTazas::where('id_cambio_taza', '=', $id)
        ->where('eliminado', '=', false)
        ->select([
            'id_moneda_cambio',
            'id_cambio_taza',
            'monto_tc',
            'fecha_editado',
        ])->first();
        
        $fecha_actual = Carbon::now()->format('Y-m-d');
        $consul = MonedasCambiosTazas::where('id_moneda_cambio', '=', $taza_before->id_moneda_cambio)
        ->where('eliminado', '=', false)
        ->whereDate('fecha_editado', $fecha_actual)->count();

        if( $consul > 0 ){
            return response()->json([
                'status' => 422,
                'message' => 'No es permitido actualizar la tasa de cambio dos veces por dia.',
            ], 422);
        }

       
        $taza = new MonedasCambiosTazas();

        $taza->id_moneda_cambio = $taza_before->id_moneda_cambio;
        $taza->monto_tc = $request->monto_tc;

        $taza->save();

        return response()->json([
            'status' => 200,
            'message' => 'El cambio de taza fue actualizado con éxito'
        ], 200);
        
    }

    public function delete($id)
    {
        $taza = MonedasCambiosTazas::find($id);

        $taza->eliminado = true;
        $taza->fecha_eliminado = Carbon::now();

        $taza->update();

        return response()->json([
            'status' => 200,
            'message' => 'La taza de cambio fue eliminada con éxito'
        ], 200);
    }
}
