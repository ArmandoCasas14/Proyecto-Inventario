<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Ventas - Cierre de Caja</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen py-8 px-4">

    <div class="max-w-6xl mx-auto">
        
        @if (session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-xl text-green-700 text-sm shadow-sm flex justify-between items-center">
                <span>{{ session('success') }}</span>
                <button onclick="this.parentElement.remove()" class="text-green-500 hover:text-green-700 font-bold">×</button>
            </div>
        @endif

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Control de Caja e Historial</h1>
                <p class="text-gray-500">Consulta de facturas emitidas, totales cobrados y auditoría de inventario</p>
            </div>
            <a href="{{ route('invoices.create') }}" 
               class="inline-flex items-center justify-center bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-6 py-3 rounded-xl shadow-md hover:shadow-lg transition duration-150 gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Registrar Nueva Venta
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <div class="text-xs font-bold text-gray-400 uppercase mb-1">Total Facturado en Página Actual</div>
                <div class="text-2xl font-bold text-gray-900" id="total_page">
                    ${{ number_format($invoices->sum('total'), 2) }}
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <div class="text-xs font-bold text-gray-400 uppercase mb-1">Transacciones en Página</div>
                <div class="text-2xl font-bold text-gray-900">
                    {{ $invoices->count() }} ventas
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 flex justify-between items-center">
                <div>
                    <div class="text-xs font-bold text-gray-400 uppercase mb-1">Manejo de Existencias</div>
                    <div class="text-lg font-bold text-indigo-600">Catálogo de Productos</div>
                </div>
                <a href="{{ route('products.index') }}" class="text-indigo-600 hover:text-indigo-800 font-semibold text-sm transition">
                    Ver Stock →
                </a>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                <h2 class="font-bold text-gray-800">Listado de Facturas Recientes</h2>
                <span class="bg-indigo-100 text-indigo-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">
                    Mostrando {{ $invoices->count() }} de {{ $invoices->total() }} registros
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Factura #</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Fecha y Hora</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Cliente</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Método de Pago</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Total</th>
                            <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($invoices as $invoice)
                            <tr class="hover:bg-gray-50 transition duration-75">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-mono font-bold text-indigo-600">
                                    #{{ str_pad($invoice->id, 5, '0', STR_PAD_LEFT) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $invoice->created_at->format('d/m/Y - h:i A') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                    {{ $invoice->customer_name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        {{ $invoice->payment_type == 'Efectivo' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $invoice->payment_type == 'Transferencia' ? 'bg-blue-100 text-blue-800' : '' }}
                                        {{ $invoice->payment_type == 'Tarjeta' ? 'bg-purple-100 text-purple-800' : '' }}">
                                        {{ $invoice->payment_type }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-bold text-gray-900">
                                    ${{ number_format($invoice->total, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <a href="{{ route('invoices.show', $invoice->id) }}" 
                                       class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 px-3 py-1.5 rounded-lg transition">
                                        Ver Detalle
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-400 text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    No se han registrado facturas ni movimientos de caja el día de hoy.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($invoices->hasPages())
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    {{ $invoices->links() }}
                </div>
            @endif
        </div>

    </div>

</body>
</html>