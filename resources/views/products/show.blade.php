<x-app-layout>
    <div class="relative min-h-[calc(100vh-4rem)] -m-4 sm:-m-6 lg:-m-8 p-4 sm:p-6 lg:p-8 bg-[#f3f7f6] dark:bg-slate-950 bg-[radial-gradient(#cbd5e1_1px,transparent_1px)] dark:bg-[radial-gradient(#1e293b_1px,transparent_1px)] [background-size:16px_16px] flex justify-center items-start">
        
        <!-- CONTENEDOR CENTRAL -->
        <div class="w-full max-w-7xl bg-white dark:bg-slate-800 rounded-3xl shadow-xl border border-slate-200/80 dark:border-slate-700/80 overflow-hidden relative z-10 my-4">
            
            <!-- BANNER ENCABEZADO SUPERIOR VERDE -->
            <div class="bg-emerald-600 dark:bg-emerald-700 px-6 py-6 sm:px-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <div class="flex items-center gap-3">
                        <h2 class="font-bold text-2xl text-white tracking-tight">
                            {{ $product->name }}
                        </h2>
                        @if ($product->status)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 dark:bg-emerald-950/80 dark:text-emerald-300">
                                {{ __('Activo') }}
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-slate-200 text-slate-700 dark:bg-slate-700 dark:text-slate-300">
                                {{ __('Inactivo') }}
                            </span>
                        @endif
                    </div>
                    <p class="text-xs text-emerald-100 mt-1 font-mono">
                        {{ __('Código SKU/Ref:') }} <span class="font-semibold text-white">#{{ $product->code }}</span>
                    </p>
                </div>

                <div class="flex items-center gap-3">
                    <a href="{{ route('productos.edit', $product) }}" 
                       class="inline-flex items-center px-4 py-2.5 bg-amber-500 hover:bg-amber-600 text-white font-semibold text-xs rounded-xl transition-all shadow-sm gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        {{ __('Editar') }}
                    </a>
                    <a href="{{ route('productos.index') }}" 
                       class="inline-flex items-center px-4 py-2.5 bg-emerald-800 hover:bg-emerald-900 text-white font-semibold text-xs rounded-xl transition-all shadow-sm gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        {{ __('Volver') }}
                    </a>
                </div>
            </div>

            <!-- CUERPO DE LA VISTA -->
            <div class="p-6 sm:p-8 space-y-6">

                <!-- TARJETAS MÉTRICAS CLAVE -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Stock Actual -->
                    <div class="bg-slate-50/70 dark:bg-slate-900/60 p-5 rounded-2xl border border-slate-200/60 dark:border-slate-700/60">
                        <div class="flex items-center justify-between">
                            <span class="text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">{{ __('Stock Actual') }}</span>
                            @if ($product->current_stock <= 0)
                                <span class="px-2 py-0.5 text-[10px] font-bold uppercase rounded-full bg-rose-100 text-rose-800 dark:bg-rose-950/60 dark:text-rose-300">{{ __('Agotado') }}</span>
                            @elseif($product->current_stock <= $product->minimum_stock)
                                <span class="px-2 py-0.5 text-[10px] font-bold uppercase rounded-full bg-amber-100 text-amber-800 dark:bg-amber-950/60 dark:text-amber-300">{{ __('Bajo Stock') }}</span>
                            @else
                                <span class="px-2 py-0.5 text-[10px] font-bold uppercase rounded-full bg-emerald-100 text-emerald-800 dark:bg-emerald-950/60 dark:text-emerald-300">{{ __('Disponible') }}</span>
                            @endif
                        </div>
                        <p class="text-3xl font-extrabold text-slate-800 dark:text-slate-100 mt-2 font-mono">
                            {{ number_format($product->current_stock) }}
                        </p>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                            {{ __('Mínimo requerido:') }} <span class="font-semibold text-slate-700 dark:text-slate-300">{{ number_format($product->minimum_stock) }}</span>
                        </p>
                    </div>

                    <!-- Precio Venta -->
                    <div class="bg-slate-50/70 dark:bg-slate-900/60 p-5 rounded-2xl border border-slate-200/60 dark:border-slate-700/60">
                        <span class="text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">{{ __('Precio Venta') }}</span>
                        <p class="text-3xl font-extrabold text-emerald-600 dark:text-emerald-400 mt-2 font-mono">
                            ${{ number_format($product->selling_price, 2) }}
                        </p>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">{{ __('Precio para público final') }}</p>
                    </div>

                    <!-- Precio Compra -->
                    <div class="bg-slate-50/70 dark:bg-slate-900/60 p-5 rounded-2xl border border-slate-200/60 dark:border-slate-700/60">
                        <span class="text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">{{ __('Precio Compra') }}</span>
                        <p class="text-3xl font-extrabold text-slate-700 dark:text-slate-200 mt-2 font-mono">
                            ${{ number_format($product->purchase_price, 2) }}
                        </p>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">{{ __('Costo adquisición proveedor') }}</p>
                    </div>

                    <!-- Margen Estimado -->
                    @php
                        $margin = $product->selling_price - $product->purchase_price;
                        $percentage = $product->purchase_price > 0 ? ($margin / $product->purchase_price) * 100 : 0;
                    @endphp
                    <div class="bg-slate-50/70 dark:bg-slate-900/60 p-5 rounded-2xl border border-slate-200/60 dark:border-slate-700/60">
                        <span class="text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">{{ __('Margen de Ganancia') }}</span>
                        <p class="text-3xl font-extrabold text-sky-600 dark:text-sky-400 mt-2 font-mono">
                            ${{ number_format($margin, 2) }}
                        </p>
                        <p class="text-xs text-sky-600 dark:text-sky-400 mt-1 font-semibold">
                            +{{ number_format($percentage, 1) }}% {{ __('retorno') }}
                        </p>
                    </div>
                </div>

                <!-- DETALLES GENERALES Y CLASIFICACIÓN -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    
                    <!-- Información Principal -->
                    <div class="lg:col-span-2 bg-slate-50/50 dark:bg-slate-900/40 rounded-2xl border border-slate-200/60 dark:border-slate-700/60 p-6 space-y-6">
                        <h3 class="text-base font-bold text-slate-800 dark:text-slate-100 border-b pb-3 border-slate-200/60 dark:border-slate-700/60">
                            {{ __('Información General') }}
                        </h3>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <span class="block text-[11px] font-bold text-slate-400 uppercase">{{ __('Nombre del Producto') }}</span>
                                <p class="text-sm font-semibold text-slate-800 dark:text-slate-100 mt-1">{{ $product->name }}</p>
                            </div>

                            <div>
                                <span class="block text-[11px] font-bold text-slate-400 uppercase">{{ __('Código / SKU') }}</span>
                                <p class="text-sm font-mono font-bold text-emerald-600 dark:text-emerald-400 mt-1">#{{ $product->code }}</p>
                            </div>
                        </div>

                        <div>
                            <span class="block text-[11px] font-bold text-slate-400 uppercase mb-1.5">{{ __('Descripción') }}</span>
                            <div class="bg-white dark:bg-slate-800 p-4 rounded-xl border border-slate-200/60 dark:border-slate-700/60 text-xs text-slate-600 dark:text-slate-300 leading-relaxed whitespace-pre-line">
                                {{ $product->description ?? __('Sin descripción asignada.') }}
                            </div>
                        </div>
                    </div>

                    <!-- Categoría y Proveedor -->
                    <div class="bg-slate-50/50 dark:bg-slate-900/40 rounded-2xl border border-slate-200/60 dark:border-slate-700/60 p-6 space-y-6">
                        <h3 class="text-base font-bold text-slate-800 dark:text-slate-100 border-b pb-3 border-slate-200/60 dark:border-slate-700/60">
                            {{ __('Clasificación y Origen') }}
                        </h3>

                        <!-- Categoría -->
                        <div class="flex items-start gap-3">
                            <div class="p-2.5 rounded-xl bg-emerald-100 dark:bg-emerald-950/50 text-emerald-600 dark:text-emerald-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                            </div>
                            <div>
                                <span class="block text-[11px] font-bold text-slate-400 uppercase">{{ __('Categoría') }}</span>
                                <p class="text-sm font-semibold text-slate-800 dark:text-slate-100 mt-0.5">
                                    {{ $product->category->name ?? __('Sin categoría') }}
                                </p>
                            </div>
                        </div>

                        <!-- Proveedor -->
                        <div class="flex items-start gap-3">
                            <div class="p-2.5 rounded-xl bg-sky-100 dark:bg-sky-950/50 text-sky-600 dark:text-sky-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            </div>
                            <div>
                                <span class="block text-[11px] font-bold text-slate-400 uppercase">{{ __('Proveedor') }}</span>
                                <p class="text-sm font-semibold text-slate-800 dark:text-slate-100 mt-0.5">
                                    {{ $product->supplier->name ?? $product->supplier->legal_name ?? __('Sin proveedor') }}
                                </p>
                            </div>
                        </div>

                        <!-- Fechas -->
                        <div class="border-t border-slate-200/60 dark:border-slate-700/60 pt-4 space-y-2 text-xs text-slate-500 dark:text-slate-400">
                            <div class="flex justify-between">
                                <span>{{ __('Registrado:') }}</span>
                                <span class="font-medium text-slate-700 dark:text-slate-300">{{ $product->created_at?->format('d/m/Y H:i') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>{{ __('Última actualización:') }}</span>
                                <span class="font-medium text-slate-700 dark:text-slate-300">{{ $product->updated_at?->format('d/m/Y H:i') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- HISTORIAL DE MOVIMIENTOS -->
                <div class="overflow-x-auto rounded-2xl border border-slate-200/80 dark:border-slate-700/80">
                    <div class="p-5 bg-slate-50/80 dark:bg-slate-900/80 border-b border-slate-200/80 dark:border-slate-700/80 flex justify-between items-center">
                        <h3 class="font-bold text-slate-800 dark:text-slate-100 text-sm">
                            {{ __('Últimos Movimientos de Inventario') }}
                        </h3>
                        <span class="text-xs text-slate-500 font-medium">
                            {{ $product->movements->count() }} {{ __('registros') }}
                        </span>
                    </div>

                    <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700/80 text-left">
                        <thead class="bg-slate-50/50 dark:bg-slate-900/50 text-slate-500 dark:text-slate-400 uppercase tracking-wider text-[11px] font-bold">
                            <tr>
                                <th class="px-6 py-3.5">{{ __('Fecha') }}</th>
                                <th class="px-6 py-3.5">{{ __('Tipo') }}</th>
                                <th class="px-6 py-3.5 text-right">{{ __('Cantidad') }}</th>
                                <th class="px-6 py-3.5">{{ __('Motivo / Observación') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-700/50 text-xs bg-white dark:bg-slate-800">
                            @forelse ($product->movements->take(5) as $movement)
                                <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-700/30 transition-colors">
                                    <td class="px-6 py-4 font-mono">
                                        {{ $movement->created_at?->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @if(in_array(strtolower($movement->type ?? ''), ['entrada', 'in', 'ingreso']))
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold bg-emerald-100 text-emerald-800 dark:bg-emerald-950/60 dark:text-emerald-300">
                                                ↑ {{ __('Entrada') }}
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold bg-rose-100 text-rose-800 dark:bg-rose-950/60 dark:text-rose-300">
                                                ↓ {{ __('Salida') }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 font-mono font-bold text-right text-slate-800 dark:text-slate-100">
                                        {{ $movement->quantity }}
                                    </td>
                                    <td class="px-6 py-4 text-slate-600 dark:text-slate-300">
                                        {{ $movement->concept ?? $movement->observation ?? '—' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-slate-500 dark:text-slate-400 italic">
                                        {{ __('No se registran movimientos recientes de stock para este producto.') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>