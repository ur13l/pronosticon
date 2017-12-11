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
    * @param Request $request
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
}
