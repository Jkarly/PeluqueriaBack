<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorito extends Model
{
    use HasFactory;

    protected $table = 'favoritos';
    protected $primaryKey = 'id';

    protected $fillable = [
        'idusuario',
        'idservicio',
        'estado'
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'idusuario');
    }

    public function servicio()
    {
        return $this->belongsTo(Servicio::class, 'idservicio');
    }
}