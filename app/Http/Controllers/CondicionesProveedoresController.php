<?php

namespace App\Http\Controllers;

use App\Models\CondicionesProveedores;
use Illuminate\Http\Request;

class CondicionesProveedoresController extends Controller
{
    
    public function all()
    {
        $cond = CondicionesProveedores::where('eliminado', '=', false)->get()->toArray();

        return response()->json([
            'status' => 200,
            'results' => $cond
        ], 200);
    }
}
