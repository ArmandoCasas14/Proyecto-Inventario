<?php

namespace Database\Factories;

use App\Models\Movimiento;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Movimiento>
 */
class MovimientoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'producto_id' => \App\Models\Producto::factory(),
            'tipo_movimiento_id' => \App\Models\TipoMovimiento::inRandomOrder()->first()->id,
            'usuario_id' => \App\Models\Usuario::factory(),
            'cantidad' => $this->faker->numberBetween(1, 50),
            'observacion' => 'Registro de prueba generado automáticamente',
            'precio_unitario' => $this->faker->randomFloat(2, 10, 1000),
        ];
    }
}
