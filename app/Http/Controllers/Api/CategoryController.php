<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Traemos todas las categorías ordenadas por nombre de forma ascendente
        $categories = Category::orderBy('name', 'asc')->get();

        // Retornamos una respuesta JSON estándar
        return response()->json([
            'success' => true,
            'data' => $categories
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validamos que el nombre sea obligatorio y único en la tabla
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string|max:500',
        ]);

        // 2. Creamos la categoría
        $category = Category::create($validated);

        // 3. Respondemos con éxito
        return response()->json([
            'success' => true,
            'message' => 'Categoría creada correctamente',
            'data' => $category
        ], 201); // El código 201 significa "Created"
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::find($id);

        // Si no existe, devolvemos un error 404
        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Categoría no encontrada'
            ], 404);
        }

        // Si existe, la retornamos
        return response()->json([
            'success' => true,
            'data' => $category
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // 1. Buscamos la categoría
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Categoría no encontrada'
            ], 404);
        }

        // 2. Validamos
        // Fíjate en el 'unique:categories,name,' . $id
        // Esto le dice a Laravel: "valida que el nombre sea único, pero ignora este ID"
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255|unique:categories,name,' . $id,
            'description' => 'nullable|string|max:500',
        ]);

        // 3. Actualizamos
        $category->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Categoría actualizada correctamente',
            'data' => $category
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);

        // Verificamos si tiene productos asociados
        if ($category->products()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'No se puede eliminar: esta categoría tiene productos asociados.'
            ], 409); // 409 Conflict
        }

        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'Categoría eliminada correctamente'
        ], 200);
    }
}
