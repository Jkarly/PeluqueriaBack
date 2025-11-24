<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    //
     use HasFactory;

    protected $table = 'horarios';

    protected $fillable = [
        'dia_semana',
        'hora_inicio',
        'hora_fin',
        'id_empleado',
    ];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'id_empleado');
    }
}
