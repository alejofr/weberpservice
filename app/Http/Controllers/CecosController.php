<?php

namespace App\Http\Controllers;

use App\Models\Cecos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class CecosController extends Controller
{
    public function index()
    {
        $select = [
            'wse_empresas.id_empresa',
            'wse_empresas.nombre_corto',
            'wse_cecos.id_ceco',
            'wse_cecos.id_ceco_erp',
            'wse_cecos.largo_ceco',
            'wse_cecos.corto_ceco',
        ];

        extract(request()->only(['query', 'limit', 'page', 'orderBy', 'ascending',]));

        $limit = (isset($limit) && $limit != '') ? $limit : 8;
        $page = (isset($page) && $page != 1) ? $page : 1;
        $query = isset($query) ? json_decode($query) : null;

        $id_empresa = ( $query != null && isset($query->id_empresa) && $query->id_empresa != '' ) ? $query->id_empresa : '';
        $this->search = ( $query != null && isset($query->search) && $query->search != '' ) ? $query->search : "";

        $records = DB::table('wse_cecos')
        ->leftJoin('wse_empresas', 'wse_empresas.id_empresa', '=', 'wse_cecos.id_empresa')
        ->where('wse_empresas.eliminado', '=', false)
        ->where('wse_cecos.eliminado', '=', false);

        if( $id_empresa != '' ){
            $records = $records->where('wse_cecos.id_empresa', '=', $id_empresa);
        }

        $records = $records->Where(function($query) {
            $query->orWhere('wse_empresas.nombre_corto',  'LIKE', '%'.$this->search.'%')
            ->orWhere('wse_cecos.largo_ceco',  'LIKE', '%'.$this->search.'%')
            ->orWhere('wse_cecos.corto_ceco',  'LIKE', '%'.$this->search.'%');
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

    public function all()
    {
        $select = [
            'wse_cecos.id_ceco',
            'wse_cecos.id_ceco_erp',
            'wse_cecos.largo_ceco',
            'wse_cecos.corto_ceco',
        ];

        extract(request()->only(['query']));

        $this->search = ( $query != null && isset($query->search) && $query->search != '' ) ? $query->search : "";

        $results = DB::table('wse_cecos')
        ->where('wse_cecos.eliminado', '=', false)
        ->Where(function($query) {
            $query->orWhere('wse_cecos.largo_ceco',  'LIKE', '%'.$this->search.'%')
            ->orWhere('wse_cecos.corto_ceco',  'LIKE', '%'.$this->search.'%');
        })
        ->select($select)->get()->toArray();

        return response()->json([
            'status' => 200,
            'results' => $results
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_ceco_erp' => ['required'],
            'id_empresa' => ['required'],
            'largo_ceco' => ['required', 'max:60', 'unique:wse_cecos'],
            'corto_ceco' => ['required', 'max:30', 'unique:wse_cecos'],
        ]);

        if ( isset($validator) && $validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $ceco = New Cecos;

        $ceco->id_empresa = $request->id_empresa;
        $ceco->id_ceco_erp= $request->id_ceco_erp;
        $ceco->largo_ceco = $request->largo_ceco;
        $ceco->corto_ceco =  $request->corto_ceco;

        $ceco->save();

        return response()->json([
            'status' => 200,
            'message' => 'El ceco '.$ceco->largo_corto.' fue agregado con éxito'
        ], 200);
    }

    public function edit($id)
    {
        $select = [
            'wse_paises.id_pais',
            'wse_cecos.id_empresa',
            'wse_cecos.id_ceco_erp',
            'wse_cecos.id_ceco',
            'wse_cecos.id_ceco_erp',
            'wse_cecos.largo_ceco',
            'wse_cecos.corto_ceco',
        ];

        $ceco = DB::table('wse_cecos')
        ->leftJoin('wse_empresas', 'wse_empresas.id_empresa', '=', 'wse_cecos.id_empresa')
        ->leftJoin('wse_paises', 'wse_paises.id_pais', '=', 'wse_empresas.id_pais')
        ->where('wse_cecos.eliminado', '=', false)
        ->where('wse_cecos.id_ceco', '=', $id)
        ->select($select)->first();
       

        return response()->json([
            'status' => 200,
            'results' => $ceco,
        ], 200);
    }

    public function update($id, Request $request)
    {
        $ceco = Cecos::find($id);

        $validator = Validator::make($request->all(), [
            'id_empresa' => ['required'],
            'id_ceco_erp' => ['required']
        ]);

        if( $ceco->largo_ceco != $request->largo_ceco ){
            $validator = Validator::make($request->all(), [
                'largo_ceco' => ['required', 'max:60', 'unique:wse_cecos']
            ]);
        }
        
        if( $ceco->corto_ceco != $request->corto_ceco ){
            $validator = Validator::make($request->all(), [
                'corto_ceco' => ['required', 'max:30', 'unique:wse_cecos']
            ]);
        }
        

        if ( isset($validator) && $validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => $validator->errors()->first(),
            ], 422);
        }

      
        $largo =  $ceco->largo_ceco;
        $ceco->id_empresa = $request->id_empresa;
        $ceco->id_ceco_erp= $request->id_ceco_erp;
        $ceco->largo_ceco = $request->largo_ceco;
        $ceco->corto_ceco =  $request->corto_ceco;

        $ceco->update();

        return response()->json([
            'status' => 200,
            'message' => 'El Ceco '.$largo.' fue actualizado con éxito'
        ], 200);
    }

    public function delete($id)
    {
        $ceco = Cecos::find($id);

        $ceco->eliminado = true;
        $ceco->fecha_eliminado = Carbon::now();

        $ceco->update();

        return response()->json([
            'status' => 200,
            'message' => 'El Ceco '. $ceco->largo_ceco.' fue eliminado con éxito'
        ], 200);
    }
}
