<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\InventoryMovement;
use App\Models\Movement;
use Illuminate\Http\Request;

class MovementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Movement::query();

        if ($request->has('product_id')) {
            $query->where('product_id', $request->product_id);
        }

        return response()->json([
            'success' => true,
            'data' => $query->latest()->get() // .latest() para ver lo más reciente primero
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id'       => 'required|exists:products,id',
            'movement_type_id' => 'required|exists:movement_types,id',
            'user_id'          => 'required|exists:users,id',
            'quantity'         => 'required|integer',
            'unit_price'       => 'required|numeric|min:0',
            'observation'      => 'nullable|string|max:255',
        ]);

        $movement = Movement::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Movimiento registrado correctamente',
            'data'    => $movement
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $movement = Movement::find($id);

        if (!$movement) {
            return response()->json(['success' => false, 'message' => 'Movimiento no encontrado'], 404);
        }

        return response()->json(['success' => true, 'data' => $movement], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $movement = Movement::find($id);

        if (!$movement) {
            return response()->json(['success' => false, 'message' => 'Movimiento no encontrado'], 404);
        }

        $validated = $request->validate([
            'quantity'    => 'sometimes|required|integer',
            'unit_price'  => 'sometimes|required|numeric|min:0',
            'observation' => 'sometimes|nullable|string|max:255',
        ]);

        $movement->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Movimiento actualizado',
            'data'    => $movement
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
