<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Invoice;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Ventas de hoy
        $ventasHoy = Invoice::whereDate('created_at', today())->sum('total');

        // 2. Facturas emitidas hoy
        $cantidadFacturas = Invoice::whereDate('created_at', today())->count();

        // 3. Alertas de stock (Productos donde stock <= stock_minimo)
        $alertasStock = Product::whereColumn('current_stock', '<=', 'minimum_stock')->get();

        // 4. Últimas ventas
        $ultimasVentas = Invoice::latest()->take(5)->get();
        $metodosPago = Invoice::select('metodo_pago', DB::raw('count(*) as total'))
            ->whereDate('created_at', today())
            ->groupBy('metodo_pago')
            ->get();

        return view('dashboard', compact('ventasHoy', 'cantidadFacturas', 'alertasStock', 'ultimasVentas','metodosPago'));
    }
}
