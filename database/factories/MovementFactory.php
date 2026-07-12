<?php

namespace Database\Factories;

use App\Models\Movement;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Movement>
 */
class MovementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => \App\Models\Product::factory(),
            'movement_type_id' => \App\Models\MovementType::inRandomOrder()->first()->id,
            'user_id' => \App\Models\User::factory(),
            'quantity' => $this->faker->numberBetween(1, 50),
            'observation' => 'Registro de prueba generado automáticamente',
            'unit_price' => $this->faker->randomFloat(2, 10, 1000),
        ];
    }
}
