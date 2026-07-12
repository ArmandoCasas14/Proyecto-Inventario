<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => $this->faker->unique()->bothify('PROD-####'),
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
            'purchase_price' => $this->faker->randomFloat(2, 10, 500),
            'selling_price' => $this->faker->randomFloat(2, 501, 1500),
            'current_stock' => $this->faker->numberBetween(0, 100),
            'minimum_stock' => $this->faker->numberBetween(1, 20),
            'status' => true,
            'category_id' => \App\Models\Category::inRandomOrder()->first()->id,
            'supplier_id' => \App\Models\Supplier::factory(),
        ];
    }
}
