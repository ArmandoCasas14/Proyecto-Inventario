<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Rol;
use App\Models\Categoria;
use App\Models\TipoMovimiento;

class CatalogoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = ['Administrador', 'Encargado de inventario'];
        foreach ($roles as $rol) {
            Rol::create(['nombre' => $rol]);
        }

        // 2. Categorías (Versátiles para la mayoría de inventarios)
        $categorias = ['Electrónica', 'Papelería', 'Limpieza', 'Alimentos', 'Herramientas', 'Otros'];
        foreach ($categorias as $cat) {
            Categoria::create(['nombre' => $cat]);
        }

        // 3. Tipos de Movimiento
        $movimientos = [
            'Compra' => 'suma',
            'Venta' => 'resta',
            'Traslado' => 'neutro',
            'Desecho' => 'resta',
            'Devolución' => 'suma'
        ];
        
        foreach ($movimientos as $nombre => $naturaleza) {
            TipoMovimiento::create([
                'nombre' => $nombre,
                'naturaleza' => $naturaleza
            ]);
        }
    }
}
