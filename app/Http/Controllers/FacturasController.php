<?php

namespace App\Http\Controllers;

use App\Models\Cecos;
use App\Models\Facturas;
use App\Models\Proveedores;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class FacturasController extends Controller
{
    public function index()
    {
        $select = [
            'wse_facturas.id_factura',
            'wse_facturas.id_factura_erp',
            'wse_facturas.fecha_factura',
            'wse_facturas.fecha_vencimiento',
            'wse_facturas.monto_factura',
            'wse_facturas.descripcion_factura',
            'wse_op_proveedores.id_proveedor',
            'wse_op_proveedores.nombre_proveedor',
            'wse_op_proveedores.nit_proveedor',
            'wse_monedas.id_moneda',
            'wse_monedas.nombre',
            'wse_cecos.id_ceco',
            'wse_cecos.corto_ceco', 
        ];

        extract(request()->only(['query', 'limit', 'page', 'orderBy', 'ascending',]));

        $limit = (isset($limit) && $limit != '') ? $limit : 8;
        $page = (isset($page) && $page != 1) ? $page : 1;
        $query = isset($query) ? json_decode($query) : null;

        $this->search = ( $query != null && isset($query->search) && $query->search != '' ) ? $query->search : "";

        $records = DB::table('wse_facturas')
        ->leftJoin('wse_op_proveedores', 'wse_op_proveedores.id_proveedor', '=', 'wse_facturas.id_proveedor')
        ->leftJoin('wse_monedas', 'wse_monedas.id_moneda', '=', 'wse_facturas.id_moneda')
        ->leftJoin('wse_cecos', 'wse_cecos.id_ceco', '=', 'wse_facturas.id_ceco')
        ->where('wse_facturas.eliminado', '=', false)
        ->Where(function($query) {
            $query->orWhere('wse_facturas.monto_factura',  'LIKE', '%'.$this->search.'%')
            ->orWhere('wse_facturas.id_factura_erp',  'LIKE', '%'.$this->search.'%')
            ->orWhere('wse_facturas.descripcion_factura',  'LIKE', '%'.$this->search.'%')
            ->orWhere('wse_op_proveedores.nit_proveedor',  'LIKE', '%'.$this->search.'%')
            ->orWhere('wse_op_proveedores.nombre_proveedor',  'LIKE', '%'.$this->search.'%')
            ->orWhere('wse_monedas.nombre',  'LIKE', '%'.$this->search.'%')
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

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'proveedor' => ['required'],
            'ceco' => ['required'],
            'id_moneda' => ['required'],
            'id_factura_erp' => ['required'],
            'fecha_factura' => ['required'],
            'fecha_vencimiento' => ['required'],
            'monto_factura' => ['required'],
            'descripcion_factura' => ['required']
        ]);

        $proveedor = Proveedores::where('eliminado', '=', false)->where('nit_proveedor', '=', $request->proveedor)->first();
        $ceco = Cecos::where('eliminado', '=', false)->where('corto_ceco', '=', $request->ceco)->first();

        if( $proveedor == null ){
            return response()->json([
                'status' => 422,
                'message' => 'No se encontró el proveedor con el NIT: '.$request->proveedor,
            ], 422);
        }
        if( $ceco == null ){
            return response()->json([
                'status' => 422,
                'message' => 'No se encontró el CECO con el nombre corto: '.$request->ceco,
            ], 422);
        }

        if ( isset($validator) && $validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $factura = new Facturas;

        $factura->id_proveedor = $proveedor->id_proveedor;
        $factura->id_ceco = $ceco->id_ceco;
        $factura->id_moneda = $request->id_moneda;
        $factura->id_factura_erp = $request->id_factura_erp;
        $factura->fecha_factura = $request->fecha_factura;
        $factura->fecha_vencimiento = $request->fecha_vencimiento;
        $factura->monto_factura = $request->monto_factura;
        $factura->descripcion_factura = $request->descripcion_factura;

        $factura->save();

        return response()->json([
            'status' => 200,
            'message' => 'La factura con el ID '. $factura->id_factura_erp.' fue agregada con éxito'
        ], 200);

    }
}
