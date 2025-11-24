<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promocion extends Model
{
    use HasFactory;

    protected $table = 'promocions';

    protected $fillable = [
        'nombre',
        'imagen',
        'descripcion',
        'descuento',
        'estado',
        'fechainicio',
        'fechafin',
        'idservicio',
    ];

    public function servicio()
    {
        return $this->belongsTo(Servicio::class, 'idservicio');
    }
}
