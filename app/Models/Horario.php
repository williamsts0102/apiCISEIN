<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    use HasFactory;
    
    protected $table = 'horarios';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'id_usuario',
        'fecha_prog',
        'motivo',
        'fecha_ingreso',
        'estado',
        'puerta_ingreso',
    ];

    // Relación con el modelo Usuario
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id');
    }
}
