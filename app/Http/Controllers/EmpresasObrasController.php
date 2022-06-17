<?php

namespace App\Http\Controllers;

use App\Models\Empresas;
use App\Models\EmpresasGestionObras;
use Illuminate\Http\Request;
use Carbon\Carbon;

class EmpresasObrasController extends Controller
{
    public function store(Request $request)
    {
        $empresa = Empresas::find($request->id_empresa);
        $obra = new EmpresasGestionObras;

        $obra->id_empresa = $request->id_empresa;
        $obra->nombre = $request->nombre;
        $obra->clave = $request->clave;
        $obra->ceco = $empresa->clave.'-'.$request->clave;
        $obra->save();

        return response()->json([
            'status' => 200,
            'message' => 'La Obra '.$obra->nombre.' fue agregada con éxito',
        ], 200);
    }

    public function delete($id)
    {
        $obra = EmpresasGestionObras::find($id);

        $obra->eliminado = true;
        $obra->fecha_eliminado = Carbon::now();

        $obra->update();

        return response()->json([
            'status' => 200,
            'message' => 'La Obra '.$obra->nombre.' con la clave '.$obra->clave.' y el CECO '.$obra->ceco.' fue eliminado con éxito'
        ], 200);
    }

}
