<?php

namespace App\Http\Controllers;

use App\Models\Movement;
use App\Models\MovementType;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Notifications\LowStockNotification;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;

class MovementController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ejecutar la consulta aplicando consecutivamente los scopes individuales
        $movements = Movement::with(['product', 'movementType', 'user'])
            ->ofProduct($request->input('product'))
            ->ofType($request->input('movement_type_id'))
            ->ofDate($request->input('date'))
            ->ofUser($request->input('user'))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        // 2. Obtener los tipos de movimiento para el select del filtro
        $movementTypes = MovementType::all();

        return view('movements.index', compact('movements', 'movementTypes'));
    }

    public function exportPdf(Request $request)
    {
        // 1. Consulta base con relaciones
        $query = Movement::with(['product', 'movementType', 'user']);

        // 2. Filtrar por rango de fechas
        $query->whereBetween('created_at', [
            $request->date_from . ' 00:00:00',
            $request->date_to . ' 23:59:59'
        ]);

        // 3. Determinar el nombre del filtro para mostrarlo en el PDF
        $typeName = 'TODOS LOS MOVIMIENTOS';

        if ($request->filled('movement_type_id') && $request->movement_type_id !== 'todos') {
            $query->where('movement_type_id', $request->movement_type_id);
            
            // Obtenemos el nombre real del tipo desde la base de datos
            $selectedType = MovementType::find($request->movement_type_id);
            if ($selectedType) {
                $typeName = $selectedType->name;
            }
        }

        $movements = $query->orderBy('created_at', 'desc')->get();

        // 4. Cargar la vista enviando la variable $typeName
        $pdf = Pdf::loadView('pdf.movements', [
            'movements' => $movements,
            'typeName'  => $typeName,
            'dateFrom'  => $request->date_from,
            'dateTo'    => $request->date_to,
        ]);

        return $pdf->stream('reporte_movimientos_' . now()->format('Ymd_His') . '.pdf');
    }

    public function create()
    {
        $products = Product::where('status', 1)
                            ->orderBy('name', 'asc')
                            ->get();
        // Excluimos 'Venta' del registro manual para que bodega no altere facturaciones sin control
        $movementTypes = MovementType::where('name', '!=', 'Venta')->get();
        
        return view('movements.create', compact('products', 'movementTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id'       => 'required|exists:products,id',
            'movement_type_id' => 'required|exists:movement_types,id',
            'quantity'         => 'required|integer|min:1',
            'unit_price'       => 'nullable|numeric|min:0',
            'observation'      => 'required|string|max:255',

        ]);

        try {
            DB::transaction(function () use ($request) {
                $product = Product::findOrFail($request->product_id);
                $type = MovementType::findOrFail($request->movement_type_id);

                // Aplicar reglas de negocio (Suma o Resta)
                if ($type->type === 'resta') {
                    if ($product->current_stock < $request->quantity) {
                        throw new \Exception("No puedes retirar más existencias de las disponibles. Stock actual: {$product->current_stock}.");
                    }
                    
                    // Disminuimos el stock
                    $product->decrement('current_stock', $request->quantity);
                    
                    // Refrescamos para obtener el valor actualizado en memoria
                    $product->refresh();

                    // 🚨 VERIFICACIÓN DE STOCK CRÍTICO O AGOTADO 🚨
                    if ($product->current_stock <= $product->minimum_stock) {
                        
                        // Obtenemos a TODOS los usuarios del sistema
                        $users = User::all();

                        // Notificamos a cada uno de ellos
                        foreach ($users as $user) {
                            $user->notify(new LowStockNotification($product));
                        }
                    }

                } else if ($type->type === 'suma') {
                    $product->increment('current_stock', $request->quantity);
                    $product->refresh();

    // Si el stock volvió a estar por encima del mínimo, borramos las notificaciones de este producto
                    $productId = $product->id;
                    if ($product->current_stock > $product->minimum_stock) {
                      DB::table('notifications')
                            ->where('type', \App\Notifications\LowStockNotification::class)
                            ->where('data', 'like', '%"product_id":' . $productId . '%')
                            ->delete();
                    }
                }

                // Si no se define precio, usamos el precio de venta del producto
                $price = $request->unit_price ?? $product->selling_price;

                Movement::create([
                    'product_id'       => $product->id,
                    'movement_type_id' => $type->id,
                    'user_id'          => auth()->id() ?? 1,
                    'quantity'         => $request->quantity,
                    'unit_price'       => $price,
                    'observation'      => $request->observation,
                ]);
            });

            return redirect()->route('movimientos.index')
                             ->with('success', 'Movimiento de bodega registrado e inventario sincronizado.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }
    
}