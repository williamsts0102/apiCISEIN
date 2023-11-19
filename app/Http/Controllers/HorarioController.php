<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HorarioController extends Controller
{
    public function obtenerHorarioActual($idUsuario)
    {
        // Configurar la zona horaria a la de Perú
        date_default_timezone_set('America/Lima');
    
        // Obtener la fecha y hora actual en la zona horaria de Perú
        $fechaHoraActual = Carbon::now('America/Lima');
    
        // Obtener el horario más cercano para el usuario y la fecha actual
        $horario = Horario::where('id_usuario', $idUsuario)
            ->whereDate('fecha_prog', $fechaHoraActual->toDateString()) // Solo la fecha actual
            ->orderByRaw('ABS(TIMESTAMPDIFF(SECOND, fecha_prog, ?))', [$fechaHoraActual->toDateTimeString()]) // Ordenar por cercanía
            ->first();
    
        if (!$horario) {
            return response()->json(['mensaje' => 'No hay horarios para el alumno en la fecha actual'], 404);
        }
    
        return response()->json(['id_horario' => $horario->id], 200);
    }
    
    public function marcarIngresoHorario($idHorario)
    {
        // Configurar la zona horaria a la de Perú
        date_default_timezone_set('America/Lima');
    
        // Obtener el horario por su ID
        $horario = Horario::find($idHorario);
    
        if (!$horario) {
            return response()->json(['mensaje' => 'Horario no encontrado'], 404);
        }
    
        // Verificar si el horario ya ha sido marcado como ingresado
        if ($horario->estado == 1) {
            return response()->json(['mensaje' => 'Horario ya marcado como ingresado'], 400);
        }
    
        // Actualizar el horario
        $horario->estado = 1; // Cambiar estado a ingresado
        $horario->fec_ingreso = now(); // Registrar la fecha de ingreso actual
        $horario->save();
    
        return response()->json(['mensaje' => 'Ingreso marcado correctamente'], 200);
    }

    public function listarHorarios()
    {
        // Obtener todos los horarios
        $horarios = Horario::all();
    
        // Retornar la lista de horarios en formato JSON
        return response()->json(['horarios' => $horarios], 200);
    }
}
