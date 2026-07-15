<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\Movement;

class DatabaseDummySeeder extends Seeder
{
    public function run(): void
    {
        // 1. Primero proveedores y usuarios
        Supplier::factory()->count(10)->create();
        User::factory()->count(5)->create();
        // 2. Luego productos (se relacionan con proveedores y categorías)
        Product::factory()->count(50)->create();
        // 3. Finalmente los movimientos (se relacionan con productos, usuarios y tipos de movimiento)
        Movement::factory()->count(100)->create();
    }
}
