<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    use HasFactory;

    protected $table = 'citas';

    protected $fillable = [
        'estado',
        'fechahorainicio',
        'idcliente',
        'idempleado',
        'idusuariocreador', 
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'idcliente');
    }

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'idempleado');
    }

    public function usuarioCreador()
    {
        return $this->belongsTo(Usuario::class, 'idusuariocreador');
    }
    public function detalles()
    {
        return $this->hasMany(Detalle_cita::class, 'idcita');
    }

    public function productosUtilizados()
    {
        return $this->hasMany(ProductoUtilizado::class, 'idcita');
    }

}