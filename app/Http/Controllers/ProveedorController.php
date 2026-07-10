<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    public function index()
    {
        $proveedores = Proveedor::all();
        return view('proveedores.index', compact('proveedores'));
    }

    public function create()
    {
        return view('proveedores.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'razon_social' => 'required|string|max:255',
            'nit'          => 'required|string|max:50|unique:proveedores,nit',
            'telefono'     => 'nullable|string|max:50',
            'email'        => 'nullable|email|max:255',
            'direccion'    => 'nullable|string|max:255',
        ]);

        // Por defecto creamos el proveedor con estado activo (1)
        Proveedor::create(array_merge($request->all(), ['estado' => 1]));

        return redirect()->route('proveedores.index')->with('success', 'Proveedor registrado con éxito.');
    }

    public function edit(Proveedor $proveedore)
    {
        return view('proveedores.edit', compact('proveedore'));
    }

    public function update(Request $request, Proveedor $proveedor)
    {
        $request->validate([
            'razon_social' => 'required|string|max:255',
            'nit'          => 'required|string|max:50|unique:proveedores,nit,' . $proveedor->id,
            'telefono'     => 'nullable|string|max:50',
            'email'        => 'nullable|email|max:255',
            'direccion'    => 'nullable|string|max:255',
            'estado'       => 'required|in:0,1',
        ]);

        $proveedor->update($request->all());

        return redirect()->route('proveedores.index')->with('success', 'Proveedor actualizado con éxito.');
    }

    public function destroy(Proveedor $proveedor)
    {
        // En un inventario real, es mejor cambiar el estado a 0 (desactivar) en vez de borrar de raíz
        // si el proveedor ya tiene productos asociados para no romper la integridad.
        if ($proveedor->productos()->count() > 0) {
            $proveedor->update(['estado' => 0]);
            return redirect()->route('proveedores.index')->with('success', 'El proveedor tiene productos asociados. Se ha cambiado su estado a Inactivo.');
        }

        $proveedor->delete();
        return redirect()->route('proveedores.index')->with('success', 'Proveedor eliminado correctamente.');
    }
}