<x-app-layout>
    <!-- Fondo General Punteado -->
    <div class="relative min-h-screen bg-slate-100/70 -m-4 sm:-m-6 lg:-m-8 p-4 sm:p-6 lg:p-8 overflow-hidden flex justify-center">
        
        <!-- Textura Punteada de Fondo -->
        <div class="absolute inset-0 opacity-15 bg-[radial-gradient(#059669_1px,transparent_1px)] [background-size:16px_16px] pointer-events-none"></div>

        <!-- CONTENEDOR CENTRAL UNIFICADO -->
        <div class="w-full max-w-6xl bg-white rounded-3xl shadow-xl border border-slate-200/80 overflow-hidden relative z-10 my-auto">
            
            <!-- 1. CABECERA VERDE INTEGRADA -->
            <div class="bg-emerald-600 px-6 py-6 md:px-8 text-white flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight">Historial de Ventas y Facturación</h1>
                    <p class="text-emerald-100 text-xs md:text-sm mt-1">Consulta, filtra y revisa las facturas generadas en el sistema</p>
                </div>
                <div>
                    <a href="{{ route('facturas.create') }}" 
                       class="inline-flex items-center justify-center bg-emerald-700 hover:bg-emerald-800 text-white font-semibold px-4 py-2.5 rounded-xl text-xs md:text-sm shadow-xs transition gap-2 border border-emerald-500/50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                        Crear Nueva Venta
                    </a>
                </div>
            </div>

            <div class="p-6 md:p-8 space-y-6">

                <!-- 2. PANEL DE BÚSQUEDA MULTICAMPO -->
                <div class="bg-slate-50/80 border border-slate-200/80 rounded-2xl p-5">
                    <form action="{{ route('facturas.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 items-end">
                        
                        <!-- Campo 1: Nº de Factura -->
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Nº de Factura</label>
                            <input type="text" name="invoice_number" value="{{ request('invoice_number') }}" placeholder="Ej: 1024..." 
                                   class="w-full text-sm rounded-xl border-slate-200 bg-white text-slate-800 focus:border-emerald-500 focus:ring-emerald-500 shadow-2xs py-2 px-3 transition">
                        </div>

                        <!-- Campo 2: Cliente -->
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Cliente</label>
                            <input type="text" name="customer" value="{{ request('customer') }}" placeholder="Nombre del cliente..." 
                                   class="w-full text-sm rounded-xl border-slate-200 bg-white text-slate-800 focus:border-emerald-500 focus:ring-emerald-500 shadow-2xs py-2 px-3 transition">
                        </div>

                        <!-- Campo 3: Fecha de Emisión -->
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Fecha de Emisión</label>
                            <input type="date" name="date" value="{{ request('date') }}" 
                                   class="w-full text-sm rounded-xl border-slate-200 bg-white text-slate-800 focus:border-emerald-500 focus:ring-emerald-500 shadow-2xs py-2 px-3 transition">
                        </div>

                        <!-- Campo 4: Botonera de Acción -->
                        <div class="flex gap-2 w-full">
                            <button type="submit" 
                                    class="flex-1 px-4 py-2 bg-slate-800 hover:bg-slate-900 text-white font-bold text-xs uppercase tracking-wider rounded-xl transition shadow-xs text-center justify-center items-center cursor-pointer">
                                Buscar
                            </button>
                            @if(request()->anyFilled(['invoice_number', 'customer', 'date']))
                                <a href="{{ route('facturas.index') }}" 
                                   class="px-3 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 font-semibold text-xs uppercase tracking-wider rounded-xl transition text-center flex items-center justify-center">
                                    Limpiar
                                </a>
                            @endif
                        </div>
                    </form>
                </div>

                <!-- 3. TABLA DE RESULTADOS DE FACTURAS -->
                <div class="overflow-x-auto rounded-2xl border border-slate-100">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-slate-100/70 text-slate-500 text-xs font-bold uppercase tracking-wider">
                            <tr>
                                <th scope="col" class="px-6 py-3.5">Nº Factura</th>
                                <th scope="col" class="px-6 py-3.5">Fecha y Hora</th>
                                <th scope="col" class="px-6 py-3.5">Cliente</th>
                                <th scope="col" class="px-6 py-3.5">Método Pago</th>
                                <th scope="col" class="px-6 py-3.5 text-right">Total Cobrado</th>
                                <th scope="col" class="px-6 py-3.5 text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white">
                            @forelse($invoices as $invoice)
                                <tr class="hover:bg-slate-50/80 transition">
                                    <td class="px-6 py-4 font-mono font-bold text-emerald-700">#{{ $invoice->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-slate-600 text-xs font-medium">
                                        {{ $invoice->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 font-semibold text-slate-800">{{ $invoice->customer_name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-slate-100 text-slate-700 border border-slate-200/60">
                                            {{ $invoice->payment_type }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right font-bold font-mono text-slate-900 text-base">
                                        ${{ number_format($invoice->total, 2) }}
                                    </td>
                                    <td class="px-6 py-4 text-center whitespace-nowrap">
                                        <!-- BOTÓN DE ACCIÓN CON ESTILO OJO AZUL CLARO -->
                                         <a href="{{ route('facturas.show', $invoice->id) }}"
                                                    title="{{ __('Ver Detalle') }}"
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
                                    <td colspan="6" class="px-6 py-12 text-center text-slate-400 italic">
                                        📄 {{ __('No se encontraron facturas que coincidan con los criterios de búsqueda.') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                @if($invoices->hasPages())
                    <div class="pt-2">
                        {{ $invoices->links() }}
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>