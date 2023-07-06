<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return User::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $inputs = $request -> input();
        $inputs["password"] = Hash::make(trim($request->password));
        $respuesta = User::create($inputs);
        return response()->json(['data'=> $inputs, 'mensaje' => 'Usuario registrado.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
      $inputs = $request -> input();
      $respuesta = User::create($inputs);
      return response()->json(['data'=> $inputs, 'mensaje' => 'Usuario encontrado.']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $e = User::find($id);
      if (isset($e)){
        $e->first_name = $request->first_name;
        $e->last_name = $request->last_name;
        $e->email = $request->email;
        $e->password = Hash::make($request->password);
        if($e->save()){
          return response()->json(['data'=> $e, 'mensaje' => ' actualizado con éxito.']);
        }
      }else{
        return response()->json(['error'=> true, 'mensaje' => 'No existe con el id proporcionado.']);
      }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
              $e = User::find($id);
      if (isset($e)){
        $res = User::destroy($id);
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
