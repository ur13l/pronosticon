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
        $jornada = Jornada::find($request->id);
        dd($request);
        foreach($request->id_equipo_local as $key => $id_equipo_local) {
            
        }
    }

}
