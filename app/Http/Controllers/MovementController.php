<?php

namespace App\Http\Controllers;

use App\Models\Movement;
use App\Models\MovementType;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MovementController extends Controller
{
    public function index()
    {
        // Cargamos relaciones para optimizar consultas (evitar N+1)
        $movements = Movement::with(['product', 'movementType', 'user'])
                             ->orderBy('created_at', 'desc')
                             ->paginate(15);
                             
        return view('movements.index', compact('movements'));
    }

    public function create()
    {
        $products = Product::where('status', 1)->get();
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
            'observation'      => 'required|string|max:500',
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
                    $product->decrement('current_stock', $request->quantity);
                } else if ($type->type === 'suma') {
                    $product->increment('current_stock', $request->quantity);
                }

                // Si no se define precio (ej: Desecho/Ajuste), usamos el precio de costo o venta actual del producto
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