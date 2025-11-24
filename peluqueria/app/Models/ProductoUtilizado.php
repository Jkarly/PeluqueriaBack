<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductoUtilizado extends Model
{
    use HasFactory;

    protected $table = 'producto_utilizados';
    protected $primaryKey = 'id';

    protected $fillable = [
        'idcita',
        'idproducto',
        'cantidad',
        'estado', 
        'observaciones', 
    ];

    public function cita()
    {
        return $this->belongsTo(Cita::class, 'idcita');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'idproducto');
    }
}