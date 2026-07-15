<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        // Usamos eager loading (with) para cargar las relaciones de un solo golpe de consulta SQL
        $categories = Category::all();
        $suppliers = Supplier::where('status', 1)->get(); // Solo proveedores activos    
        $products = Product::with(['category', 'supplier'])->get();
        return view('products.index', compact('products', 'categories', 'suppliers'));
    }

    public function create()
    {
        $categories = Category::all();
        $suppliers = Supplier::where('status', 1)->get(); // Solo proveedores activos
        return view('products.create', compact('categories', 'suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
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

        Product::create(array_merge($request->all(), ['status' => 1]));

        return redirect()->route('products.index')->with('success', 'Producto registrado exitosamente.');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $suppliers = Supplier::where('status', 1)->get();
        return view('products.edit', compact('product', 'categories', 'suppliers'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'code'           => 'required|string|max:50|unique:products,code,' . $product->id,
            'name'           => 'required|string|max:255',
            'description'    => 'nullable|string',
            'category_id'    => 'required|exists:categories,id',
            'supplier_id'    => 'required|exists:suppliers,id',
            'purchase_price' => 'required|numeric|min:0',
            'selling_price'  => 'required|numeric|min:0',
            'current_stock'  => 'required|integer|min:0',
            'minimum_stock'  => 'required|integer|min:0',
            'status'         => 'required|boolean',
        ]);

        $product->update($request->all());

        return redirect()->route('products.index')->with('success', 'Producto actualizado con éxito.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Producto eliminado de los registros.');
    }
}