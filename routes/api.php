<?php

use App\Http\Controllers\HorarioController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', [UsuarioController::class, 'login']);
Route::post('generateAdmission/{idUsuario}', [HorarioController::class, 'obtenerHorarioActual']);
Route::post('scanAdmission/{idHorario}', [UsuarioController::class, 'obtenerInformacionAlumno']);
Route::post('markAdmission/{idHorario}', [HorarioController::class, 'marcarIngresoHorario']);
Route::get('listUsers', [UsuarioController::class, 'listarUsuarios']);
Route::get('listAdmissions', [HorarioController::class, 'listarHorarios']);

