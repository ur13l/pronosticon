<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Http\Resources\UserResource;

/**
 * @group Usuario
 */
class UsuarioController extends Controller
{
    

    /**
     * Usuario: Perfil
     * Devuelve el perfil de un usuario mediante un token
     * params: []
     */
    public function perfil(Request $request) {
        $u = Auth::guard('api')->user();
        return new UserResource($u);
    }
}
