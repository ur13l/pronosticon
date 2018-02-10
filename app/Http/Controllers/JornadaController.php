<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jornada;
use Auth;
use App\Equipo;
use App\Resultado;
use App\Usuario;
use App\Quiniela;
use App\Liga;
use App\Partido;
use Carbon\Carbon;

/**
 * Controlador de jornadas
 */
class JornadaController extends Controller
{
    /**
    * Método que devuelve la vista para crear una nueva jornada.
    *
    * @param Request $request
    * @return Response
    */
    public function nuevo(Request $request) {
        $liga = Liga::find($request->id_liga);
        $codigo = $request->session()->get('codigo','');
        $usuario = Usuario::where('codigo', $codigo)->first();
        return view('jornadas.detalle', ['jornada' => null, 'liga' => $liga, 'usuario' => $usuario]);
    }

    /**
    * Método que devuelve la vista para editar una jornada.
    *
    * @param Integer $id
    * @return Response
    */
    public function editar(Request $request, $id) {
        $jornada = Jornada::find($id);
        $liga = Liga::find($jornada->id_liga);
        $codigo = $request->session()->get('codigo','');
        $usuario = Usuario::where('codigo', $codigo)->first();
        return view('jornadas.detalle', ['jornada' => $jornada, 'liga' => $liga, 'usuario' => $usuario]);
    }

    /**
    * Método para crear o actualizar una jornada.
    *
    * @param Request $request
    * @return Response
    */
    public function createOrUpdate(Request $request) {
        $another= false;
        $rules = [
            "nombre" => "required",
            "id_liga" => "required",
            "fecha_inicio" => "required",
            "fecha_fin" => "required"
        ];
        $request->validate($rules);

        $jornada = Jornada::find($request->id);
        if(!$jornada) {
            $jornada = new Jornada();
            $another = true;
        }

        $jornada->nombre = $request->nombre;
        $jornada->id_liga = $request->id_liga;
        $fecha_inicio = Carbon::createFromFormat('d/m/Y', $request->fecha_inicio);
        $fecha_inicio->hour = 0;
        $fecha_inicio->minute = 0;
        $fecha_inicio->second = 0;
        $jornada->fecha_inicio = $fecha_inicio;
        $fecha_fin = Carbon::createFromFormat('d/m/Y', $request->fecha_fin);
        $fecha_fin->hour = 23;
        $fecha_fin->minute = 59;
        $fecha_fin->second = 59;
        $jornada->fecha_fin = $fecha_fin;
        $jornada->save();

        if($another) {
            return redirect('/jornadas/editar/partidos/' . $jornada->id);
        }
        return redirect('/jornadas/editar/partidos/' . $jornada->id);
    }

    /**
     * Método para eliminar una jornada
     * 
     * @param Request $request
     * @return Response
     */
    public function eliminar(Request $request) {
        $jornada = Jornada::find($request->id);
        
        foreach($jornada->partidos as $partido) {
            foreach($jornada->participacionesJornada as $pj) {
                foreach($pj->pronosticos as $pronostico) {
                    $pronostico->delete();
                }
                $pj->delete();
            }
            Resultado::whereIn('id_partido',[$partido->id])->delete();
        }
        Partido::whereIn('id_jornada',[$jornada->id])->delete();
 
        $id_liga = $jornada->id_liga;
        $jornada->delete();

        foreach($jornada->liga->quinielas as $quiniela) {
            foreach($quiniela->participacions as $participacion) {
                $participacion->calcularPuntuacion();
            }
        }
        return redirect('/ligas/editar/' . $id_liga);
    
    }

    /**
     * Devuelve la vista para editar los partidos de una jornada.
     *
     * @param Integer $id
     * @return Response
     */
    public function editarPartidos($id, Request $request) {
        $jornada = Jornada::find($id);
        $today = Carbon::now('America/Mexico_City');
        $fechas = [];
        $from = Quiniela::find($request->from);
        $codigo = $request->session()->get('codigo','');
        $usuario = Usuario::where('codigo', $codigo)->first();
        
        for($date = $jornada->fecha_inicio; $date->lte($jornada->fecha_fin); $date->addDay()) {
            $fechas[] = $date->format('d/m/Y');
        }
        
        return view('jornadas.partidos', ["jornada" => $jornada, "fechas" => $fechas, 'today' => $today, 'f' => $from, 'usuario' => $usuario]);
    }

