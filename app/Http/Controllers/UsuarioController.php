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
        $codigo = $request->session()->get('codigo','');
        $usuario = Usuario::where('codigo', $codigo)->first(); 
        return view('usuarios.index', ['usuarios' => $usuarios, 'usuario' => $usuario]);
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
        $codigo = $request->session()->get('codigo','');
        $usuario = Usuario::where('codigo', $codigo)->first(); 
        return view('usuarios.detalle', ['user' => null, 'random' => $random, 'usuario' => $usuario]);
    }

    public function editar(Request $request, $id) {
        $user = Usuario::find($id);
        $codigo = $request->session()->get('codigo','');
        $usuario = Usuario::where('codigo', $codigo)->first(); 
        return view('usuarios.detalle', ['user' => $user, 'usuario'=> $usuario]);
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
                "codigo" => "required",
                'avatar' => 'required'
            ];
            $request->validate($rules);
        }
        else {
            $rules = [
                "nombre" => "required",
                "codigo" => "required|unique:usuario",
                'avatar' => 'required'
            ];
            
            $request->validate($rules);
            $usuario = new Usuario();
        }


        $codigo = $request->session()->get('codigo','');
        $u = Usuario::where('codigo', $codigo)->first(); 
        
        if($u->admin) {
            $usuario->nombre = $request->nombre;
            $usuario->email = $request->email;
            $usuario->codigo = $request->codigo;
        }
        $usuario->avatar = $request->avatar;
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
        foreach ( $usuarios as $usuario ) {
            $x = true;
            foreach($usuario->participacions as $participacion) {
                if($participacion->id_quiniela == $request->id_quiniela) {
                     $x = false;
                }
            }
            if($x) {
                $usuariosFormat[] = [
                    "label" => $usuario->nombre,
                    "value" => $usuario->id
                ];
            }
        }

        return response()->json($usuariosFormat);
    }   


    /**
     * Método para eliminar a un usuario.
     */
    public function eliminar(Request $request) {
        $u = Usuario::find($request->id);
        foreach($u->participacions as $participacion) {
            foreach($participacion->participacionJornadas as $pj) {
                foreach($pj->pronosticos as $pronostico) {
                    $pronostico->delete();
                }
                $pj->delete();
            }
            $participacion->delete();
        }
        $u->delete();
        return back();
    }
   
}
