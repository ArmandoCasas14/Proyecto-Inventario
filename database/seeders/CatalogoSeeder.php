<?php

namespace Database\Seeders;

use Database\Factories\MovementFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Category;
use App\Models\MovementType;
use App\Models\User;

class CatalogoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = ['Administrador', 'Encargado de inventario'];
        foreach ($roles as $rol) {
            Role::create(['name' => $rol]);
        }
        User::firstOrCreate(
            ['email' => 'admin@sistema.com'], 
            [
                'name'     => 'Administrador General',
                'password' => Hash::make('password123'),
                'role_id'  => 1, // Asignamos el ID del rol obtenido arriba
            ]
        );

        // 2. Categorías (Versátiles para la mayoría de inventarios)
        $categorias = ['Electrónica', 'Papelería', 'Limpieza', 'Alimentos', 'Herramientas', 'Otros'];
        foreach ($categorias as $cat) {
            Category::create([
                'name' => $cat,
                'description' => "Categoría de productos: $cat",
            ]);
        }

        // 3. Tipos de Movimiento
        $movimientos = [
            'Compra' => 'suma',
            'Venta' => 'resta',
            'Desecho' => 'resta',
            'Devolución' => 'suma',
            // Ajustes de inventario para corregir discrepancias físicas
            'Ajuste de entrada' => 'suma', // Cuando el stock físico es MAYOR al del sistema
            'Ajuste de salida' => 'resta', // Cuando el stock físico es MENOR al del sistema
        ];
        
        foreach ($movimientos as $nombre => $naturaleza) {
            MovementType::create([
                'name' => $nombre,
                'type' => $naturaleza
            ]);
        }
    }
}
