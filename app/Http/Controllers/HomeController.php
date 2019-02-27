<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class HomeController extends Controller
{
    /**
     * Devuelve el index, ya sea vista de jugador o administrador.
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request) {
        $codigo = $request->session()->get('codigo', '');
        $usuario = User::where('codigo', $codigo)->first();
        if($usuario->admin) {
            return view('home.admin', ['usuario' => $usuario]);
        }
        return view('home.jugador', ['usuario' => $usuario]);
    }
}
