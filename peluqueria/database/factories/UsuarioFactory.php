<?php

namespace Database\Factories;

use App\Models\Persona;
use App\Models\Rol;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Usuario>
 */
class UsuarioFactory extends Factory
{
   public function definition(): array
    {
        
        static $index = 0;

        $arraycontrasena = [
            '12345678'
        ];

        return [
            'correo' => 'admin@gmail.com',
            'contrasena' => Hash::make($arraycontrasena[$index++ % count($arraycontrasena)]), 
            'estado' => true,
            'idpersona' => Persona::factory(),
            'idrol' => Rol::where('nombre', 'ADMIN')->first()->id,
        ];
    }
}
