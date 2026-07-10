<?php

namespace Database\Factories;

use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Usuario>
 */
class UsuarioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'contraseña' => bcrypt('password123'), // Contraseña por defecto
            'rol_id' => \App\Models\Rol::inRandomOrder()->first()->id,
            'estado' => true,
        ];
    }
}
