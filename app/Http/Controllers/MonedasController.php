<?php

namespace App\Http\Controllers;

use App\Models\Monedas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class MonedasController extends Controller
{
    public function index()
    {
        $select = [
            'wse_paises.id_pais',
            'wse_paises.nombre AS nombre_pais',
            'wse_monedas.id_moneda', 
            'wse_monedas.nombre AS nombre_moneda',
            'wse_monedas.abreviatura',
        ];

        extract(request()->only(['query', 'limit', 'page', 'orderBy', 'ascending',]));

        $limit = (isset($limit) && $limit != '') ? $limit : 8;
        $page = (isset($page) && $page != 1) ? $page : 1;
        $query = isset($query) ? json_decode($query) : null;

        $this->search = ( $query != null && isset($query->search) && $query->search != '' ) ? $query->search : "";
        $records = DB::table('wse_monedas')
        ->leftJoin('wse_paises', 'wse_paises.id_pais', '=', 'wse_monedas.id_pais')
        ->where('wse_monedas.eliminado', '=', false)
        ->where('wse_paises.eliminado', '=', false)
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

    public function monedas_disponibles()
    {
        $results = DB::table('wse_monedas')
        ->where('wse_monedas.eliminado', '=', false)
        ->select([
            'wse_monedas.id_moneda',
            'wse_monedas.nombre',
            'wse_monedas.abreviatura'
        ])->get()->toArray();

        return response()->json([
            'status' => 200,
            'results' => $results
        ], 200);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_pais' => ['required', 'unique:wse_monedas'],
            'nombre' => ['required', 'regex:/^[\pL\s\-]+$/u', 'max:60', 'unique:wse_monedas'],
            'abreviatura' => ['required', 'alpha', 'max:60', 'unique:wse_monedas']
        ]);

        if ( isset($validator) && $validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $moneda = new Monedas;

        $moneda->id_pais = $request->id_pais;
        $moneda->nombre = ucwords($request->nombre);
        $moneda->abreviatura = strtoupper($request->abreviatura);

        $moneda->save();

        return response()->json([
            'status' => 200,
            'message' => 'La Moneda '.$moneda->nombre.' fue agregada con éxito'
        ], 200);
    }

    public function edit($id)
    {
        $moneda = Monedas::where('id_moneda', '=', $id)
        ->where('eliminado', '=', false)
        ->select([
            'id_pais',
            'id_moneda', 
            'nombre',
            'abreviatura',
        ])->first();

        return response()->json([
            'status' => 200,
            'results' => $moneda
        ], 200);

    }

    public function update($id, Request $request)
    {
        $moneda = Monedas::find($id);

        if( ucwords($request->nombre) != $moneda->nombre){
            $validator = Validator::make($request->all(), [
                'nombre' => ['required', 'regex:/^[\pL\s\-]+$/u', 'max:60', 'unique:wse_monedas'],
            ]);
        }

        if(  strtoupper($request->abreviatura) != $moneda->abreviatura ){
            $validator = Validator::make($request->all(), [
                'abreviatura' => ['required', 'alpha', 'max:60', 'unique:wse_monedas'],
            ]);
        }

        if( $request->id_pais != $moneda->id_pais){
            $validator = Validator::make($request->all(), [
                'id_pais' => ['required', 'unique:wse_monedas'],
            ]);
        }

        if ( isset($validator) && $validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $nombre =  $moneda->nombre;
        $moneda->id_pais = ( $request->id_pais != $moneda->id_pais ) ? $request->id_pais : $moneda->id_pais;
        $moneda->nombre = ucwords(( $request->nombre != $moneda->nombre ) ? $request->nombre : $moneda->nombre);
        $moneda->abreviatura = strtoupper( ( $request->abreviatura != $moneda->abreviatura ) ? $request->abreviatura : $moneda->abreviatura );

        $moneda->update();

        return response()->json([
            'status' => 200,
            'message' => 'La Moneda '.$nombre.' fue actualizada con éxito'
        ], 200);
        
    }

    public function delete($id)
    {
        $moneda = Monedas::find($id);

        $moneda->eliminado = true;
        $moneda->fecha_eliminado = Carbon::now();

        $moneda->update();

        return response()->json([
            'status' => 200,
            'message' => 'La Moneda '. $moneda->nombre.' fue eliminado con éxito'
        ], 200);
    }

    
}
