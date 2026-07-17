<x-app-layout>
    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-50 dark:bg-emerald-950/30 border-l-4 border-emerald-500 rounded-r-xl flex items-center justify-between shadow-xs">
                    <div class="flex items-center gap-3">
                        <span class="text-emerald-500 text-lg">✅</span>
                        <span class="text-sm font-semibold text-emerald-800 dark:text-emerald-300">{{ session('success') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-emerald-600 font-bold">×</button>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-150 dark:border-gray-700 shadow-xs flex items-center gap-5">
                    <div class="w-12 h-12 rounded-xl bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 flex items-center justify-center text-xl font-bold">
                        💰
                    </div>
                    <div>
                        <span class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Flujo de Caja Total</span>
                        <h4 class="text-2xl font-black text-gray-900 dark:text-white mt-0.5">${{ number_format($invoices->sum('total'), 2) }}</h4>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-150 dark:border-gray-700 shadow-xs flex items-center gap-5">
                    <div class="w-12 h-12 rounded-xl bg-amber-50 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 flex items-center justify-center text-xl font-bold">
                        🧾
                    </div>
                    <div>
                        <span class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Facturas Emitidas</span>
                        <h4 class="text-2xl font-black text-gray-900 dark:text-white mt-0.5">{{ $invoices->count() }}</h4>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-150 dark:border-gray-700 shadow-xs flex items-center gap-5">
                    <div class="w-12 h-12 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-xl font-bold">
                        📈
                    </div>
                    <div>
                        <span class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Ticket Promedio</span>
                        <h4 class="text-2xl font-black text-gray-900 dark:text-white mt-0.5">
                            ${{ number_format($invoices->count() > 0 ? $invoices->avg('total') : 0, 2) }}
                        </h4>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-150 dark:border-gray-700 shadow-md overflow-hidden">
                
                <div class="bg-indigo-600 dark:bg-indigo-900 text-white px-8 py-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h1 class="text-2xl font-extrabold tracking-tight">Historial de Ventas</h1>
                        <p class="text-indigo-200 text-xs mt-1.5">Control de caja diaria, listado y arqueo de facturaciones realizadas.</p>
                    </div>
                    <div>
                        <a href="{{ route('facturas.create') }}"
                           class="inline-flex items-center justify-center bg-indigo-500 hover:bg-indigo-400 text-white font-bold py-2.5 px-5 rounded-xl border border-indigo-400/50 shadow-sm transition duration-150 text-sm">
                            + Registrar Nueva Venta
                        </a>
                    </div>
                </div>

                <div class="p-6">
                    <div class="overflow-x-auto rounded-xl border border-gray-150 dark:border-gray-750">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50 dark:bg-gray-900/40 border-b border-gray-150 dark:border-gray-700 text-gray-400 dark:text-gray-500 font-bold text-[11px] uppercase tracking-wider">
                                    <th class="px-6 py-4">ID de Venta</th>
                                    <th class="px-6 py-4">Fecha y Hora</th>
                                    <th class="px-6 py-4">Cliente</th>
                                    <th class="px-6 py-4 text-center">Método de Pago</th>
                                    <th class="px-6 py-4 text-right">Total Cobrado</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                @forelse($invoices as $invoice)
                                    <tr class="hover:bg-indigo-50/10 dark:hover:bg-indigo-950/5 transition duration-150">
                                        <td class="px-6 py-4 text-sm font-mono text-gray-400 dark:text-gray-500">
                                            #FAC-{{ str_pad($invoice->id, 5, '0', STR_PAD_LEFT) }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400 font-medium">
                                            {{ $invoice->created_at->format('d/m/Y - h:i A') }}
                                        </td>
                                        <td class="px-6 py-4 text-sm font-bold text-gray-900 dark:text-white">
                                            {{ $invoice->customer_name }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center justify-center">
                                                @if($invoice->payment_type === 'Efectivo')
                                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 dark:bg-emerald-950/30 text-emerald-700 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-900/40">
                                                        💵 {{ $invoice->payment_type }}
                                                    </span>
                                                @elseif($invoice->payment_type === 'Tarjeta')
                                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-blue-50 dark:bg-blue-950/30 text-blue-700 dark:text-blue-400 border border-blue-100 dark:border-blue-900/40">
                                                        💳 {{ $invoice->payment_type }}
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-purple-50 dark:bg-purple-950/30 text-purple-700 dark:text-purple-400 border border-purple-100 dark:border-purple-900/40">
                                                        📱 {{ $invoice->payment_type }}
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-right font-black text-gray-900 dark:text-white">
                                            ${{ number_format($invoice->total, 2) }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-16 text-center text-gray-400 dark:text-gray-500">
                                            <span class="text-4xl block mb-2">🧾</span>
                                            <p class="font-bold">No se han registrado facturas todavía.</p>
                                            <p class="text-xs mt-1">Crea una venta desde el panel del sistema.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>