<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    protected $table = 'USUARIOS';

    protected $fillable = [
        'cod_usu',
        'nombre',
        'apellidos',
        'estado',
        'telefono',
        'tipo',
        'foto',
        'contraseña',
    ];

    // Relación con el modelo Horario
    public function horarios()
    {
        return $this->hasMany(Horario::class, 'id_usuario', 'id');
    }
}
