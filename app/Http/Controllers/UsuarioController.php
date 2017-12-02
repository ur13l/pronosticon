<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Usuario;

class UsuarioController extends Controller
{
    
    /**
     * Método que devuelve la vista de login
     *
     * @param Request $request
     * @return void
     */
    public function login(Request $request) {
        return view('usuarios.login');
    }

    /**
     * Devuelve el index, ya sea vista de jugador o administrador.
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request) {
        $codigo = $request->session()->get('codigo', '');
        $usuario = Usuario::where('codigo', $codigo)->first();
        if($usuario->admin) {
            return view('usuarios.home.admin');
        }
        return view('usuarios.home.jugador');
    }

    /**
     * Método post que procesa el logueo.
     *
     * @param Request $request
     * @return void
     */
    public function signIn(Request $request) {
        $codigo = $request->codigo;
        $usuario = Usuario::where('codigo', $codigo)->first();
        if($usuario) {
            $request->session()->put('codigo', $codigo);
            return redirect('/');
        }
        $request->flash();
        $errors = ['El código de usuario no es válido.'];
        return back()->withInput()->withErrors($errors);
    }
}
