<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    use HasFactory;

    protected $table = 'servicios';

    protected $fillable = [
        'nombre',
        'estado',
        'duracionmin',
        'precio',
        'imagen',
        'descripcion',
        'idcategoria',
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'idcategoria');
    }

    public function favoritos()
    {
        return $this->hasMany(Favorito::class, 'idservicio');
    }
}
