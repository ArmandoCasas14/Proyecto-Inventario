<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Invoice;
use App\Models\Category; // Asegúrate de tener este modelo si manejas categorías por tabla
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Ventas de Hoy vs Ayer
        $ventasHoy = Invoice::whereDate('created_at', today())->sum('total');
        $ventasAyer = Invoice::whereDate('created_at', today()->subDay())->sum('total');
        
        // Calcular porcentaje comparativo vs ayer
        $porcentajeVariacion = 0;
        if ($ventasAyer > 0) {
            $porcentajeVariacion = (($ventasHoy - $ventasAyer) / $ventasAyer) * 100;
        }

        // 2. Facturas Emitidas Hoy y Ticket Promedio
        $cantidadFacturas = Invoice::whereDate('created_at', today())->count();
        $ticketPromedio = $cantidadFacturas > 0 ? ($ventasHoy / $cantidadFacturas) : 0;

        // 3. Alertas de stock (Colección de productos críticos)
        $alertasStock = Product::whereColumn('current_stock', '<=', 'minimum_stock')->get();
        $cantidadAlertas = $alertasStock->count();

        // 4. Totales del Inventario
        $totalProductos = Product::count();
        // Si no tienes una tabla de categorías y usas un string, puedes usar: Product::distinct('categoria')->count();
        $totalCategorias = class_exists(Category::class) ? Category::count() : 1; 

        // 5. Distribución de Métodos de Pago de hoy (Porcentaje sobre el total vendido hoy)
        $pagosQuery = Invoice::whereDate('created_at', today())
            ->select('payment_type', DB::raw('SUM(total) as monto'))
            ->groupBy('payment_type')
            ->pluck('monto', 'payment_type')->toArray();

        // Inicializamos los porcentajes por defecto mapeando los strings que uses en tu DB
        $totalPagosHoy = array_sum($pagosQuery);
        $porcentajesPago = [
            'efectivo' => $totalPagosHoy > 0 ? round((($pagosQuery['efectivo'] ?? 0) / $totalPagosHoy) * 100) : 0,
            'transferencia' => $totalPagosHoy > 0 ? round((($pagosQuery['transferencia'] ?? 0) / $totalPagosHoy) * 100) : 0,
            'tarjeta' => $totalPagosHoy > 0 ? round((($pagosQuery['tarjeta'] ?? 0) / $totalPagosHoy) * 100) : 0,
        ];

        // 6. Últimas ventas realizadas (Cargando la relación cliente si existe)
        // Ejemplo: ->with('customer') si tu modelo Invoice tiene la relación belongsTo
        $ultimasVentas = Invoice::latest()->take(5)->get();

        return view('dashboard', compact(
            'ventasHoy', 
            'porcentajeVariacion', 
            'cantidadFacturas', 
            'ticketPromedio', 
            'alertasStock', 
            'cantidadAlertas',
            'totalProductos',
            'totalCategorias',
            'porcentajesPago',
            'ultimasVentas'
        ));
    }
}
