<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Curso;
use App\Models\Estudiante;

class CursosController extends Controller
{
      public function index(){
      return Curso::all();
      return Estudiante::all();
    }
    
    public function store(Request $request){
      $inputs = $request -> input();
      $respuesta = Curso::create($inputs);
              $lastId = $respuesta->id;
      return response()->json(['data'=> $inputs, 'mensaje' => 'Curso registrado.', "id" => $lastId]);
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
    // Método para relacionar un curso a un estudiante
    public function relacionarEstudiante(Request $request, $id)
    {
      try {
        $estudianteId = $request->input('id');

        // Verificar que el estudiante y el curso existan
        $curso = Curso::findOrFail($id);
        $estudiante = Estudiante::findOrFail($estudianteId);

        // Relacionar el estudiante con el curso
        $curso->estudiantes()->attach($estudianteId);

        return response()->json(['message' => 'El curso fue relacionado con el estudiante correctamente.']);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Ha ocurrido un error','error' => $e->getMessage()], 500);
    }
  }
  // Método para obtener información de la tabla de relación
// CursosController
public function numeroEstudiantesEnCurso()
{
    try {
        // Obtener los cursos junto con la información de cada curso y el conteo de estudiantes asociados
        $cursosConInformacion = Curso::with('estudiantes')
            ->select('id', 'nombre', 'descripcion', 'icono', 'color')
            ->get();

        // Formatear los resultados en un objeto JSON con la colección de arreglos asociativos
        $informacionTablaRelacion = [];
        foreach ($cursosConInformacion as $curso) {
            $informacionTablaRelacion[] = [
                'nombre' => $curso->nombre,
                'descripcion' => $curso->descripcion,
                'icono' => $curso->icono,
                'color' => $curso->color,
                'cantidad_estudiantes' => $curso->estudiantes->count(),
            ];
        }

        return response()->json(['data' => $informacionTablaRelacion]);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Ha ocurrido un error', 'error' => $e->getMessage()], 500);
    }
}



}
