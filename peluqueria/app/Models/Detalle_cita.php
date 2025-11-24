<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detalle_cita extends Model
{
    use HasFactory;

    protected $table = "detalle_citas";
    protected $primaryKey = "id";

    protected $fillable = [
        'estado',
        'preciocobrado',
        'observaciones',
        'idcita',
        'idservicio'
    ];

    public function cita()
    {
        return $this->belongsTo(Cita::class, 'idcita');
    }

    public function servicio()
    {
        return $this->belongsTo(Servicio::class, 'idservicio');
    }
}
