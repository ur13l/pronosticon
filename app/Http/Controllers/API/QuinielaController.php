<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ParticipacionResource ;
use App\Http\Resources\QuinielaFullResource ;
use App\User;
use App\Quiniela;
use Auth;

/**
 * @group Quinielas
 */
class QuinielaController extends Controller
{
    /**
     * Index
     * Devuelve el index, ya sea vista de jugador o administrador.
     *
     * @param Request $request
     * @return ParticipacionResourceCollection
     */
    public function index(Request $request) {
        $user = Auth::guard('api')->user();
        return ParticipacionResource::collection($user->participacions);
    }


    /**
     * Detalle Quiniela
     * Devuelve el detalle de una quiniela dando su ID como entrada.
     * 
     * @param int $id_quiniela
     * @return QuinielaFullResource
     */
    public function detalleQuiniela($id_quiniela) {
        $quiniela = Quiniela::find($id_quiniela);
        return new QuinielaFullResource($quiniela);
    }
}
