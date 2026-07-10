<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Proveedor;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index()
    {
        // Usamos eager loading (with) para cargar las relaciones de un solo golpe de consulta SQL
        $categorias = Categoria::all();
        $proveedores = Proveedor::where('estado', 1)->get(); // Solo proveedores activos    
        $productos = Producto::with(['categoria', 'proveedor'])->get();
        return view('productos.index', compact('productos', 'categorias', 'proveedores'));
    }

    public function create()
    {
        $categorias = Categoria::all();
        $proveedores = Proveedor::where('estado', 1)->get(); // Solo proveedores activos
        return view('productos.create', compact('categorias', 'proveedores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'codigo'        => 'required|string|max:100|unique:productos,codigo',
            'nombre'        => 'required|string|max:255',
            'descripcion'   => 'nullable|string',
            'categoria_id'  => 'required|exists:categorias,id',
            'proveedor_id'  => 'required|exists:proveedores,id',
            'precio_compra' => 'required|numeric|min:0',
            'precio_venta'  => 'required|numeric|min:0',
            'stock_actual'  => 'required|integer|min:0',
            'stock_minimo'  => 'required|integer|min:0',
        ]);

        Producto::create(array_merge($request->all(), ['estado' => 1]));

        return redirect()->route('productos.index')->with('success', 'Producto registrado exitosamente.');
    }

    public function edit(Producto $producto)
    {
        $categorias = Categoria::all();
        $proveedores = Proveedor::where('estado', 1)->get();
        return view('productos.edit', compact('producto', 'categorias', 'proveedores'));
    }

    public function update(Request $request, Producto $producto)
    {
        $request->validate([
            'codigo'        => 'required|string|max:100|unique:productos,codigo,' . $producto->id,
            'nombre'        => 'required|string|max:255',
            'descripcion'   => 'nullable|string',
            'categoria_id'  => 'required|exists:categorias,id',
            'proveedor_id'  => 'required|exists:proveedores,id',
            'precio_compra' => 'required|numeric|min:0',
            'precio_venta'  => 'required|numeric|min:0',
            'stock_actual'  => 'required|integer|min:0',
            'stock_minimo'  => 'required|integer|min:0',
            'estado'        => 'required|in:0,1',
        ]);

        $producto->update($request->all());

        return redirect()->route('productos.index')->with('success', 'Producto actualizado con éxito.');
    }

    public function destroy(Producto $producto)
    {
        $producto->delete();
        return redirect()->route('productos.index')->with('success', 'Producto eliminado de los registros.');
    }
}