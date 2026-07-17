<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Historial de Ventas y Facturación') }}
            </h2>
            <a href="{{ route('facturas.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-800 transition ease-in-out duration-150">
                + {{ __('Crear Nueva Venta') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- CONTENEDOR EN REJILLA PRINCIPAL -->
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 items-start">
                
                <!-- ====================================================
                    COLUMNA 1: PANEL LATERAL DE FILTROS (Ocupa 1 de 4)
                ===================================================== -->
                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-100 dark:border-gray-700">
                        <div class="flex justify-between items-center mb-4 pb-2 border-b dark:border-gray-700">
                            <h3 class="text-sm font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Buscar Facturas</h3>
                            @if(request()->anyFilled(['invoice_number', 'customer', 'date']))
                                <a href="{{ route('facturas.index') }}" class="text-xs text-red-500 hover:underline font-medium">Limpiar</a>
                            @endif
                        </div>

                        <!-- Formulario 100% HTML Sin JavaScript -->
                        <form action="{{ route('facturas.index') }}" method="GET" class="space-y-5">
                            
                            <!-- Búsqueda por Número de Factura -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase mb-2">Nº de Factura</label>
                                <input type="text" name="invoice_number" value="{{ request('invoice_number') }}" placeholder="Ej: 1024 o #1024..." class="w-full text-sm rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                            </div>

                            <!-- Búsqueda por Cliente -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase mb-2">Cliente</label>
                                <input type="text" name="customer" value="{{ request('customer') }}" placeholder="Nombre del cliente..." class="w-full text-sm rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                            </div>

                            <!-- Búsqueda por Fecha -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase mb-2">Fecha de Emisión</label>
                                <input type="date" name="date" value="{{ request('date') }}" class="w-full text-sm rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                            </div>

                            <!-- Botón de Envío Manual -->
                            <div class="pt-2">
                                <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2.5 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white active:bg-gray-900 focus:outline-none transition ease-in-out duration-150 shadow-sm cursor-pointer">
                                    Consultar Historial
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- ====================================================
                    COLUMNA 2: TABLA DE RESULTADOS (Ocupa 3 de 4)
                ===================================================== -->
                <div class="lg:col-span-3">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 dark:border-gray-700">
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">Nº Factura</th>
                                        <th scope="col" class="px-6 py-3">Fecha y Hora</th>
                                        <th scope="col" class="px-6 py-3">Cliente</th>
                                        <th scope="col" class="px-6 py-3">Método Pago</th>
                                        <th scope="col" class="px-6 py-3 text-right">Total Cobrado</th>
                                        <th scope="col" class="px-6 py-3 text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                    @forelse($invoices as $invoice)
                                        <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700/40">
                                            <td class="px-6 py-4 font-mono font-bold text-indigo-600 dark:text-indigo-400">#{{ $invoice->id }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-gray-600 dark:text-gray-400">{{ $invoice->created_at->format('d/m/Y H:i') }}</td>
                                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $invoice->customer_name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $invoice->payment_type }}</td>
                                            <td class="px-6 py-4 text-right font-bold font-mono text-gray-900 dark:text-gray-100">${{ number_format($invoice->total, 2) }}</td>
                                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                                <a href="{{ route('facturas.show', $invoice->id) }}" class="text-indigo-600 dark:text-indigo-400 hover:underline font-semibold">Ver Recibo ➔</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-6 py-10 text-center text-sm text-gray-500 dark:text-gray-400 italic">
                                                {{ __('No se encontraron facturas que coincidan con los criterios de búsqueda.') }}
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Paginación acoplada elegantemente a la tabla -->
                        @if($invoices->hasPages())
                            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-900/20 border-t border-gray-200 dark:border-gray-700">
                                {{ $invoices->links() }}
                            </div>
                        @endif
                    </div>
                </div>

            </div> <!-- FIN DEL GRID PRINCIPAL -->
        </div>
    </div>
</x-app-layout>