<x-app-layout>
    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 no-print">
                <div>
                    <h2 class="text-2xl font-extrabold text-gray-900 dark:text-white flex items-center gap-2">
                        <span>🧾</span> Factura #{{ str_pad($invoice->id, 6, '0', STR_PAD_LEFT) }}
                    </h2>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                        Registrada el {{ $invoice->created_at->format('d/m/Y \a \l\a\s h:i A') }}
                    </p>
                </div>
                <div class="flex items-center gap-3 w-full sm:w-auto">
                    <a href="{{ route('facturas.index') }}" 
                       class="inline-flex items-center justify-center gap-2 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 font-bold py-2.5 px-5 rounded-xl border border-gray-300 dark:border-gray-600 shadow-sm transition duration-150 text-sm">
                        <span>⬅️</span> Volver al Listado
                    </a>
                    
                    <button onclick="window.print()" 
                            class="inline-flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-500 text-white font-bold py-2.5 px-5 rounded-xl shadow-md transition duration-150 text-sm">
                        <span>🖨️</span> Imprimir Factura
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 print-container">
                
                <div class="space-y-6">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-150 dark:border-gray-700 shadow-sm print-card">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2 border-b border-gray-100 dark:border-gray-700 pb-3">
                            <span>👤</span> Información del Cliente
                        </h3>

                        <div class="space-y-4">
                            <div>
                                <span class="block text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Nombre Completo</span>
                                <p class="text-sm font-semibold text-gray-800 dark:text-gray-200 mt-0.5">
                                    {{ $invoice->customer_name }}
                                </p>
                            </div>

                            <div>
                                <span class="block text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Método de Pago</span>
                                <p class="text-sm font-semibold text-gray-800 dark:text-gray-200 mt-0.5 flex items-center gap-1.5">
                                    @if($invoice->payment_type === 'Efectivo')
                                        <span>💵</span> Efectivo
                                    @elseif($invoice->payment_type === 'Tarjeta')
                                        <span>💳</span> Tarjeta de Crédito/Débito
                                    @else
                                        <span>📱</span> Transferencia bancaria
                                    @endif
                                </p>
                            </div>

                            <div>
                                <span class="block text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Fecha y Hora de Emisión</span>
                                <p class="text-sm font-semibold text-gray-800 dark:text-gray-200 mt-0.5">
                                    {{ $invoice->created_at->format('d/m/Y - h:i A') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-150 dark:border-gray-700 shadow-sm overflow-hidden flex flex-col h-full print-card">
                        
                        <div class="bg-indigo-600 dark:bg-indigo-950 text-white px-8 py-5 flex items-center justify-between print-header">
                            <div>
                                <h2 class="text-xl font-extrabold tracking-tight">Comprobante de Venta</h2>
                                <p class="text-indigo-200 text-xs mt-1">Transacción procesada correctamente.</p>
                            </div>
                            <div class="bg-indigo-500 dark:bg-indigo-800/80 px-4 py-2 rounded-xl border border-indigo-400/35">
                                <span class="text-[10px] uppercase font-bold tracking-wider block text-indigo-200">Total Pagado</span>
                                <span class="text-2xl font-black">${{ number_format($invoice->total, 2) }}</span>
                            </div>
                        </div>

                        <div class="p-6 flex-1">
                            <div class="overflow-x-auto rounded-xl border border-gray-150 dark:border-gray-750">
                                <table class="w-full text-left border-collapse">
                                    <thead>
                                        <tr class="bg-gray-50 dark:bg-gray-900/40 border-b border-gray-150 dark:border-gray-700 text-gray-400 dark:text-gray-500 font-bold text-[11px] uppercase tracking-wider">
                                            <th class="px-6 py-4">Código</th>
                                            <th class="px-6 py-4">Producto</th>
                                            <th class="px-6 py-4 text-center">Cantidad</th>
                                            <th class="px-6 py-4 text-right">Precio Unitario</th>
                                            <th class="px-6 py-4 text-right">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                        @foreach($invoice->items as $item)
                                            <tr class="hover:bg-indigo-50/10 dark:hover:bg-indigo-950/5 transition">
                                                <td class="px-6 py-4 text-sm font-mono text-gray-400 dark:text-gray-500">
                                                    {{ $item->product->code ?? 'N/A' }}
                                                </td>
                                                <td class="px-6 py-4 text-sm font-bold text-gray-900 dark:text-white">
                                                    {{ $item->product->name ?? 'Producto no disponible' }}
                                                </td>
                                                <td class="px-6 py-4 text-sm text-center font-semibold text-gray-700 dark:text-gray-300">
                                                    {{ $item->quantity }}
                                                </td>
                                                <td class="px-6 py-4 text-sm text-right font-medium text-gray-900 dark:text-white">
                                                    ${{ number_format($item->unit_price, 2) }}
                                                </td>
                                                <td class="px-6 py-4 text-sm text-right font-bold text-indigo-600 dark:text-indigo-400">
                                                    ${{ number_format($item->quantity * $item->unit_price, 2) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="p-6 bg-gray-50 dark:bg-gray-900/20 border-t border-gray-150 dark:border-gray-700 flex flex-col items-end gap-1.5">
                            <div class="flex justify-between w-64 text-sm">
                                <span class="text-gray-500 dark:text-gray-400">Subtotal:</span>
                                <span class="font-semibold text-gray-900 dark:text-white">${{ number_format($invoice->total, 2) }}</span>
                            </div>
                            <div class="flex justify-between w-64 text-sm border-b dark:border-gray-700 pb-2 mb-2">
                                <span class="text-gray-500 dark:text-gray-400">Impuestos (Incluidos):</span>
                                <span class="font-semibold text-emerald-600 dark:text-emerald-400">$0.00</span>
                            </div>
                            <div class="flex justify-between w-64 text-base font-black">
                                <span class="text-gray-900 dark:text-white">Total:</span>
                                <span class="text-xl text-indigo-600 dark:text-indigo-400">${{ number_format($invoice->total, 2) }}</span>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <style>
        @media print {
            /* Ocultar barra de navegación de Laravel, botones y pie de página */
            nav, .no-print, button, a {
                display: none !important;
            }
            /* Resetear fondos del body */
            body {
                background-color: white !important;
                color: black !important;
            }
            /* Forzar visualización de grid lado a lado o en bloque ordenado en papel */
            .print-container {
                display: block !important;
            }
            .print-card {
                border: 1px solid #e5e7eb !important;
                box-shadow: none !important;
                margin-bottom: 1.5rem !important;
                background-color: white !important;
                color: black !important;
            }
            /* Encabezados legibles en escala de grises / color estándar */
            .print-header {
                background-color: #4f46e5 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
                color: white !important;
            }
            /* Quitar scrollbars y forzar ancho completo */
            .max-w-7xl {
                max-width: 100% !important;
                width: 100% !important;
                padding: 0 !important;
                margin: 0 !important;
            }
        }
    </style>
</x-app-layout>