<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Detalle de Factura #{{ $invoice->id }}
            </h2>
            <div class="space-x-2">
                <a href="{{ route('facturas.index') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50">
                    Volver al Listado
                </a>
                <button onclick="window.print()" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white">
                    🖨️ Imprimir Factura
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-12 printable-area">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative shadow no-print" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md sm:rounded-lg p-8 border dark:border-gray-700">
                
                <!-- Encabezado del Recibo -->
                <div class="flex justify-between items-start border-b pb-6 mb-6 dark:border-gray-700">
                    <div>
                        <h1 class="text-3xl font-black text-indigo-600 dark:text-indigo-400">SISTEMA INVENTARIO</h1>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Comprobante electrónico de venta interna</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-500 dark:text-gray-400">Fecha de Emisión</p>
                        <p class="text-lg font-bold text-gray-800 dark:text-gray-200 font-mono">{{ $invoice->created_at->format('d/m/Y H:i A') }}</p>
                    </div>
                </div>

                <!-- Datos Cliente -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg mb-6">
                    <div>
                        <span class="text-xs uppercase tracking-wider text-gray-400 font-semibold">Cliente</span>
                        <p class="text-lg font-bold text-gray-800 dark:text-gray-100">{{ $invoice->customer_name }}</p>
                    </div>
                    <div class="md:text-right">
                        <span class="text-xs uppercase tracking-wider text-gray-400 font-semibold">Método de Pago</span>
                        <p class="text-lg font-bold text-indigo-600 dark:text-indigo-400">{{ $invoice->payment_type }}</p>
                    </div>
                </div>

                <!-- Tabla de Artículos -->
                <div class="overflow-x-auto mb-6">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-4 py-3">Descripción Artículo</th>
                                <th scope="col" class="px-4 py-3 text-center">Cantidad</th>
                                <th scope="col" class="px-4 py-3 text-right">Precio Unitario</th>
                                <th scope="col" class="px-4 py-3 text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($invoice->items as $item)
                            <tr class="border-b dark:border-gray-700 text-gray-900 dark:text-gray-100">
                                <td class="px-4 py-4 font-medium">
                                    {{ $item->product->name }}
                                    @if($item->product->trashed())
                                        <span class="text-xs text-red-500 font-normal italic">(Eliminado del catálogo)</span>
                                    @endif
                                </td>
                                <td class="px-4 py-4 text-center font-semibold font-mono">{{ $item->quantity }}</td>
                                <td class="px-4 py-4 text-right font-mono">${{ number_format($item->unit_price, 2) }}</td>
                                <td class="px-4 py-4 text-right font-bold font-mono">${{ number_format($item->quantity * $item->unit_price, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Cierre del Total -->
                <div class="flex justify-end border-t pt-4 dark:border-gray-700">
                    <div class="w-64 text-right space-y-2">
                        <div class="flex justify-between text-gray-500 dark:text-gray-400">
                            <span>Subtotal:</span>
                            <span class="font-mono">${{ number_format($invoice->total, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-gray-500 dark:text-gray-400">
                            <span>Impuestos (0%):</span>
                            <span class="font-mono">$0.00</span>
                        </div>
                        <div class="flex justify-between text-xl font-black text-gray-900 dark:text-white border-t pt-2 dark:border-gray-600">
                            <span>Total Neto:</span>
                            <span class="text-indigo-600 dark:text-indigo-400 font-mono">${{ number_format($invoice->total, 2) }}</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Estilos CSS adicionales para la impresión limpia -->
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