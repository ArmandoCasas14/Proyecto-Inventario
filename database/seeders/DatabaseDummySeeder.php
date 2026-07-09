<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Usuario;
use App\Models\Proveedor;
use App\Models\Producto;
use App\Models\Movimiento;

class DatabaseDummySeeder extends Seeder
{
    public function run(): void
    {
        // 1. Primero proveedores y usuarios
        Proveedor::factory()->count(10)->create();
        Usuario::factory()->count(5)->create();

        // 2. Luego productos (se relacionan con proveedores)
        Producto::factory()->count(50)->create();

        // 3. Finalmente los movimientos (se relacionan con todo lo anterior)
        Movimiento::factory()->count(100)->create();
    }
}
