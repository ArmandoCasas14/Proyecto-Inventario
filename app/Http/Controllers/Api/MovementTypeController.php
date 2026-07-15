<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MovementType;
use Illuminate\Http\Request;

class MovementTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => MovementType::all()
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:movement_types,name',
            'type' => 'required|string|max:50', // Asumiendo que 'in' es entrada y 'out' es salida
        ]);

        $movementType = MovementType::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Tipo de movimiento creado correctamente',
            'data'    => $movementType
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $type = MovementType::find($id);

        if (!$type) {
            return response()->json(['success' => false, 'message' => 'Tipo no encontrado'], 404);
        }

        return response()->json(['success' => true, 'data' => $type], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $type = MovementType::find($id);

        if (!$type) {
            return response()->json(['success' => false, 'message' => 'Tipo no encontrado'], 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:100|unique:movement_types,name,' . $id,
            'type' => 'sometimes|required|string|max:50',
        ]);

        $type->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Tipo de movimiento actualizado',
            'data'    => $type
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
