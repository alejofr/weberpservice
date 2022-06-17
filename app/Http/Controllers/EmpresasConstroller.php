<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Empresas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class EmpresasConstroller extends Controller
{
    //
    public function index()
    {
        $select = [
            'wse_paises.id_pais', 
            'wse_paises.nombre AS nombre_pais',
            'wse_empresas.id_empresa',
            'wse_empresas.id_empresa_erp',
            'wse_empresas.nombre_empresa',
            'wse_empresas.nombre_corto',
            'wse_monedas.abreviatura',
        ];

        extract(request()->only(['query', 'limit', 'page', 'orderBy', 'ascending',]));

        $limit = (isset($limit) && $limit != '') ? $limit : 8;
        $page = (isset($page) && $page != 1) ? $page : 1;
        $query = isset($query) ? json_decode($query) : null;

        $id_pais = ( $query != null && isset($query->id_pais) && $query->id_pais != '' ) ? $query->id_pais : '';
        $this->search = ( $query != null && isset($query->search) && $query->search != '' ) ? $query->search : "";

        $records = DB::table('wse_empresas')
        ->leftJoin('wse_paises', 'wse_paises.id_pais', '=', 'wse_empresas.id_pais')
        ->leftJoin('wse_monedas', 'wse_monedas.id_pais', '=', 'wse_paises.id_pais')
        ->where('wse_empresas.eliminado', '=', false);

        if( $id_pais != '' ){
            $records = $records->where('wse_empresas.id_pais', '=', $id_pais);
        }

        $records = $records->Where(function($query) {
            $query->orWhere('wse_empresas.nombre_empresa',  'LIKE', '%'.$this->search.'%')
            ->orWhere('wse_empresas.nombre_corto',  'LIKE', '%'.$this->search.'%')
            ->orWhere('wse_paises.nombre',  'LIKE', '%'.$this->search.'%');
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

    public function empresasAll()
    {
        
        extract(request()->only(['id_pais']));

        $id_pais = ( isset($id_pais) ) ? $id_pais : '';

        $records = DB::table('wse_empresas')
        ->where('wse_empresas.eliminado', '=', false);

        if( $id_pais != '' ){
            $records = $records->where('wse_empresas.id_pais', '=', $id_pais);
        }

        $results =$records->get()->toArray();
        
        return response()->json([
            'status' => 200,
            'results' => $results
        ], 200);
        
    }

    public function store(Request $request)
    {
        $empresa = new Empresas;

        $validator = Validator::make($request->all(), [
            'id_pais' => ['required'],
            'nombre_empresa' => ['required','max:80', 'unique:wse_empresas'],
        ]);

        if( isset($request->nombre_corto) && $request->nombre_corto != ''){
            $validator = Validator::make($request->all(), [
                'nombre_corto' => ['max:40', 'unique:wse_empresas'],
            ]);
            $empresa->nombre_corto = $request->nombre_corto;
        }
      

        if ( isset($validator) && $validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => $validator->errors()->first(),
            ], 422);
        }

      

        $empresa->id_pais = $request->id_pais;
        $empresa->nombre_empresa = $request->nombre_empresa;
        $empresa->save();


        return response()->json([
            'status' => 200,
            'message' => 'La Empresa '.$empresa->nombre_empresa.' fue agregado con éxito',
        ], 200);
    }

    public function edit($id)
    {
        $empresa = Empresas::where('id_empresa', '=', $id)
        ->where('eliminado', '=', false)
        ->select([
            'id_empresa',
            'id_pais', 
            'nombre_empresa', 
            'nombre_corto'
        ])->first();

        return response()->json([
            'status' => 200,
            'results' => $empresa
        ], 200);
    }

    public function update($id, Request $request)
    {
        $empresa = Empresas::find($id);

        if( $empresa->id_pais != $request->id_pais )
            $empresa->id_pais = $request->id_pais;

        if( $empresa->nombre_empresa != $request->nombre_empresa ){
            $validator = Validator::make($request->all(), [
                'nombre_empresa' => ['required','max:80', 'unique:wse_empresas'],
            ]);
        }            

        if( isset($request->nombre_corto) && $request->nombre_corto != ''){
            $validator = Validator::make($request->all(), [
                'nombre_corto' => ['max:40', 'unique:wse_empresas'],
            ]);

            $empresa->nombre_corto = $request->nombre_corto;
        }

        if ( isset($validator) && $validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $nombre_empresa = $empresa->nombre_empresa;
        $empresa->nombre_empresa = $request->nombre_empresa;

        $empresa->update();

        return response()->json([
            'status' => 200,
            'message' => 'La Empresa '.$nombre_empresa.' fue actualizada con éxito'
        ], 200);
        
    }

    public function delete($id)
    {
        $empresa = Empresas::find($id);

        $empresa->eliminado = true;
        $empresa->fecha_eliminado = Carbon::now();

        $empresa->update();

        return response()->json([
            'status' => 200,
            'message' => 'La Empresa '.$empresa->nombre_empresa.' fue eliminado con éxito'
        ], 200);
    }
}
