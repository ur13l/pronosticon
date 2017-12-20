<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jornada;
use Auth;
use App\Equipo;
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
        return view('jornadas.detalle', ['jornada' => null, 'liga' => $liga]);
    }

    /**
    * Método que devuelve la vista para editar una jornada.
    *
    * @param Integer $id
    * @return Response
    */
    public function editar($id) {
        $jornada = Jornada::find($id);
        $liga = Liga::find($jornada->id_liga);
        return view('jornadas.detalle', ['jornada' => $jornada, 'liga' => $liga]);
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
        $jornada->fecha_inicio = Carbon::createFromFormat('d/m/Y', $request->fecha_inicio);
        $jornada->fecha_fin = Carbon::createFromFormat('d/m/Y', $request->fecha_fin);
        $jornada->fecha_fin->hour = 23;
        $jornada->fecha_fin->minute = 59;
        $jornada->fecha_fin->second = 59;
        $jornada->save();

        if($another) {
            return redirect('/jornadas/partidos/' . $jornada->id_liga);
        }
        return redirect('/jornadas/partidos/' . $jornada->id_liga);
    }

    /**
     * Método para eliminar una jornada
     * 
     * @param Request $request
     * @return Response
     */
    public function eliminar(Request $request) {
        $jornada = jornada::find($request->id);
        $id_liga = $jornada->id_liga;
        $jornada->delete();
        return redirect('/ligas/editar/' . $id_liga);
    
    }

    /**
     * Devuelve la vista para editar los partidos de una jornada.
     *
     * @param Integer $id
     * @return Response
     */
    public function editarPartidos($id) {
        $jornada = Jornada::find($id);
        $fechas = [];
        
        for($date = $jornada->fecha_inicio; $date->lte($jornada->fecha_fin); $date->addDay()) {
            $fechas[] = $date->format('d/m/Y');
        }
        
        return view('jornadas.partidos', ["jornada" => $jornada, "fechas" => $fechas]);
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
                Partido::create([
                    'id_equipo_local' => $request->id_equipo_local[$key],
                    'id_equipo_visita' => $request->id_equipo_visita[$key],
                    'id_jornada' => $request->id_jornada,
                    'fecha_hora' => Carbon::createFromFormat('d/m/Y H:i', $request->fecha[$key] . " " . $request->hora[$key])
                ]);
            }
        }

        if($request->id_equipo_local_mod) {
            foreach($request->id_equipo_local_mod as $key => $id_equipo_local) {
                $partido = Partido::find($request->id_partido_mod[$key]);
                $partido->id_equipo_local = $request->id_equipo_local_mod[$key];
                $partido->id_equipo_visita = $request->id_equipo_visita_mod[$key];
                $partido->id_jornada = $request->id_jornada;
                $partido->fecha_hora = Carbon::createFromFormat('d/m/Y H:i', $request->fecha_mod[$key] . " " . $request->hora_mod[$key]);
                $partido->save();
            }
        }

        return back();
    }

}
