<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => Role::all()
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:roles,name',
        ]);

        $role = Role::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Rol creado correctamente',
            'data'    => $role
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $role = Role::find($id);

        if (!$role) {
            return response()->json(['success' => false, 'message' => 'Rol no encontrado'], 404);
        }

        return response()->json(['success' => true, 'data' => $role], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $role = Role::find($id);

        if (!$role) {
            return response()->json(['success' => false, 'message' => 'Rol no encontrado'], 404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:roles,name,' . $id,
        ]);

        $role->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Rol actualizado correctamente',
            'data'    => $role
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
