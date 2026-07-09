<?php

namespace Database\Factories;

use App\Models\Proveedor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Proveedor>
 */
class ProveedorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'razon_social' => $this->faker->company,
            'nit' => $this->faker->numerify('##########'),
            'telefono' => $this->faker->phoneNumber,
            'email' => $this->faker->companyEmail,
            'direccion' => $this->faker->address,
            'estado' => true,
        ];
    }
}
