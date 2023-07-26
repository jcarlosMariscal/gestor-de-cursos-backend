<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use App\Models\Curso;
use Illuminate\Http\Request;

class EstudiantesController extends Controller
{
    public function index(){
      return Estudiante::all();
      return Curso::all();
    }
    
    public function store(Request $request){
      $inputs = $request -> input();
      $respuesta = Estudiante::create($inputs);
        $lastId = $respuesta->id;
      return response()->json(['data'=> $inputs, 'mensaje' => 'Estudiante registrado.', "id" => $lastId]);
    }
    public function show( $id){
          $estudiante = Estudiante::find($id);

    if (!$estudiante) {
        return response()->json(['mensaje' => 'Estudiante no encontrado.'], 404);
    }

    return response()->json(['data' => $estudiante, 'mensaje' => 'Estudiante encontrado.']);

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
    
    // Método para relacionar un alumno a un curso
    public function relacionarCurso(Request $request, $id)
    {
      try {
                $cursoData = $request->only(['id', 'fecha_inscripcion', 'calificacion', 'nota']);

        // Verificar que el estudiante y el curso existan
        $estudiante = Estudiante::findOrFail($id);
        $curso = Curso::findOrFail($cursoData['id']);

        // Relacionar el estudiante con el curso y agregar los datos adicionales
        $estudiante->cursos()->syncWithoutDetaching([
            $cursoData['id'] => [
                'fecha_inscripcion' => $cursoData['fecha_inscripcion'],
                'calificacion' => $cursoData['calificacion'],
                'nota' => $cursoData['nota'],
            ],
        ]);;

        return response()->json(['message' => 'El estudiante fue relacionado con el curso correctamente.']);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Ha ocurrido un error','error' => $e->getMessage()], 500);
    }
  }
}
