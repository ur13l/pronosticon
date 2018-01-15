<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\View;
use App\Quiniela;
use App\TipoQuiniela;
use App\Bolsa;
use App\Usuario;
use App\Jornada;
use App\Pronostico;
use App\Partido;
use App\Liga;
use Carbon\Carbon;
use App\Participacion;
use App\ParticipacionJornada;

class QuinielaController extends Controller
{
    /**
    * Muestra el dashboard de quinielas para el administrador
    *
    * @param Request $request
    * @return Response
    */
   public function index(Request $request) {
       $quinielas = Quiniela::paginate(9);
       return view('quinielas.index', ['quinielas' => $quinielas]);
   }

   /**
    * Método llamado por AJAX para devolver la lista de quinielas
    *
    * @param Request $request
    * @return Response
    */
   public function buscar(Request $request){
       $q = $request->q;
       $quinielas = Quiniela::where('nombre', 'like', "%$q%")->paginate(9);      
       return View::make('quinielas.lista', ['quinielas' => $quinielas])->render();      
     }

   /**
    * Método que devuelve la vista para crear un nuevo quiniela.
    *
    * @param Request $request
    * @return Response
    */
   public function nuevo(Request $request) {
       $ligas = Liga::all();
       $tipo_quiniela = TipoQuiniela::all();
       return view('quinielas.nueva', ['quiniela' => null, 'ligas' => $ligas, 'tipo_quiniela' => $tipo_quiniela]);
   }

  /**
    * Devuelve la vista de editar una quiniela.
    *
    * @param Request $request
    * @return Response
    */
    public function editar($id) {   
        $quiniela = Quiniela::find($id);
        return view('quinielas.editar', ['quiniela' => $quiniela]);
   }

   /**
    * Método para crear o actualizar a un quiniela.
    *
    * @param Request $request
    * @return Response
    */
   public function create(Request $request) {
       
        $rules = [
            "nombre" => "required|unique:quiniela",
            "id_liga" => "required",
            "id_tipo_quiniela" => "required",
            "bolsa1" => "required"
        ];
        $request->validate($rules);
        $quiniela = new Quiniela();
       
       $imagen = $request->file("imagen")->store('quinielas');
       $quiniela->nombre = $request->nombre;
       $quiniela->descripcion = $request->descripcion;
       $quiniela->id_liga = $request->id_liga;
       $quiniela->imagen = $request->imagen;
       $quiniela->id_tipo_quiniela = $request->id_tipo_quiniela;
       $quiniela->permitir_marcador = $request->permitir_marcador ? true : false;
       $quiniela->cantidad_reponches = $request->cantidad_reponches;
       $quiniela->save();

       $bolsa1 = Bolsa::create([
            'cantidad' => $request->bolsa1,
            'premio' => 1,
            'id_quiniela' => $quiniela->id
        ]);

        $bolsa2 = Bolsa::create([
            'cantidad' => $request->bolsa2,
            'premio' => 2,
            'id_quiniela' => $quiniela->id
        ]);

        $bolsa3 = Bolsa::create([
            'cantidad' => $request->bolsa3,
            'premio' => 3,
            'id_quiniela' => $quiniela->id
        ]);


       return redirect()->route('quinielas.index');
   }


   /**
    * Permite agregar un nuevo participante a la quiniela seleccionada.
    *
    * @param Request $request
    * @return void
    */
   public function agregarParticipante(Request $request) {
        $rules = [
            "id_usuario" => "required",
            "id_quiniela" => "required"
        ];
        $request->validate($rules);

        $part = Participacion::where('id_usuario', $request->id_usuario)
            ->where('id_usuario', $request->id_quiniela)->first();
        
        if(!$part) {
            Participacion::create($request->all() + [
                'puntuacion' => 0,
                'activo' => true,
                'no_reponches' => 0,
            ]);
        }
        return back();
   }


   /**
    * Método para actualizar la cantidad en la bolsa
    *
    * @param Request $request
    * @return Response
    */
   public function actualizarBolsa(Request $request) {
        $rules = [
            "cantidad" => "required",
            "id_quiniela" => "required"
        ];
        $request->validate($rules);

        foreach ($request->cantidad as $key => $cantidad) {
            $bolsa = Bolsa::find($request->id_bolsa[$key]);
            if(!$bolsa) {
                $bolsa = Bolsa::create([
                    "id_quiniela" => $request->id_quiniela,
                    "cantidad" => $request->cantidad
                ]);
            }
            $bolsa->cantidad = $cantidad;
            $bolsa->save();
        }
        

        return back();
   }
 
   /**
    * Método que devuelve la vista del usuario para contestar la jornada de una quiniela
    * 
    * @param Integer $id_jornada
    * @param Integer $codigo
    */
    public function contestar($id_jornada, $id_quiniela, Request $request) {
        $codigo = $request->session()->get('codigo','');
        $usuario = Usuario::where('codigo', $codigo)->first();
        $quiniela = Quiniela::find($id_quiniela);
        $participacion = Participacion::where('id_usuario', $usuario->id)->where('id_quiniela', $quiniela->id)->first();
        if($quiniela->usuarioParticipa($usuario)) {
            $jornada = Jornada::find($id_jornada);
            $participacionJornada = ParticipacionJornada::where('id_jornada', $id_jornada)->where('id_participacion', $participacion->id)->first();
            $today = Carbon::now('America/Mexico_City');
            return view('quinielas.contestar_regular', ['participacion_jornada'=> $participacionJornada, 'liga' => $jornada->liga, 'participacion' => $participacion, 'usuario' => $usuario, 'quiniela' => $quiniela, 'jornada' => $jornada, 'today' => $today]);
       }
       else {
            //TODO: Error cuando el usuario no participa en la quiniela.
       }
        
   }

