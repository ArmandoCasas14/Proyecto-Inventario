<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\InvoiceItem;
use Illuminate\Http\Request;

class InvoiceItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = InvoiceItem::query();

        // Si envían un invoice_id, filtramos por él
        if ($request->has('invoice_id')) {
            $query->where('invoice_id', $request->invoice_id);
        }

        return response()->json([
            'success' => true,
            'data' => $query->get()
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'invoice_id' => 'required|exists:invoices,id',
            'product_id' => 'required|integer',
            'quantity'   => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0'
        ]);

        $item = InvoiceItem::create($validated);

        return response()->json([
            'success' => true,
            'data'    => $item
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $item = InvoiceItem::find($id);

        if (!$item) {
            return response()->json(['success' => false, 'message' => 'Ítem no encontrado'], 404);
        }

        return response()->json(['success' => true, 'data' => $item], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $item = InvoiceItem::find($id);

        if (!$item) {
            return response()->json(['success' => false, 'message' => 'Ítem no encontrado'], 404);
        }

        $validated = $request->validate([
            'quantity'   => 'sometimes|required|integer|min:1',
            'unit_price' => 'sometimes|required|numeric|min:0'
        ]);

        $item->update($validated);

        return response()->json(['success' => true, 'data' => $item], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
