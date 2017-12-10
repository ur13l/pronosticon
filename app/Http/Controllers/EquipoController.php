<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Equipo;
use App\Liga;

class EquipoController extends Controller
{
    /**
    * Método que devuelve la vista para crear un nuevo equipo.
    *
    * @param Request $request
    * @return Response
    */
   public function nuevo(Request $request) {
        $liga = Liga::find($request->id_liga);
        return view('equipos.detalle', ['equipo' => null, 'liga' => $liga]);
    }

    /**
    * Método que devuelve la vista para editar un equipo.
    *
    * @param Request $request
    * @return Response
    */
    public function editar($id) {
        $equipo = Equipo::find($id);
        $liga = Liga::find($equipo->id_liga);
        return view('equipos.detalle', ['equipo' => $equipo, 'liga' => $liga]);
    }

    /**
    * Método para crear o actualizar a un equipo.
    *
    * @param Request $request
    * @return Response
    */
   public function createOrUpdate(Request $request) {
    $another= false;
     $rules = [
         "nombre" => "required",
         "id_liga" => "required",
         "siglas" => "required"
     ];
     $request->validate($rules);

     $equipo = Equipo::find($request->id);
     if(!$equipo) {
        $equipo = new Equipo();
        $another = true;
     }
    
    if($request->file("imagen")) {
        Storage::delete($equipo->imagen);
        $imagen = $request->file("imagen")->store('equipos');
        $equipo->imagen = $imagen;
    }
    $equipo->nombre = $request->nombre;
    $equipo->id_liga = $request->id_liga;
    $equipo->siglas = $request->siglas;
    $equipo->save();

    if($another) {
        return back();
    }
    return redirect('/ligas/editar/' . $equipo->id_liga);
}

    /** */
    public function eliminar(Request $request) {
        $equipo = Equipo::find($request->id);
        $id_liga = $equipo->id_liga;
        $equipo->delete();
        return redirect('/ligas/editar/' . $id_liga);

    }
}
