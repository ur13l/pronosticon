<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Usuario;

class UsuarioController extends Controller
{
    /**
     * Muestra el dashboard de usuarios para el administrador
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request) {
        $usuarios = Usuario::paginate(9);
        return view('usuarios.index', ['usuarios' => $usuarios]);
    }

    /**
     * Método llamado por AJAX para devolver la lista de usuarios
     *
     * @param Request $request
     * @return void
     */
    public function buscar(Request $request){
        $q = $request->q;
        $usuarios = Usuario::where('nombre', 'like', "%$q%")->paginate(9);      
        return View::make('usuarios.lista', ['usuarios' => $usuarios])->render();      
      }
   
}
