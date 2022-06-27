<?php

namespace App\Http\Controllers;

use App\Models\Paises;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class PaisesController extends Controller
{

    public function index()
    {
        $select = [
            'id_pais',
            'id_pais_erp',
            'nombre', 
            'nacionalidad_pais' 
        ];

        extract(request()->only(['query', 'limit', 'page', 'orderBy', 'ascending',]));

        $limit = (isset($limit) && $limit != '') ? $limit : 8;
        $page = (isset($page) && $page != 1) ? $page : 1;
        $query = isset($query) ? json_decode($query) : null;

        $this->search = ( $query != null && isset($query->search) && $query->search != '' ) ? $query->search : "";

        $records = DB::table('wse_paises')->where('eliminado', '=', false)
            ->Where(function($query) {
                $query->orWhere('nombre',  'LIKE', '%'.$this->search.'%')
                ->orWhere('nacionalidad_pais',  'LIKE', '%'.$this->search.'%');
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

    public function paisesAll()
    {
        return response()->json([
            'status' => 200,
            'results' => Paises::where('eliminado', '=', false)->get()->toArray(),
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_pais_erp' =>  ['required'],
            'nombre' => ['required', 'unique:wse_paises'],
            'nacionalidad_pais' => ['required', 'unique:wse_paises']
        ]);

        if ( isset($validator) && $validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $pais = new Paises;

        $pais->id_pais_erp = $request->id_pais_erp;
        $pais->nombre = $request->nombre;
        $pais->nacionalidad_pais = $request->nacionalidad_pais;

        $pais->save();

        return response()->json([
            'status' => 200,
            'message' => 'El Pais '.$pais->nombre.' fue agregado con éxito'
        ], 200);
    }

    public function edit($id)
    {
        $pais = Paises::where('id_pais', '=', $id)
        ->where('eliminado', '=', false)
        ->select([
            'id_pais',
            'id_pais_erp',
            'nombre',
            'nacionalidad_pais',
        ])->first();

        return response()->json([
            'status' => 200,
            'results' => $pais
        ], 200);
    }

    public function update($id, Request $request)
    {
        $pais = Paises::find($id);

        if( $request->nombre != $pais->nombre){
            $validator = Validator::make($request->all(), [
                'nombre' => ['required','unique:wse_paises'],
            ]);
        }

        if( $request->nacionalidad_pais != $pais->nacionalidad_pais ){
            $validator = Validator::make($request->all(), [
                'nacionalidad_pais' => ['required', 'unique:wse_paises'],
            ]);
        }

        $validator = Validator::make($request->all(), [
            'id_pais_erp' =>  ['required'],
        ]);


        if ( isset($validator) && $validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $nombre =  $pais->nombre;
        $pais->id_pais_erp = ( $request->id_pais_erp != $pais->nombre ) ? $request->id_pais_erp : $pais->id_pais_erp;
        $pais->nombre = ( $request->nombre != $pais->nombre ) ? $request->nombre : $pais->nombre;
        $pais->nacionalidad_pais = ( $request->nacionalidad_pais != $pais->nacionalidad_pais ) ? $request->nacionalidad_pais : $pais->nacionalidad_pais;

        $pais->update();

        return response()->json([
            'status' => 200,
            'message' => 'El pais '.$nombre.' fue actualizada con éxito'
        ], 200);
        
    }

    public function delete($id)
    {
        $pais = Paises::find($id);

        $pais->eliminado = true;
        $pais->fecha_eliminado = Carbon::now();

        $pais->update();

        return response()->json([
            'status' => 200,
            'message' => 'El pais '. $pais->nombre.' fue eliminado con éxito'
        ], 200);
    }
}
