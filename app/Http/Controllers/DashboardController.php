<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Invoice;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $hoy = Carbon::today();
        $inicioMes = Carbon::now()->startOfMonth();
        $finMes = Carbon::now()->endOfMonth();

        // 1. Ventas de Hoy vs Ayer
        $ventasHoy = Invoice::whereDate('created_at', $hoy)->sum('total');
        $ventasAyer = Invoice::whereDate('created_at', Carbon::yesterday())->sum('total');
        
        // Calcular porcentaje comparativo vs ayer
        $porcentajeVariacion = 0;
        if ($ventasAyer > 0) {
            $porcentajeVariacion = (($ventasHoy - $ventasAyer) / $ventasAyer) * 100;
        } elseif ($ventasHoy > 0) {
            $porcentajeVariacion = 100; // Si ayer fue 0 y hoy vendió algo, subió 100%
        }

        // 2. Ventas del Mes Acumuladas
        $ventasMes = Invoice::whereBetween('created_at', [$inicioMes, Carbon::now()])->sum('total');
        $cantidadFacturasMes = Invoice::whereBetween('created_at', [$inicioMes, Carbon::now()])->count();

        // 3. Ticket Promedio (Calculado sobre el acumulado del mes o de hoy)
        $cantidadFacturasHoy = Invoice::whereDate('created_at', $hoy)->count();
        $ticketPromedio = $cantidadFacturasHoy > 0 ? ($ventasHoy / $cantidadFacturasHoy) : 0;

        // 4. Totales del Catálogo
        $totalProductos = Product::count();
        $totalCategorias = class_exists(Category::class) ? Category::count() : 1; 

        // 5. Gráfico de Ventas Diarias del Mes Actual
        // Agrupamos ventas por día desde el primer día del mes hasta el día actual
        $ventasPorDia = Invoice::whereBetween('created_at', [$inicioMes, Carbon::now()])
            ->select(
                DB::raw('DATE(created_at) as fecha'),
                DB::raw('SUM(total) as total_dia')
            )
            ->groupBy('fecha')
            ->pluck('total_dia', 'fecha')
            ->toArray();

        $graficoLabels = [];
        $graficoValores = [];

        // Generamos los días transcurridos hasta hoy en el mes
        $diasTranscurridos = Carbon::now()->day;
        for ($i = 1; $i <= $diasTranscurridos; $i++) {
            $fechaLoop = Carbon::now()->day($i)->format('Y-m-d');
            $labelDia = Carbon::now()->day($i)->isoFormat('D MMM'); // Ej: "1 Jul", "2 Jul"
            
            $graficoLabels[] = $labelDia;
            $graficoValores[] = isset($ventasPorDia[$fechaLoop]) ? (float) $ventasPorDia[$fechaLoop] : 0;
        }

        $graficoVentas = [
            'labels' => $graficoLabels,
            'valores' => $graficoValores
        ];

        // 6. Distribución de Métodos de Pago
        // Busca en las facturas del mes
        $pagosQuery = Invoice::whereBetween('created_at', [$inicioMes, Carbon::now()])
            ->select('payment_type', DB::raw('SUM(total) as monto'))
            ->groupBy('payment_type')
            ->pluck('monto', 'payment_type')
            ->toArray();

        // Si la columna en tu DB se llama 'metodo_pago' en vez de 'payment_type', descomenta esta línea:
        /*
        $pagosQuery = Invoice::whereBetween('created_at', [$inicioMes, Carbon::now()])
            ->select('metodo_pago as payment_type', DB::raw('SUM(total) as monto'))
            ->groupBy('metodo_pago')
            ->pluck('monto', 'payment_type')
            ->toArray();
        */

        $totalMontoPagos = array_sum($pagosQuery);

        // Agrupación flexible considerando nombres comunes en la DB
        $efectivoMonto = ($pagosQuery['efectivo'] ?? 0) + ($pagosQuery['cash'] ?? 0) + ($pagosQuery['Efectivo'] ?? 0);
        $transferenciaMonto = ($pagosQuery['transferencia'] ?? 0) + ($pagosQuery['nequi'] ?? 0) + ($pagosQuery['bancolombia'] ?? 0) + ($pagosQuery['Transferencia'] ?? 0);
        $tarjetaMonto = ($pagosQuery['tarjeta'] ?? 0) + ($pagosQuery['credit_card'] ?? 0) + ($pagosQuery['debit_card'] ?? 0) + ($pagosQuery['Tarjeta'] ?? 0);

        $porcentajesPago = [
            'efectivo' => $totalMontoPagos > 0 ? round(($efectivoMonto / $totalMontoPagos) * 100) : 0,
            'transferencia' => $totalMontoPagos > 0 ? round(($transferenciaMonto / $totalMontoPagos) * 100) : 0,
            'tarjeta' => $totalMontoPagos > 0 ? round(($tarjetaMonto / $totalMontoPagos) * 100) : 0,
        ];

        // 7. Últimas ventas realizadas (Límite 5)
        $ultimasVentas = Invoice::latest()->take(5)->get();

        return view('dashboard', compact(
            'ventasHoy', 
            'porcentajeVariacion', 
            'ventasMes',
            'cantidadFacturasMes',
            'cantidadFacturasHoy', 
            'ticketPromedio', 
            'totalProductos',
            'totalCategorias',
            'graficoVentas',
            'porcentajesPago',
            'ultimasVentas'
        ));
    }
}