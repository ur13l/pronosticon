<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Usuario;

class LoginController extends Controller
{
    
    /**
     * Método post que procesa el logueo.
     *
     * @param Request $request
     * @return void
     */
    public function login(Request $request) {
        $codigo = $request->codigo;
        $usuario = Usuario::where('codigo', $codigo)->first();
        if($usuario) {
            $usuario->token_ = $usuario->createToken('Pronosticon')->accessToken;
            return new UserResource($usuario);
        }
        return response()->json(['error' => 'error']);
    }
}
