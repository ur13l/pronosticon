<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Liga;
use App\Quiniela;
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
    return view('ligas.index', ['ligas' => $ligas]);
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
    $ligas = Liga::all();
    $tipo_quiniela = TipoQuiniela::all();
    return view('ligas.nueva');
}

/**
 * Devuelve la vista de editar una liga.
 *
 * @param Request $request
 * @return Response
 */
 public function editar($id) {   
     $liga = Liga::find($id);
     return view('ligas.editar', ['liga' => $liga]);
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
         "bolsa" => "required"
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

    $bolsa = Bolsa::create([
         'cantidad' => $request->bolsa,
         'id_quiniela' => $quiniela->id
     ]);


    return redirect()->route('quinielas.index');
}


}
