<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Usuario extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $table = 'usuarios';

    protected $fillable = [
        'correo',
        'contrasena',
        'idpersona',
        'idrol',
        'estado',
    ];

    protected $hidden = [
        'contrasena',
        'remember_token',
    ];

    public function getAuthPassword()
    {
        return $this->contrasena;
    }

    // Un Usuario pertenece a una Persona
    public function persona()
    {
        return $this->belongsTo(Persona::class, 'idpersona');
    }

    public function rol()
    {
        return $this->belongsTo(Rol::class, 'idrol');
    }
}