   /**
    * Método POST que recibe las respuestas de la quiniela y las guarda.
    *
    * @param Request $request
    * @return Response
    */
   public function contestarQuiniela(Request $request) {
        //Se comprueba si la quiniela tiene resultados
        $id_participacion = $request->id_participacion;
        $id_jornada = $request->id_jornada;
        $participacion = Participacion::find($id_participacion);
        $quiniela = $participacion->quiniela;
        $today = Carbon::now('America/Mexico_City');
        $participacionJornada = ParticipacionJornada::where('id_participacion', $id_participacion)
            ->where('id_jornada', $id_jornada)->first();
        if(!$participacionJornada) {
            $participacionJornada = ParticipacionJornada::create([
                'id_participacion' => $id_participacion,
                'id_jornada' => $id_jornada,
                'registrada' => false
            ]);
        }
        
        if (!$participacionJornada->registrada) {

            $data = [];
            $data['id_participacion_jornada'] = $participacionJornada->id;
            $data['id_participacion'] = $id_participacion;
            if($quiniela->tipoQuiniela->nombre != "Survivor") {
                foreach($request->id_partido as $key => $dummy) {

                    $id_partido = $request->id_partido[$key];
                    $partido = Partido::find($id_partido);
                    
                    if($today->lt($partido->fecha_hora)) {
                        $data['fecha'] = Carbon::now('America/Mexico_City');

                        if ($quiniela->permitir_marcador) {
                            $data['resultado_local'] = $request->resultado_local[$key];
                            $data['resultado_visita'] = $request->resultado_visita[$key];
                            if($request->resultado_local[$key] > $request->resultado_visita[$key]){
                                $data['id_equipo_ganador'] = $partido->equipoLocal->id;
                            }
                            else if($request->resultado_local[$key] < $request->resultado_visita[$key]){
                                $data['id_equipo_ganador'] = $partido->equipoVisita->id;
                            }
                        }
                        else {
                            $equipo_ganador =  $request->id_equipo_ganador[$key];
                            if($equipo_ganador != "empate") {
                                $data['id_equipo_ganador'] = $request->id_equipo_ganador[$key];
                            }
                            else {
                                $data['id_equipo_ganador'] = null;
                            }
                        }
                        
                       


                        $pronostico = Pronostico::where('id_partido', $id_partido)
                            ->where('id_participacion', $id_participacion)->first();
                        //Si el usuario ya había contestado
                        if($pronostico) {
                            $pronostico->update($data);

                        }
                        else{
                            $data['puntos'] = 0;
                            $data['id_partido'] = $request->id_partido[$key];
                            Pronostico::create($data);
                        }
                    }
                }
            }
            //SURVIVOR
            else {
                $data['id_partido'] = $request->id_partido_survivor;
                $data['fecha'] = Carbon::now('America/Mexico_City');
                $id_equipo_ganador = $request->id_equipo_ganador_survivor;
                if($id_equipo_ganador != "empate") {
                    $data['id_equipo_ganador'] = $id_equipo_ganador;
                }
                else {
                    $data['id_equipo_ganador'] = null;
                }
                $pronostico = Pronostico::where('id_partido', $request->id_partido_survivor)
                ->where('id_participacion', $request->id_participacion_survivor)->first();
            
                //Si el usuario ya había contestado
                if($pronostico) {
                    $pronostico->update($data);
                }
                else{
                    $data['puntos'] = 0;
                    Pronostico::create($data);
                }
            }
        }

        $participacionJornada->registrada = true;
        $participacionJornada->save();
        return redirect('/');
    }



    public function info($id, Request $request) {
        $codigo = $request->session()->get('codigo','');
        $usuario = Usuario::where('codigo', $codigo)->first();
        $quiniela = Quiniela::find($id);
        $participacion = Participacion::where('id_quiniela', $quiniela->id)->where('id_usuario', $usuario->id)->first();
        $posicion = $participacion->calcularPosicion();
        if($quiniela->liga->ultimaJornada) {
            $participacionJornada = ParticipacionJornada::where('id_participacion', $participacion->id)
            ->where('id_jornada', $quiniela->liga->ultimaJornada->id)->first();
        }
        else {
            $participacionJornada = null;
        }
        return view('quinielas.info', ['participacion_jornada' => $participacionJornada, 'posicion' => $posicion, 'quiniela' => $quiniela, 'usuario' => $usuario, 'participacion' => $participacion]);
    }


    public function datosJornada(Request $request) {
        $participacionJornada = ParticipacionJornada::where('id_participacion', $request->id_participacion)
            ->where('id_jornada', $request->id_jornada)->first();
        $quiniela = $participacionJornada ? $participacionJornada->participacion->quiniela : null;
        return view('quinielas.items.datos_jornada', ['participacion_jornada'=>$participacionJornada, 'quiniela' => $quiniela ]);

    }
}
