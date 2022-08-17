<?php

namespace App\Http\Controllers;

use App\Models\Cecos;
use App\Models\Facturas;
use App\Models\Monedas;
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
            'wse_facturas.status',
            'wse_op_proveedores.id_proveedor',
            'wse_op_proveedores.id_proveedor_erp',
            'wse_op_proveedores.nombre_proveedor',
            //'wse_op_proveedores.nit_proveedor',
            'wse_monedas.id_moneda',
            'wse_monedas.abreviatura',
            'wse_cecos.id_ceco',
            'wse_cecos.corto_ceco',
            'wse_cecos.id_empresa',
            'wse_empresas.id_empresa',
            'wse_empresas.id_pais',
            'wse_empresas.clave',
            'wse_paises.id_pais',
            'monedas.id_pais',
            'monedas.id_moneda as id_moneda_pais',
            'monedas.abreviatura as abreviatura_pais', 
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
        ->leftJoin('wse_empresas', 'wse_empresas.id_empresa', '=', 'wse_cecos.id_empresa')
        ->leftJoin('wse_paises', 'wse_paises.id_pais', '=', 'wse_empresas.id_pais')
        ->leftJoin('wse_monedas as monedas', 'monedas.id_pais', '=', 'wse_paises.id_pais')
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

        $arreglo = [];

        for ($i=0; $i < count($results) ; $i++) { 
            $tc = 1;
            $total_mn = 1;

            if( $results[$i]->id_moneda != $results[$i]->id_moneda_pais ){
               $tasa_cambio =  DB::table('wse_monedas_cambios')
                ->leftJoin('wse_monedas_cambios_tazas', 'wse_monedas_cambios_tazas.id_moneda_cambio', '=', 'wse_monedas_cambios.id_moneda_cambio')
                ->where('wse_monedas_cambios.id_moneda_nc', '=', $results[$i]->id_moneda_pais)
                ->where('wse_monedas_cambios.id_moneda_divisa', '=', $results[$i]->id_moneda)
                ->where('wse_monedas_cambios_tazas.fecha_tc', '=', $results[$i]->fecha_factura)
                ->orderBy('wse_monedas_cambios_tazas.fecha_tc', 'DESC')
                ->select(['wse_monedas_cambios_tazas.monto_tc', 'wse_monedas_cambios_tazas.fecha_tc'])
                ->first();

                if( $tasa_cambio != null ){
                    $tc = $tasa_cambio->monto_tc;
                    $total_mn = $tc * $results[$i]->monto_factura;
                }
            }

            $aux = [
                'id_factura' => $results[$i]->id_factura,
                'status' =>  $results[$i]->status,
                'remesa' =>  '',
                'ceco' =>  $results[$i]->clave.'-'.$results[$i]->corto_ceco,
                'proveedor' =>  $results[$i]->id_proveedor_erp,
                'nombre_proveedor' =>  $results[$i]->nombre_proveedor,
                'no_factura' =>  $results[$i]->id_factura_erp,
                'fecha_factura' => $results[$i]->fecha_factura, 
                'fecha_vencimiento' => $results[$i]->fecha_vencimiento, 
                'total_factura' => $results[$i]->monto_factura, 
                'por_pagar' =>  $results[$i]->monto_factura,
                'divisa' => $results[$i]->abreviatura, 
                'tc' => $tc, 
                'total_mn' => $total_mn, 
                'descripcion_factura' => $results[$i]->descripcion_factura, 
                'contrato' => '', 
                'bolsa' => ''
            ];
            
            array_push($arreglo, $aux);
        }

        
        return response()->json([
            'status' => 200,
            'results' => $arreglo,
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

    public function load(Request $request)
    {
        $facturas = $request->load;
        //$proveedores = json_decode($proveedores);

        if( count($facturas)  == 0 ){
            return response()->json([
                'status' => 422,
                'message' => 'Error, El archivo Excel no debe de estar vacios.'
            ], 422);
        }

        for ($i=0; $i <count($facturas) ; $i++) {
            $validator = Validator::make($facturas[$i], [
                'id_factura' => ['required', 'max:40'],
                'id_proveedor' => ['required'],
                'id_moneda' => ['required'],
                'id_ceco' => ['required'],
                'fecha_factura' => ['required', 'date', 'date_format:Y-m-d'],
                'fecha_vencimiento_factura' => ['required', 'date', 'date_format:Y-m-d'],
                'monto_factura' => ['required'],
                'descripcion_factura' => ['required'],
            ]);

            if ( isset($validator) && $validator->fails()) {
                $facturas[$i]['status'] = 422;
                $facturas[$i]['message'] = $validator->errors()->first();
            }else{
                $bol = false;
                $count_factura = Facturas::where('eliminado', '=', false)->where('id_factura_erp', '=', $facturas[$i]['id_factura'])->count();

                if( $count_factura == 0 ){
                    $count_proveedor = Proveedores::where('eliminado', '=', false)->where('id_proveedor_erp', '=',  $facturas[$i]['id_proveedor'])->count();

                    $count_moneda = Monedas::where('eliminado', '=', false)->where('id_moneda_erp', '=',  $facturas[$i]['id_moneda'])->count();
    
                    $count_ceco = Cecos::where('eliminado', '=', false)->where('id_ceco_erp', '=',  $facturas[$i]['id_ceco'])->count();
    
                    if( $count_proveedor == 0 ){
                        $facturas[$i]['message'] = 'El proveedor no existe con el ID: '.$facturas[$i]['id_proveedor'];
                    }elseif( $count_moneda == 0 ){
                        $facturas[$i]['message'] = 'La moneda no existe con el ID: '.$facturas[$i]['id_moneda'];
                    }elseif( $count_ceco == 0 ){
                        $facturas[$i]['message'] = 'El ceco no existe con el ID: '.$facturas[$i]['id_ceco'];
                    }else{
                        $bol = true;
                    }
    
                    if(!$bol){
                        $facturas[$i]['status'] = 422;
                    }else{
                        $proveedor = Proveedores::where('eliminado', '=', false)->where('id_proveedor_erp', '=',  $facturas[$i]['id_proveedor'])->first();
    
                        $moneda = Monedas::where('eliminado', '=', false)->where('id_moneda_erp', '=',  $facturas[$i]['id_moneda'])->first();
    
                        $ceco = Cecos::where('eliminado', '=', false)->where('id_ceco_erp', '=',  $facturas[$i]['id_ceco'])->first();
    
                        Facturas::create([
                            'id_proveedor' => $proveedor->id_proveedor,
                            'id_ceco' => $ceco->id_ceco,
                            'id_moneda' => $moneda->id_moneda,
                            'id_factura_erp' => $facturas[$i]['id_factura'],
                            'fecha_factura' => $facturas[$i]['fecha_factura'],
                            'fecha_vencimiento' => $facturas[$i]['fecha_vencimiento_factura'],
                            'monto_factura' => $facturas[$i]['monto_factura'],
                            'descripcion_factura'  => $facturas[$i]['descripcion_factura'],
                        ]);
    
                        $facturas[$i]['status'] = 200;
                        $facturas[$i]['message'] = 'La Factura Fue Agregada';
                    }
                }else{
                    $facturas[$i]['status'] = 422;
                    $facturas[$i]['message'] = 'El valor Id factura ya se encuentra en uso.';
                }
               
            }
        }//fin for

        return response()->json([
            'status' => 200,
            'results' => $facturas
        ], 200);
    }
}
