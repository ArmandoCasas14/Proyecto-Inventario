<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Product;
use App\Models\Movement;
use App\Models\MovementType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Notifications\LowStockNotification;
use App\Models\User;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        // 1. Iniciamos la consulta base ordenando por las más recientes
       $invoices = Invoice::orderBy('created_at', 'desc');

        // 2. Aplicamos los scopes condicionales usando los inputs del formulario
        $invoices->byInvoiceNumber($request->input('invoice_number'))
                 ->byCustomer($request->input('customer'))
                 ->byDate($request->input('date'));

        // 3. Paginamos los resultados (ej: 10 por página) manteniendo los filtros en la URL
        $invoices = $invoices->paginate(10)->withQueryString();

        // 4. Retornamos la vista con las facturas ya filtradas
        return view('invoices.index', compact('invoices'));
    }

    public function create()
    {
        // Solo cargamos productos activos que tengan existencias
        $products = Product::where('status', 1)
                            ->where('current_stock', '>', 0)
                            ->orderBy('name', 'asc')
                            ->get();

        return view('invoices.create', compact('products'));
    }

    public function store(Request $request)
    {
        // Validamos la estructura del formulario básico
        $request->validate([
            'customer_name' => 'required|string|max:100',
            'payment_type'  => 'required|string|max:50', // Efectivo, Transferencia, etc.
            'items'         => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity'   => 'required|integer|min:1',
        ]);

        try {
            // Usamos una transacción: si algo falla (ej. stock insuficiente a mitad de camino),
            // el sistema revierte todo y no deja datos inconsistentes.
            $invoice = DB::transaction(function () use ($request) {
                
                $totalFactura = 0;
                $prepararItems = [];

                // 1. Validar existencias de todo el carrito ANTES de realizar cualquier operación
                foreach ($request->items as $item) {
                    $product = Product::findOrFail($item['product_id']);

                    if ($product->current_stock < $item['quantity']) {
                        throw new \Exception("Stock insuficiente para: {$product->name}. Disponible: {$product->current_stock}.");
                    }

                    $subtotal = $product->selling_price * $item['quantity'];
                    $totalFactura += $subtotal;

                    // Almacenamos temporalmente los datos validados para no repetir consultas
                    $prepararItems[] = [
                        'product'    => $product,
                        'quantity'   => $item['quantity'],
                        'unit_price' => $product->selling_price,
                    ];
                }

                // 2. Crear la factura cabecera
                $invoice = Invoice::create([
                    'customer_name' => $request->customer_name,
                    'payment_type'  => $request->payment_type,
                    'total'         => $totalFactura,
                ]);

                // 3. Asegurar que existe el tipo de movimiento "Venta" (Salida)
                $movementType = MovementType::where('name', 'Venta')->firstOrFail();

                // 4. Procesar cada producto: registrar detalle, restar stock, registrar auditoría
                foreach ($prepararItems as $item) {
                    $product = $item['product'];

                    // A. Registrar el Item en el detalle de la factura
                    InvoiceItem::create([
                        'invoice_id' => $invoice->id,
                        'product_id' => $product->id,
                        'quantity'   => $item['quantity'],
                        'unit_price' => $item['unit_price'],
                    ]);

                    $product->decrement('current_stock', $item['quantity']);
                $product->refresh(); // Actualizamos la instancia en memoria con el nuevo stock

                // C. 🚨 DISPARAR NOTIFICACIÓN DE STOCK CRÍTICO O AGOTADO 🚨
                if ($product->current_stock <= $product->minimum_stock) {
                    $users = User::all();

                    foreach ($users as $user) {
                        $user->notify(new LowStockNotification($product));
                    }
                }

                // D. Crear registro automático en la tabla de Movimientos
                Movement::create([
                    'product_id'       => $product->id,
                    'movement_type_id' => $movementType->id,
                    'user_id'          => auth()->id() ?? 1,
                    'quantity'         => $item['quantity'],
                    'unit_price'       => $item['unit_price'],
                    'observation'      => "Salida automatizada por venta - Factura #{$invoice->id}",
                ]);
            }

            return $invoice;
         });

            return redirect()->route('facturas.show', $invoice->id)
                             ->with('success', 'Venta registrada e inventario actualizado exitosamente.');

        } catch (\Exception $e) {
            return redirect()->back()
                             ->with('error', $e->getMessage())
                             ->withInput();
        }
    }

    public function show(Invoice $invoice)
    {
        // Cargamos la factura con sus detalles y los productos (incluso si fueron eliminados lógicamente)
        $invoice->load(['items.product' => function($query) {
            $query->withTrashed();
        }]);

        return view('invoices.show', compact('invoice'));
    }
}