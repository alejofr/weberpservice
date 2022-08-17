<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ApiAuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);     

        if ($validator->fails()) {
            return response()->json([
                'status' => 403,
                'message' => $validator->errors()->first(),
            ], 403);
        }

        if (!$token=Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json([
                'status' => 401,
                'message' => 'Correo Electronico o Contraseña Incorrectas.'
            ], 401);
        }

        $tokenResult = $request->user()->createToken('Personal Access Token');

        $token = $tokenResult->token;        
        if ( !isset($request->remember)) {
            $token->expires_at = Carbon::now()->addDay(1);
        }        
        $token->save(); 

        return response()->json([
            'status' => 200,
            'access_token' => $tokenResult->accessToken,
            'token_type'   => 'Bearer',
            'expires_at'   => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString()
        ], 200);
    }

    public function user(Request $request){
        return response()->json([
            'status' => 200,
            'user' => $request->user(),
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();   
        return response()->json([
            'status' => 200,
            'message' => 'Cerraste sesión',
        ], 200);
    }
}
