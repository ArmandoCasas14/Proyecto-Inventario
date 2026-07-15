<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        // Traemos todos los proveedores
        $suppliers = Supplier::all();
        return view('suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        return view('suppliers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'legal_name' => 'required|string|max:255',
            'nit'        => 'required|string|max:50|unique:suppliers,nit',
            'phone'      => 'nullable|string|max:50',
            'email'      => 'nullable|email|max:255',
            'address'    => 'nullable|string|max:255',
        ]);

        // Por defecto creamos el proveedor con estado activo (1)
        Supplier::create(array_merge($request->all(), ['status' => 1]));

        return redirect()->route('suppliers.index')->with('success', 'Proveedor registrado con éxito.');
    }

    public function edit(Supplier $supplier)
    {
        return view('suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'legal_name' => 'required|string|max:255',
            'nit'        => 'required|string|max:50|unique:suppliers,nit,' . $supplier->id,
            'phone'      => 'nullable|string|max:50',
            'email'      => 'nullable|email|max:255',
            'address'    => 'nullable|string|max:255',
            'status'     => 'required|in:0,1',
        ]);

        $supplier->update($request->all());

        return redirect()->route('suppliers.index')->with('success', 'Proveedor actualizado con éxito.');
    }

    public function destroy(Supplier $supplier)
    {
        // En un inventario real, si el proveedor ya tiene productos asociados,
        // cambiamos su estado a 0 (Inactivo) en vez de eliminarlo de raíz.
        if ($supplier->products()->count() > 0) {
            $supplier->update(['status' => 0]);
            return redirect()->route('suppliers.index')->with('success', 'El proveedor tiene productos asociados. Se ha cambiado su estado a Inactivo.');
        }

        $supplier->delete();
        return redirect()->route('suppliers.index')->with('success', 'Proveedor eliminado correctamente.');
    }
}