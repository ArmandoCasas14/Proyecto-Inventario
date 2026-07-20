<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        $suppliers = Supplier::query()
            ->search($request->input('search'))
            ->ofStatus($request->input('status'))
            ->orderBy('legal_name', 'asc')
            ->paginate(10)
            ->withQueryString();

        return view('suppliers.index', compact('suppliers'));
    }

    public function toggleStatus(Supplier $supplier)
    {
        // 1. Si el proveedor está ACTIVO e intentan INACTIVARLO (pasar a 0)
        if ($supplier->status == 1) {
            
            // Verificamos si tiene productos asociados
            if ($supplier->products()->exists()) {
                return redirect()->route('proveedores.index')->with(
                    'error', 
                    "No se puede inactivar el proveedor '{$supplier->legal_name}' porque tiene productos vinculados en el sistema."
                );
            }
        }

        // 2. Si pasa la validación (o si se está activando), conmutamos el estado
        $supplier->status = $supplier->status ? 0 : 1;
        $supplier->save();

        $mensaje = $supplier->status 
            ? 'El proveedor ha sido activado correctamente.' 
            : 'El proveedor ha sido desactivado correctamente.';

        return redirect()->route('proveedores.index')->with('success', $mensaje);
    }

    public function create()
    {
        return view('suppliers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'legal_name' => 'required|string|max:100',
            'nit'        => 'required|string|max:10|unique:suppliers,nit',
            'phone'      => 'nullable|string|max:20',
            'email'      => 'nullable|email|max:45',
            'address'    => 'nullable|string|max:100',
        ]);

        // Por defecto creamos el proveedor con estado activo (1)
        Supplier::create(array_merge($request->all(), ['status' => 1]));

        return redirect()->route('proveedores.index')->with('success', 'Proveedor registrado con éxito.');
    }

    public function edit(Supplier $supplier)
    {
        if (auth()->user()->role->name !== 'Administrador') {
        abort(403, 'No tienes permiso para editar categorías.');
    }
        return view('suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        if (auth()->user()->role->name !== 'Administrador') {
        abort(403, 'No tienes permiso para editar categorías.');
    }
        $request->validate([
            'legal_name' => 'required|string|max:255',
            'nit'        => 'required|string|max:50|unique:suppliers,nit,' . $supplier->id,
            'phone'      => 'nullable|string|max:50',
            'email'      => 'nullable|email|max:255',
            'address'    => 'nullable|string|max:255',
            'status'     => 'required|in:0,1',
        ]);

        $supplier->update($request->all());

        return redirect()->route('proveedores.index')->with('success', 'Proveedor actualizado con éxito.');
    }

    public function destroy(Supplier $supplier)
    {
        // En un inventario real, si el proveedor ya tiene productos asociados,
        // cambiamos su estado a 0 (Inactivo) en vez de eliminarlo de raíz.
        if ($supplier->products()->count() > 0) {
            $supplier->update(['status' => 0]);
            return redirect()->route('proveedores.index')->with('success', 'El proveedor tiene productos asociados. Se ha cambiado su estado a Inactivo.');
        }

        $supplier->delete();
        return redirect()->route('proveedores
        .index')->with('success', 'Proveedor eliminado correctamente.');
    }
}