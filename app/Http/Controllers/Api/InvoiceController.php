<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices = Invoice::latest()->get();

        return response()->json([
            'success' => true,
            'data' => $invoices
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        // Validamos basándonos en tu $fillable
        $validated = $request->validate([
            'customer_name' => 'required|string|max:100',
            'total'         => 'required|numeric|min:0',
            'payment_type'  => 'required|string|max:50'
        ]);

        // Guardamos
        $invoice = Invoice::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Factura registrada con éxito',
            'data'    => $invoice
        ], 201);
    
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Buscamos la factura por su ID
        $invoice = Invoice::find($id);

        // Si no existe, devolvemos un error 404
        if (!$invoice) {
            return response()->json([
                'success' => false,
                'message' => 'Factura no encontrada'
            ], 404);
        }

        // Si existe, la devolvemos
        return response()->json([
            'success' => true,
            'data' => $invoice
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // 1. Buscamos la factura
        $invoice = Invoice::find($id);

        if (!$invoice) {
            return response()->json([
                'success' => false,
                'message' => 'Factura no encontrada'
            ], 404);
        }

        // 2. Validamos los datos (usando 'sometimes' para permitir actualizaciones parciales)
        $validated = $request->validate([
            'customer_name' => 'sometimes|required|string|max:100',
            'total'         => 'sometimes|required|numeric|min:0',
            'payment_type'  => 'sometimes|required|string|max:50'
        ]);

        // 3. Actualizamos
        $invoice->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Factura actualizada correctamente',
            'data'    => $invoice
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
