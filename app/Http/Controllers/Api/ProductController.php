<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Usamos with para traer la información relacionada y evitar el problema N+1
        $query = Product::with(['category', 'supplier']);

        // Filtro opcional por categoría
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        return response()->json([
            'success' => true,
            'data' => $query->get()
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code'           => 'required|string|unique:products,code|max:50',
            'name'           => 'required|string|max:255',
            'description'    => 'nullable|string',
            'category_id'    => 'required|exists:categories,id',
            'supplier_id'    => 'required|exists:suppliers,id',
            'purchase_price' => 'required|numeric|min:0',
            'selling_price'  => 'required|numeric|min:0',
            'current_stock'  => 'required|integer|min:0',
            'minimum_stock'  => 'required|integer|min:0',
            'status'         => 'required|boolean', // 1 activo, 0 inactivo
        ]);

        $product = Product::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Producto creado con éxito',
            'data'    => $product
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::with(['category', 'supplier'])->find($id);

        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Producto no encontrado'], 404);
        }

        return response()->json(['success' => true, 'data' => $product], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Producto no encontrado'], 404);
        }

        $validated = $request->validate([
            'code'           => 'sometimes|required|string|unique:products,code,' . $id,
            'name'           => 'sometimes|required|string',
            'description'    => 'nullable|string',
            'category_id'    => 'sometimes|required|exists:categories,id',
            'supplier_id'    => 'sometimes|required|exists:suppliers,id',
            'purchase_price' => 'sometimes|required|numeric',
            'selling_price'  => 'sometimes|required|numeric',
            'current_stock'  => 'sometimes|required|integer',
            'minimum_stock'  => 'sometimes|required|integer',
            'status'         => 'sometimes|required|boolean',
        ]);

        $product->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Producto actualizado correctamente',
            'data'    => $product
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
