<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'cod_usu' => 'required|string',
            'contraseña' => 'required|string',
        ]);

        $usuario = Usuario::where('cod_usu', $request->cod_usu)->first();

        if (!$usuario) {
            return response()->json(['error' => 'Código de usuario no encontrado'], 404);
        }

        // Verificar la contraseña sin encriptar
        if ($request->contraseña !== $usuario->contraseña) {
            return response()->json(['error' => 'Contraseña incorrecta'], 401);
        }

        // Autenticación exitosa, devolver la información del usuario
        $datosUsuario = [
            'id' => $usuario->id,
            'nombre' => $usuario->nombre,
            'apellidos' => $usuario->apellidos,
            'telefono' => $usuario->telefono,
            'foto' => $usuario->foto,
            'tipo' => $usuario->tipo,
        ];

        return response()->json(['usuario' => $datosUsuario], 200);
    }

    public function obtenerInformacionAlumno($idHorario)
    {
        // Obtener la información del horario y el usuario asociado
        $informacion = Horario::with(['usuario:id,nombre,apellidos,foto', 'usuario:id,nombre,apellidos,foto'])
            ->where('id', $idHorario)
            ->first();
    
        if (!$informacion) {
            return response()->json(['mensaje' => 'Horario no encontrado'], 404);
        }
    
        // Construir la respuesta
        $respuesta = [
            'nombre' => $informacion->usuario->nombre,
            'apellidos' => $informacion->usuario->apellidos,
            'foto' => $informacion->usuario->foto,
            'motivo' => $informacion->motivo,
            'puerta_ingreso' => $informacion->puerta_ingreso,
        ];
    
        return response()->json($respuesta, 200);
    }

    public function listarUsuarios()
    {
        // Obtener todos los usuarios
        $usuarios = Usuario::all();
    
        // Retornar la lista de usuarios en formato JSON
        return response()->json(['usuarios' => $usuarios], 200);
    }
}
