<?php

namespace App\Http\Controllers;

use App\Models\Proveedores;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class ProveedoresController extends Controller
{
    public function index()
    {
        $select = [
            'wse_op_conds_proveedores.leyenda_condiciones',
            'wse_op_proveedores.id_proveedor',
            'wse_op_proveedores.id_cond_proveedor',
            'wse_op_proveedores.id_proveedor_erp',
            'wse_op_proveedores.nombre_proveedor',
            'wse_op_proveedores.nit_proveedor'
        ];

        extract(request()->only(['query', 'limit', 'page', 'orderBy', 'ascending',]));

        $limit = (isset($limit) && $limit != '') ? $limit : 8;
        $page = (isset($page) && $page != 1) ? $page : 1;
        $query = isset($query) ? json_decode($query) : null;

        $this->search = ( $query != null && isset($query->search) && $query->search != '' ) ? $query->search : "";
        $id_cond = ( $query != null && isset($query->id_cond) && $query->id_cond != '' ) ? $query->id_cond : '';

        $records = DB::table('wse_op_proveedores')
        ->leftJoin('wse_op_conds_proveedores', 'wse_op_conds_proveedores.id_cond_proveedor', '=', 'wse_op_proveedores.id_cond_proveedor')
        ->where('wse_op_proveedores.eliminado', '=', false)
        ->where('wse_op_conds_proveedores.eliminado', '=', false);

        if( $id_cond != '' ){
            $records = $records->where('wse_op_proveedores.id_cond_proveedor', '=', $id_cond);
        }

        $records = $records->Where(function($query) {
            $query->orWhere('wse_op_proveedores.nombre_proveedor',  'LIKE', '%'.$this->search.'%')
            ->orWhere('wse_op_proveedores.nit_proveedor',  'LIKE', '%'.$this->search.'%')
            ->orWhere('wse_op_conds_proveedores.leyenda_condiciones',  'LIKE', '%'.$this->search.'%');
        })->select($select);

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
            'wse_op_proveedores.id_proveedor',
            'wse_op_proveedores.id_proveedor_erp',
            'wse_op_proveedores.nombre_proveedor',
            'wse_op_proveedores.nit_proveedor'
        ];

        extract(request()->only(['query']));

        $this->search = ( $query != null && isset($query->search) && $query->search != '' ) ? $query->search : "";
       

        $results = DB::table('wse_op_proveedores')
        ->where('wse_op_proveedores.eliminado', '=', false)
        ->Where(function($query) {
            $query->orWhere('wse_op_proveedores.nombre_proveedor',  'LIKE', '%'.$this->search.'%')
            ->orWhere('wse_op_proveedores.nit_proveedor',  'LIKE', '%'.$this->search.'%');
        })->select($select)->get()->toArray();


        return response()->json([
            'status' => 200,
            'results' => $results
        ], 200);
    }


    public function store(Request $request)
    {
        

        $validator = Validator::make($request->all(), [
            'id_cond_proveedor' => ['required'],
            'nombre_proveedor' => ['required', 'max:80'],
            'nit_proveedor' => ['required','max:40', 'unique:wse_op_proveedores'],
        ]);

   
        if ( isset($validator) && $validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $proveedor = new Proveedores;

        $proveedor->id_cond_proveedor = $request->id_cond_proveedor;
        $proveedor->nombre_proveedor = $request->nombre_proveedor;
        $proveedor->nit_proveedor = $request->nit_proveedor;

        $proveedor->save();

        return response()->json([
            'status' => 200,
            'message' => 'El Proveedor '.$proveedor->nombre_proveedor.' fue agregado con éxito'
        ], 200);
    }

    public function edit($id)
    {
        return response()->json([
            'status' => 200,
            'results' => Proveedores::where('eliminado', '=', false)->where('id_proveedor', '=', $id)->first()
        ], 200);
    }
    
    public function update($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_cond_proveedor' => ['required'],
            'nombre_proveedor' => ['required', 'max:80'],
        ]);

        $proveedor = Proveedores::find($id);

        if( $proveedor->nit_proveedor != $request->nit_proveedor ){
            $validator = Validator::make($request->all(), [
                'nit_proveedor' => ['required','max:40', 'unique:wse_op_proveedores'],
            ]);
        }

        if ( isset($validator) && $validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => $validator->errors()->first(),
            ], 422);
        }
        
        $nombre_proveedor  = $proveedor->nombre_proveedor;
        $proveedor->id_cond_proveedor = $request->id_cond_proveedor;
        $proveedor->nombre_proveedor = $request->nombre_proveedor;
        $proveedor->nit_proveedor = $request->nit_proveedor;

        $proveedor->update();

        return response()->json([
            'status' => 200,
            'message' => 'El Proveedor '.$nombre_proveedor.' fue actualizado con éxito'
        ], 200);
    }

    public function delete($id)
    {
        $proveedor = Proveedores::find($id);
        $proveedor->eliminado = true;
        $proveedor->fecha_eliminado = Carbon::now();

        $proveedor->update();

        return response()->json([
            'status' => 200,
            'message' => 'El proveedor '. $proveedor->nombre_proveedor.' fue eliminado con éxito'
        ], 200);
    }
}
