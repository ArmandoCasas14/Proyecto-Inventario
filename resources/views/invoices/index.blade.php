<x-app-layout>
    <!-- CONTENEDOR PRINCIPAL QUE ANULA EL PADDING DEL LAYOUT BASE -->
    <div class="relative min-h-[calc(100vh-4rem)] -m-4 sm:-m-6 lg:-m-8 p-4 sm:p-6 lg:p-8 bg-[#f3f7f6] dark:bg-slate-950 bg-[radial-gradient(#cbd5e1_1px,transparent_1px)] dark:bg-[radial-gradient(#1e293b_1px,transparent_1px)] [background-size:16px_16px] flex justify-center items-start">
        
        <!-- CONTENEDOR CENTRAL UNIFICADO -->
        <div class="w-full max-w-7xl bg-white dark:bg-slate-800 rounded-3xl shadow-xl border border-slate-200/80 dark:border-slate-700/80 overflow-hidden relative z-10 my-4">
            
            <!-- BANNER ENCABEZADO SUPERIOR VERDE -->
            <div class="bg-emerald-600 dark:bg-emerald-700 px-6 py-6 sm:px-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h2 class="font-bold text-2xl text-white tracking-tight">
                        Historial de Ventas y Facturación
                    </h2>
                    <p class="text-xs text-emerald-100 mt-1">
                        Consulta, filtra y revisa las facturas generadas en el sistema
                    </p>
                </div>

                <!-- Botones de Acción Global -->
                <div class="flex items-center gap-3">
                    <a href="{{ route('facturas.create') }}"
                       class="inline-flex items-center px-4 py-2.5 bg-emerald-800 hover:bg-emerald-900 text-white font-semibold text-xs rounded-xl transition-all shadow-sm gap-2 focus:outline-none">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Crear Nueva Venta
                    </a>
                </div>
            </div>

            <!-- CUERPO DE LA TARJETA -->
            <div class="p-6 sm:p-8 space-y-6">

                <!-- ALERTAS DE SESIÓN -->
                @if (session('success'))
                    <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 dark:bg-emerald-950/30 dark:border-emerald-800/50 text-emerald-800 dark:text-emerald-300 text-sm shadow-sm flex items-center gap-3">
                        <div class="p-1 bg-emerald-100 dark:bg-emerald-900/50 rounded-lg text-emerald-600 dark:text-emerald-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                @endif

                <!-- FILTROS Y BÚSQUEDA ALINEADOS (DISTRIBUCIÓN EN 12 COLUMNAS) -->
                <div class="bg-slate-50/70 dark:bg-slate-900/60 p-4 rounded-2xl border border-slate-200/60 dark:border-slate-700/60">
                    <form action="{{ route('facturas.index') }}" method="GET">
                        <div class="grid grid-cols-1 md:grid-cols-12 gap-3 items-end">
                            
                            <!-- Campo 1: Nº de Factura -->
                            <div class="md:col-span-2">
                                <label class="block text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">
                                    Nº Factura
                                </label>
                                <input type="text" name="invoice_number" value="{{ request('invoice_number') }}" 
                                       placeholder="Ej: 1024..." 
                                       class="w-full text-xs rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm transition-colors py-2.5">
                            </div>

                            <!-- Campo 2: Cliente -->
                            <div class="md:col-span-3">
                                <label class="block text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">
                                    Cliente
                                </label>
                                <input type="text" name="customer" value="{{ request('customer') }}" 
                                       placeholder="Nombre del cliente..." 
                                       class="w-full text-xs rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm transition-colors py-2.5">
                            </div>

                            <!-- Campo 3: Fecha de Emisión -->
                            <div class="md:col-span-2">
                                <label class="block text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">
                                    Fecha
                                </label>
                                <input type="date" name="date" value="{{ request('date') }}" 
                                       class="w-full text-xs rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm transition-colors py-2.5">
                            </div>

                            <!-- Campo 4: Método de Pago -->
                            <div class="md:col-span-3">
                                <label for="payment_type" class="block text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">
                                    Método de Pago
                                </label>
                                <select id="payment_type" name="payment_type" 
                                        class="w-full text-xs rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm transition-colors py-2.5">
                                    <option value="" {{ !request('payment_type') ? 'selected' : '' }}>Todos los métodos</option>
                                    <option value="Efectivo" {{ request('payment_type') === 'Efectivo' ? 'selected' : '' }}>Efectivo</option>
                                    <option value="Tarjeta" {{ request('payment_type') === 'Tarjeta' ? 'selected' : '' }}>Tarjeta</option>
                                    <option value="Transferencia" {{ request('payment_type') === 'Transferencia' ? 'selected' : '' }}>Transferencia</option>
                                </select>
                            </div>

                            <!-- Botones Buscar / Limpiar (X) -->
                            <div class="md:col-span-2 flex items-center gap-2">
                                <button type="submit" 
                                        class="w-full h-[38px] bg-slate-800 hover:bg-slate-900 dark:bg-slate-700 dark:hover:bg-slate-600 text-white font-bold text-xs uppercase tracking-wider rounded-xl transition-all shadow-sm flex items-center justify-center cursor-pointer">
                                    BUSCAR
                                </button>

                                @if(request()->anyFilled(['invoice_number', 'customer', 'date', 'payment_type']))
                                    <a href="{{ route('facturas.index') }}" title="Limpiar filtros"
                                       class="h-[38px] px-3 bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-200 font-bold text-xs uppercase rounded-xl hover:bg-slate-300 dark:hover:bg-slate-600 transition-colors flex items-center justify-center shrink-0">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </a>
                                @endif
                            </div>

                        </div>
                    </form>
                </div>

                <!-- TABLA DE RESULTADOS -->
                <div class="overflow-x-auto rounded-2xl border border-slate-200/80 dark:border-slate-700/80">
                    <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700/80 text-left">
                        <thead class="bg-slate-50/80 dark:bg-slate-900/80 text-slate-500 dark:text-slate-400 uppercase tracking-wider text-[11px] font-bold">
                            <tr>
                                <th class="px-6 py-4">Nº Factura</th>
                                <th class="px-6 py-4">Fecha y Hora</th>
                                <th class="px-6 py-4">Cliente</th>
                                <th class="px-6 py-4">Método Pago</th>
                                <th class="px-6 py-4 text-right">Total Cobrado</th>
                                <th class="px-6 py-4 text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-700/50 text-xs bg-white dark:bg-slate-800">
                            @forelse ($invoices as $invoice)
                                <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-700/30 transition-colors">
                                    <td class="px-6 py-4 font-mono font-bold text-emerald-600 dark:text-emerald-400">
                                        #{{ $invoice->id }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-slate-600 dark:text-slate-300">
                                        {{ $invoice->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 font-semibold text-slate-800 dark:text-slate-100">
                                        {{ $invoice->customer_name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300 border border-slate-200/60 dark:border-slate-600">
                                            {{ $invoice->payment_type }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right font-mono font-bold text-slate-800 dark:text-slate-100">
                                        ${{ number_format($invoice->total, 2) }}
                                    </td>
                                    <td class="px-6 py-4 text-center whitespace-nowrap">
                                        <a href="{{ route('facturas.show', $invoice->id) }}"
                                           title="Ver Detalle"
                                           class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-sky-100 text-sky-700 hover:bg-sky-500 hover:text-white dark:bg-sky-900/40 dark:text-sky-300 dark:hover:bg-sky-600 dark:hover:text-white transition ease-in-out duration-150 shadow-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-slate-500 dark:text-slate-400 italic">
                                        📄 No se encontraron facturas con los filtros seleccionados.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($invoices->hasPages())
                    <div class="pt-2">
                        {{ $invoices->links() }}
                    </div>
                @endif

            </div>

        </div>
    </div>
</x-app-layout>