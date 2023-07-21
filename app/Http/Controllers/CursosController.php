<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Curso;

class CursosController extends Controller
{
      public function index(){
      return Curso::all();
    }
    
    public function store(Request $request){
      $inputs = $request -> input();
      $respuesta = Curso::create($inputs);
      return response()->json(['data'=> $inputs, 'mensaje' => 'Curso encontrado.']);
    }
    public function show( $id){
          $curso = Curso::find($id);

    if (!$curso) {
        return response()->json(['mensaje' => 'Curso no encontrado.'], 404);
    }

    return response()->json(['data' => $curso, 'mensaje' => 'Curso encontrado.']);

    }
    public function update(Request $request, $id){
      $e = Curso::find($id);
      if (isset($e)){
        $e->nombre = $request->nombre;
        $e->horas = $request->horas;
        if($e->save()){
          return response()->json(['data'=> $e, 'mensaje' => 'Curso actualizado con éxito.']);
        }
      }else{
        return response()->json(['error'=> true, 'mensaje' => 'No existe un curso con el id proporcionado.']);
      }
    }

    public function destroy($id){
      $e = Curso::find($id);
      if (isset($e)){
        $res = Curso::destroy($id);
        if($res){
          return response()->json(['mensaje' => 'Curso eliminado con éxito.']);
        }else{
          return response()->json(['data'=> $e, 'mensaje' => 'Ha ocurrido un error.']);
        }
      }else{
        return response()->json(['error'=> true, 'mensaje' => 'No existe un curso con el id proporcionado.']);
      }
    }
}
