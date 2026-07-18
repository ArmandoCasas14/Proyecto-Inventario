<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // 1. Aplicamos los Scopes leyendo los datos de la URL ($request)
        $products = Product::search($request->get('search'))
                           ->ofCategory($request->get('category_id'))
                           ->stockStatus($request->get('stock'))
                           ->ofStatus($request->input('status'))
                           ->orderBy('name', 'asc')
                           ->paginate(10)
                           ->withQueryString();

        // 2. Traemos las categorías para armar el menú de filtros laterales
        $categories = Category::orderBy('name', 'asc')->get();

        return view('products.index', compact('products', 'categories'));
    }

     public function toggleStatus(Product $product)
    {
        // 1. Si el producto está ACTIVO e intentan INACTIVARLO (pasar a 0)
        if ($product->status == 1) {
            
            // Verificamos que este vacio el stock actual del producto
            if ($product->current_stock > 0) {
                return redirect()->route('productos.index')->with(
                    'error', 
                    "No se puede inactivar el producto '{$product->name}' porque tiene stock disponible en el sistema."
                );
            }
        }

        // 2. Si pasa la validación (o si se está activando), conmutamos el estado
        $product->status = $product->status ? 0 : 1;
        $product->save();

        $mensaje = $product->status 
            ? 'El producto ha sido activado correctamente.' 
            : 'El producto ha sido desactivado correctamente.';

        return redirect()->route('productos.index')->with('success', $mensaje);
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
        ]);

        Product::create(array_merge($request->all(), ['status' => 1]));

        return redirect()->route('productos.index')->with('success', 'Producto registrado exitosamente.');
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
            'minimum_stock'  => 'required|integer|min:0',
            'status'         => 'required|boolean',
        ]);

        $product->update($request->except('current_stock')); // Evitamos actualizar el stock actual desde aquí

        return redirect()->route('productos.index')->with('success', 'Producto actualizado con éxito.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('productos.index')->with('success', 'Producto eliminado de los registros.');
    }
}