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
     * @return Response
     */
    public function index(Request $request) {
        $usuarios = Usuario::paginate(9);
        return view('usuarios.index', ['usuarios' => $usuarios]);
    }

    /**
     * Método llamado por AJAX para devolver la lista de usuarios
     *
     * @param Request $request
     * @return Response
     */
    public function buscar(Request $request){
        $q = $request->q;
        $usuarios = Usuario::where('nombre', 'like', "%$q%")->paginate(9);      
        return View::make('usuarios.lista', ['usuarios' => $usuarios])->render();      
      }

    /**
     * Método que devuelve la vista para crear un nuevo usuario.
     */
    public function nuevo(Request $request) {
        $random = str_random(9);
        return view('usuarios.detalle', ['usuario' => null, 'random' => $random]);
    }

    public function editar($id) {
        $usuario = Usuario::find($id);
        return view('usuarios.detalle', ['usuario' => $usuario]);
    }

    /**
     * Método para crear o actualizar a un usuario.
     * 
     * @param Request $request
     * @return Response
     */
    public function createOrUpdate(Request $request) {
        $usuario = Usuario::find($request->id);
        if($usuario) {
            $rules = [
                "nombre" => "required",
                "email" => "required|email",
                "codigo" => "required"
            ];
            $request->validate($rules);
        }
        else {
            $rules = [
                "nombre" => "required",
                "email" => "required|unique:usuario",
                "codigo" => "required|unique:usuario"
            ];
            $request->validate($rules);
            $usuario = new Usuario();
        }
        
        $usuario->nombre = $request->nombre;
        $usuario->email = $request->email;
        $usuario->codigo = $request->codigo;

        $usuario->save();

        return redirect()->route('usuarios.index');
    }

    /**
     * Método que devuelve la lista de usuarios en formato para mostrarse en el autocomplete de jQueryUI
     *
     * @param Request $request
     * @return Response
     */
    public function autocomplete(Request $request) {
        $usuarios = Usuario::where('usuario.nombre', 'like', '%' . $request->term . '%')
        ->select(['usuario.nombre', 'usuario.id'])->get();
        
        $usuariosFormat = [];
        foreach($usuarios as $usuario) {
            $usuariosFormat[] = [
                "label" => $usuario->nombre,
                "value" => $usuario->id
            ];
        }

        return response()->json($usuariosFormat);
    }   
   
}
