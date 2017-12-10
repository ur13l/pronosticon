<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\View;
use App\Quiniela;
use App\TipoQuiniela;
use App\Bolsa;
use App\Liga;
use App\Participacion;

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

        $bolsa = Bolsa::where('id_quiniela', $request->id_quiniela)->first();
        if(!$bolsa) {
            $bolsa = Bolsa::create([
                "id_quiniela" => $request->id_quiniela,
                "cantidad" => $request->cantidad
            ]);
        }
        $bolsa->cantidad = $request->cantidad;
        $bolsa->save();

        return back();
   }
 
}
