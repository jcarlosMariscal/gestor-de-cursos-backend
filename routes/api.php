<?php

use App\Http\Controllers\EstudiantesController;
use App\Http\Controllers\CursosController;
use App\Http\Controllers\GeneracionesController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::apiResource("v1/usuarios", UserController::class);
Route::apiResource("v1/estudiantes", EstudiantesController::class);
Route::apiResource("v1/generaciones", GeneracionesController::class);
Route::apiResource("v1/cursos", CursosController::class);
Route::post('v1/estudiantes/{idEstudiante}/relacionar-curso', [EstudiantesController::class, 'relacionarCurso']);
Route::get('v1/estudiantes/{id}/cursos', [EstudiantesController::class, 'obtenerCursosEstudiante']);
Route::post('v1/cursos/{idCurso}/relacionar-estudiante', [CursosController::class, 'relacionarEstudiante']);


