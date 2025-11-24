<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rol;

class RolSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['nombre' => 'ADMIN', 'descripcion' => 'Administrador del sistema', 'estado' => 1],
            ['nombre' => 'EMPLEADO', 'descripcion' => 'Empleado de la empresa', 'estado' => 1],
            ['nombre' => 'CLIENTE', 'descripcion' => 'Cliente que solicita servicios', 'estado' => 1],
            ['nombre' => 'RECEPCIONISTA', 'descripcion' => 'Recepcionista que gestiona citas', 'estado' => 1],
        ];

        foreach ($roles as $rol) {
            Rol::create($rol);
        }
    }
}
