<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::query()
            ->searchByName($request->input('search'))
            ->orderBy('name', 'asc')
            ->paginate(10)
            ->withQueryString(); // Conserva los filtros al cambiar de página

        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Category::create($request->all());

        return redirect()->route('categorias.index')->with('success', 'Categoría creada con éxito.');
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $category->update($request->all());

        return redirect()->route('categorias.index')->with('success', 'Categoría actualizada con éxito.');
    }

    public function destroy(Category $category)
    {
        // Validar si tiene productos activos
    if ($category->products()->count() > 0) {
        return redirect()->route('categorias.index')
            ->with('error', 'No se puede eliminar la categoría porque tiene productos asociados.');
    }

        $category->delete(); // Hará Soft Delete
        return redirect()->route('categorias.index')->with('success', 'Categoría eliminada con éxito.');
    }
}