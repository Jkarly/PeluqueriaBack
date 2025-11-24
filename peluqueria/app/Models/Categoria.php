<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $table = 'categorias';

    protected $fillable = [
        'nombre',
        'estado',
        'descripcion',
    ];
    public function servicios()
    {
        // Una Categoria tiene muchos Servicios
        return $this->hasMany(Servicio::class, 'idcategoria');
    }
}
