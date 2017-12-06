<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\View;
use App\Quiniela;

class QuinielaController extends Controller
{
    /**
    * Muestra el dashboard de quinielas para el administrador
    *
    * @param Request $request
    * @return void
    */
   public function index(Request $request) {
       $quinielas = Quiniela::paginate(9);
       return view('quinielas.index', ['quinielas' => $quinielas]);
   }

   /**
    * Método llamado por AJAX para devolver la lista de quinielas
    *
    * @param Request $request
    * @return void
    */
   public function buscar(Request $request){
       $q = $request->q;
       $quinielas = Quiniela::where('nombre', 'like', "%$q%")->paginate(9);      
       return View::make('quinielas.lista', ['quinielas' => $quinielas])->render();      
     }

   /**
    * Método que devuelve la vista para crear un nuevo quiniela.
    */
   public function nuevo(Request $request) {
       $random = str_random(9);
       return view('quinielas.detalle', ['quiniela' => null, 'random' => $random]);
   }

   public function editar($id) {
       $quiniela = Quiniela::find($id);
       return view('quinielas.detalle', ['quiniela' => $quiniela]);
   }

   /**
    * Método para crear o actualizar a un quiniela.
    */
   public function createOrUpdate(Request $request) {
       $quiniela = Quiniela::find($request->id);
       if($quiniela) {
           $rules = [
               "nombre" => "required",
               "email" => "required|email",
               "codigo" => "required"
           ];
           $request->validate($rules);
       }
       else {
           $rules = [
               "nombre" => "required",
               "email" => "required|unique:usuario",
               "codigo" => "required|unique:usuario"
           ];
           $request->validate($rules);
           $quiniela = new Quiniela();
       }
       
       $quiniela->nombre = $request->nombre;
       $quiniela->email = $request->email;
       $quiniela->codigo = $request->codigo;

       $quiniela->save();

       return redirect()->route('quinielas.index');
   }
}
