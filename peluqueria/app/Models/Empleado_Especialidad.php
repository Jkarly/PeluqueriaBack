<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleado_Especialidad extends Model
{
    //
    use HasFactory;

    protected $table = 'empleado__especialidads';

    protected $fillable = [
        'id_empleado',
        'id_especialidad',
    ];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'id_empleado');
    }

    public function especialidad()
    {
        return $this->belongsTo(Especialidad::class, 'id_especialidad');
    }
}
