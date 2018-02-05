<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Liga;
use App\Quiniela;
use App\Deporte;
use App\Usuario;
use Auth;
use Carbon\Carbon;

class LigaController extends Controller
{
     /**
    * Muestra el dashboard de ligas para el administrador
    *
    * @param Request $request
    * @return Response
    */
   public function index(Request $request) {
    $ligas = Liga::paginate(9);
    $codigo = $request->session()->get('codigo','');
    $usuario = Usuario::where('codigo', $codigo)->first();
    return view('ligas.index', ['ligas' => $ligas, 'usuario' => $usuario]);
}

/**
 * Método llamado por AJAX para devolver la lista de ligas
 *
 * @param Request $request
 * @return Response
 */
public function buscar(Request $request){
    $q = $request->q;
    $ligas = Liga::where('nombre', 'like', "%$q%")->paginate(9);      
    return View::make('ligas.lista', ['ligas' => $ligas])->render();      
  }

/**
 * Método que devuelve la vista para crear un nuevo quiniela.
 *
 * @param Request $request
 * @return Response
 */
public function nuevo(Request $request) {
    $deportes = Deporte::all();
    $codigo = $request->session()->get('codigo','');
    $usuario = Usuario::where('codigo', $codigo)->first();
    return view('ligas.detalle', ['deportes' => $deportes, 'liga' => null, 'usuario' => $usuario]);
}


/**
 * Método que devuelve la vista para editar los datos de una liga.
 *
 * @param Request $request
 * @return Response
 */
public function detalle(Request $request, $id) {
    $deportes = Deporte::all();
    $liga = Liga::find($id);
    $codigo = $request->session()->get('codigo','');
    $usuario = Usuario::where('codigo', $codigo)->first();
    return view('ligas.detalle', ['deportes' => $deportes, 'liga' => $liga, 'usuario' => $usuario]);
}

/**
 * Devuelve la vista de editar una liga.
 *
 * @param Request $request
 * @return Response
 */
 public function editar(Request $request, $id) {   
     $liga = Liga::find($id);
     $codigo = $request->session()->get('codigo','');
     $usuario = Usuario::where('codigo', $codigo)->first();
     return view('ligas.editar', ['liga' => $liga, 'usuario'=> $usuario]);
}

/**
    * Método para crear o actualizar a un equipo.
    *
    * @param Request $request
    * @return Response
    */
    public function createOrUpdate(Request $request) {
         $rules = [
             "nombre" => "required",
             "id_deporte" => "required",
             "logo" => "required",
             "imagen" => "required"
         ];
         $request->validate($rules);
    
         $liga = Liga::find($request->id);
         if(!$liga) {
            $liga = new Liga();
         }
        
        if($request->file("logo")) {
            Storage::delete($liga->logo);
            $logo = $request->file("logo")->store('ligas');
            $liga->logo = url('storage/' . $logo);
        }

        if($request->file("imagen")) {
            Storage::delete($liga->imagen);
            $imagen = $request->file("imagen")->store('equipos');
            $liga->imagen = url('storage/' .$imagen);
        }
        $liga->nombre = $request->nombre;
        $liga->id_deporte = $request->id_deporte;
        $liga->save();
    
        return redirect('/ligas');
    }
    
        /** */
        public function eliminar(Request $request) {
            $liga = Liga::find($request->id);
            $id_liga = $liga->id_liga;

            foreach($liga->jornadas as $jornada) {
                foreach ($jornada->partidos as $partido) {
                    if($partido->resultado) {
                        $partido->resultado->delete();
                    }

                    foreach($partido->pronosticos as $pronostico) {
                        $pronostico->delete();
                    }
                    $partido->delete();
                }

                foreach($jornada->participacionesJornada as $pj) {
                    $pj->delete();
                }
                $jornada->delete();
            }

            foreach($liga->equipos as $equipo) {
                $equipo->delete();
            }

            foreach($liga->quinielas as $quiniela) {
                foreach($quiniela->participacions as $participacion) {
                    foreach($participacion->participacionJornadas as $pj) {
                        $pj->delete();
                    }
                    $participacion->delete();
                }
                foreach($quiniela->bolsas as $bolsa) {
                    $bolsa->delete();
                }
                $quiniela->delete();
            }

            $liga->delete();
            return redirect('/ligas');
    
        }

        public function eliminarJornadas(Request $request) {
            $liga = Liga::find($request->id);
            $id_liga = $liga->id;

            foreach($liga->jornadas as $jornada) {
                foreach ($jornada->partidos as $partido) {
                    if($partido->resultado) {
                        $partido->resultado->delete();
                    }

                    foreach($partido->pronosticos as $pronostico) {
                        $pronostico->delete();
                    }
                    $partido->delete();
                }

                foreach($jornada->participacionesJornada as $pj) {
                    $pj->delete();
                }
                $jornada->delete();
            }

            return redirect('/ligas/editar/' . $id_liga);
        }

}
