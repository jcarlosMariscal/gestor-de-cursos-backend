<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Generacion;

class GeneracionesController extends Controller
{
    public function index(){
      return Generacion::all();
    }
    
    public function store(Request $request){
      $inputs = $request -> input();
      $respuesta = Generacion::create($inputs);
      $lastId = $respuesta->id;
      return response()->json(['data'=> $inputs, 'mensaje' => 'Generacion creado.', "id" => $lastId]);
    }
    public function show( $id){
          $generacion = Generacion::find($id);

    if (!$generacion) {
        return response()->json(['mensaje' => 'Generacion no encontrado.'], 404);
    }

    return response()->json(['data' => $genereacion, 'mensaje' => 'Generacion encontrado.']);

    }
    public function update(Request $request, $id){
      $e = Generacion::find($id);
      if (isset($e)){
        $e->nombre = $request->nombre;
        $e->descripcion = $request->descripcion;
        $e->fecha_inicio = $request->fecha_inicio;
        $e->fecha_final = $request->fecha_final;
        if($e->save()){
          return response()->json(['data'=> $e, 'mensaje' => 'Genereacion actualizado con éxito.']);
        }
      }else{
        return response()->json(['error'=> true, 'mensaje' => 'No existe una generacion con el id proporcionado.']);
      }
    }

    public function destroy($id){
      $e = Generacion::find($id);
      if (isset($e)){
        $res = Generacion::destroy($id);
        if($res){
          return response()->json(['mensaje' => 'Generacion eliminado con éxito.']);
        }else{
          return response()->json(['data'=> $e, 'mensaje' => 'Ha ocurrido un error.']);
        }
      }else{
        return response()->json(['error'=> true, 'mensaje' => 'No existe una generación con el id proporcionado.']);
      }
    }
    
}
