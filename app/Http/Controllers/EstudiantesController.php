<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use Illuminate\Http\Request;

class EstudiantesController extends Controller
{
    public function index(){
      return Estudiante::all();
    }
    
    public function store(Request $request){
      $inputs = $request -> input();
      $respuesta = Estudiante::create($inputs);
      return response()->json(['data'=> $inputs, 'mensaje' => 'Estudiante encontrado.']);
    }
    public function update(Request $request, $id){
      $e = Estudiante::find($id);
      if (isset($e)){
        $e->nombre = $request->nombre;
        $e->apellido = $request->apellido;
        $e->foto = $request->foto;
        if($e->save()){
          return response()->json(['data'=> $e, 'mensaje' => 'Estudiante actualizado con éxito.']);
        }
      }else{
        return response()->json(['error'=> true, 'mensaje' => 'No existe un estudiante con el id proporcionado.']);
      }
    }

    public function destroy($id){
      $e = Estudiante::find($id);
      if (isset($e)){
        $res = Estudiante::destroy($id);
        if($res){
          return response()->json(['mensaje' => 'Estudiante eliminado con éxito.']);
        }else{
          return response()->json(['data'=> $e, 'mensaje' => 'Ha ocurrido un error.']);
        }
      }else{
        return response()->json(['error'=> true, 'mensaje' => 'No existe un estudiante con el id proporcionado.']);
      }
    }
}
