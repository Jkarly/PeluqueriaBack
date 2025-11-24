<?php

namespace Database\Factories;

use App\Models\Persona;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Persona>
 */
class PersonaFactory extends Factory
{
    protected $model = Persona::class;

    public function definition()
    {
        return [
            'ci' => $this->faker->unique()->numerify('########'),
            'nombre' => 'Karla',
            'apellidopaterno' => 'Torrez',
            'apellidomaterno' => 'Mamani',
            'telefono' => $this->faker->optional()->numerify('7#######'),
            'estado' => 1,
        ];
    }
}
