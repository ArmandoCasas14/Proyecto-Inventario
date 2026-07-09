<?php

namespace Database\Factories;

use App\Models\Producto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Producto>
 */
class ProductoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'codigo' => $this->faker->unique()->bothify('PROD-####'),
            'nombre' => $this->faker->word,
            'descripcion' => $this->faker->sentence,
            'precio_compra' => $this->faker->randomFloat(2, 10, 500),
            'precio_venta' => $this->faker->randomFloat(2, 501, 1500),
            'stock_actual' => $this->faker->numberBetween(0, 100),
            'stock_minimo' => $this->faker->numberBetween(1, 20),
            'estado' => true,
            'categoria_id' => \App\Models\Categoria::inRandomOrder()->first()->id,
            'proveedor_id' => \App\Models\Proveedor::factory(),
        ];
    }
}
