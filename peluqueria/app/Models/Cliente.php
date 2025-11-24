<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes';

    protected $fillable = [
        'cliente_habitual',
        'idpersona'
    ];

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'idpersona');
    }
}
