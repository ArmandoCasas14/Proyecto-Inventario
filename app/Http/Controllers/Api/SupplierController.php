<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => Supplier::all()
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'legal_name' => 'required|string|max:100',
            'nit'        => 'required|string|max:10|unique:suppliers,nit',
            'phone'      => 'nullable|string|max:20',
            'email'      => 'nullable|email|max:45',
            'address'    => 'nullable|string|max:100',
            'status'     => 'required|boolean',
        ]);

        $supplier = Supplier::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Proveedor registrado correctamente',
            'data'    => $supplier
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $supplier = Supplier::find($id);

        if (!$supplier) {
            return response()->json(['success' => false, 'message' => 'Proveedor no encontrado'], 404);
        }

        return response()->json(['success' => true, 'data' => $supplier], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $supplier = Supplier::find($id);

        if (!$supplier) {
            return response()->json(['success' => false, 'message' => 'Proveedor no encontrado'], 404);
        }

        $validated = $request->validate([
            'legal_name' => 'sometimes|required|string|max:255',
            'nit'        => 'sometimes|required|string|max:50|unique:suppliers,nit,' . $id,
            'phone'      => 'nullable|string|max:20',
            'email'      => 'nullable|email|max:255',
            'address'    => 'nullable|string|max:255',
            'status'     => 'sometimes|required|boolean',
        ]);

        $supplier->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Proveedor actualizado correctamente',
            'data'    => $supplier
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