    /**
     * Devuelve la vista para editar los resultados de una jornada.
     *
     * @param Integer $id
     * @return Response
     */
    public function editarResultados($id, Request $request) {
        $jornada = Jornada::find($id);
        $today = Carbon::now('America/Mexico_City');
        $from = Quiniela::find($request->from);
        $codigo = $request->session()->get('codigo','');
        $usuario = Usuario::where('codigo', $codigo)->first();
        return view('jornadas.resultados', ["jornada" => $jornada, 'today' => $today, 'f' => $from, 'usuario' => $usuario]);
    }

    /**
     * Método POST para actualizar la lista de equipos cargada desde la vista.
     * 
     * @param Request $request
     * @return Response
     */
    public function actualizarEquipos(Request $request) {
        $jornada = Jornada::find($request->id_jornada);
        if($request->id_equipo_local) {
            foreach($request->id_equipo_local as $key => $id_equipo_local) {
                $p = Partido::create([
                    'id_equipo_local' => $request->id_equipo_local[$key],
                    'id_equipo_visita' => $request->id_equipo_visita[$key],
                    'id_jornada' => $request->id_jornada,
                    'fecha_hora' => Carbon::createFromFormat('d/m/Y H:i', $request->fecha[$key] . " " . $request->hora[$key])
                ]);

                if($p->fecha_hora < $jornada->fecha_inicio || $key == 0) {
                    $jornada->fecha_inicio  = $p->fecha_hora;
                    $jornada->save();
                }
                if($p->fecha_hora > $jornada->fecha_inicio || $key == 0) {
                    $jornada->fecha_fin  = $p->fecha_hora;
                    $jornada->save();                    
                }
            }
        }

        if($request->id_equipo_local_mod) {
            foreach($request->id_equipo_local_mod as $key => $id_equipo_local) {
                $partido = Partido::find($request->id_partido_mod[$key]);
                $partido->id_equipo_local = $request->id_equipo_local_mod[$key];
                $partido->id_equipo_visita = $request->id_equipo_visita_mod[$key];
                $partido->id_jornada = $request->id_jornada;
                $partido->fecha_hora = Carbon::createFromFormat('d/m/Y H:i', $request->fecha_mod[$key] . " " . $request->hora_mod[$key], 'America/Mexico_City');
                $partido->save();
            }
        }

        $id_partidos_eliminar = json_decode($request->id_partidos_eliminar);
        if($id_partidos_eliminar) {
            foreach ($id_partidos_eliminar as $id_partido) {
                $partido = Partido::find($id_partido);
                $partido->delete();
            }
        }

        return redirect('/ligas/editar/'. $jornada->liga->id);
    }

    /**
     * Función que actualiza los resultados de una jornada
     * (Además calcula los resultados en las quinielas participantes.)
     *
     * @param Request $request
     * @return Response
     */
    public function actualizarResultados(Request $request) {
        $id_resultado = $request->id_resultado;
        $id_partido = $request->id_partido;
        $resultado_local = $request->resultado_local;
        $resultado_visita = $request->resultado_visita;
        $jornada = Jornada::find($request->id_jornada);
        foreach($id_resultado as $key=>$item) {
            if($resultado_local[$key] != null && $resultado_visita[$key] != null){
                $partido = Partido::find($id_partido[$key]);
                $id_equipo_ganador = null;
                if($resultado_local[$key] > $resultado_visita[$key]){
                    $id_equipo_ganador = $partido->equipoLocal->id;
                }
                else if($resultado_local[$key] < $resultado_visita[$key]){
                    $id_equipo_ganador = $partido->equipoVisita->id;
                }

                $data = [
                    'id_partido' => $id_partido[$key],
                    'resultado_local' => $resultado_local[$key],
                    'resultado_visita' => $resultado_visita[$key],
                    'id_equipo_ganador' => $id_equipo_ganador
                ];

                $resultado = Resultado::find($item);
                //Cuando se tiene que actualizar el resultado
                if($resultado) {
                    $resultado->update($data);
                }
                //Cuando se genera un resultado nuevo.
                else {            
                    $resultado = Resultado::create($data);
                }

                $resultado->partido->jornada->registrada = true;
                $resultado->partido->jornada->save();
            }
        }

        $jornada->calcularPuntuaciones();
        return redirect('/ligas/editar/' . $partido->jornada->liga->id);

    }

}
