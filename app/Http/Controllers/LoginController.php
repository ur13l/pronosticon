<?php

namespace App\Http\Controllers;

use App\Usuario;
use Illuminate\Http\Request;

class LoginController extends Controller
{
     /**
     * Método que devuelve la vista de login
     *
     * @param Request $request
     * @return void
     */
    public function login(Request $request) {
        $redirectTo = $request->redirectTo;
        return view('login.login', ['redirectTo' => $redirectTo]);
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
            if($request->redirectTo) {
                return redirect()->route($request->redirectTo);
            }
            return redirect('/');
        }
        $request->flash();
        $errors = ['El código de usuario no es válido.'];
        return back()->withInput()->withErrors($errors);
    }


    /**
     * Servicio para controlar el cierre de sesión.
     *
     * @param Request $request
     * @return void
     */
    public function logout(Request $request) {
        $request->session()->forget('codigo');    
        return redirect()->route('login');
    }
}
