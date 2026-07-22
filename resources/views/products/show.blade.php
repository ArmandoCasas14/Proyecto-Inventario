<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <div class="flex items-center gap-3">
                    <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-100 leading-tight">
                        {{ $product->name }}
                    </h2>
                    <!-- Badge de Estado Activo/Inactivo -->
                    @if ($product->status)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 dark:bg-emerald-950/80 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800">
                            <span class="w-1.5 h-1.5 mr-1.5 rounded-full bg-emerald-500"></span> {{ __('Activo') }}
                        </span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400 border border-gray-200 dark:border-gray-700">
                            <span class="w-1.5 h-1.5 mr-1.5 rounded-full bg-gray-400"></span> {{ __('Inactivo') }}
                        </span>
                    @endif
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 font-mono">
                    {{ __('Código SKU/Ref:') }} <span class="font-semibold text-gray-700 dark:text-gray-300">{{ $product->code }}</span>
                </p>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('productos.edit', $product) }}" 
                   class="inline-flex items-center px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white font-medium text-xs rounded-lg transition shadow-sm">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    {{ __('Editar') }}
                </a>
                <a href="{{ route('productos.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 font-medium text-xs rounded-lg transition shadow-sm">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    {{ __('Volver') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- TARJETAS METRICAS CLAVE -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Stock Actual -->
                <div class="bg-white dark:bg-gray-800 p-5 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">{{ __('Stock Actual') }}</span>
                        @if ($product->current_stock <= 0)
                            <span class="px-2 py-0.5 text-[10px] font-bold uppercase rounded bg-rose-100 text-rose-700 dark:bg-rose-900/40 dark:text-rose-300">{{ __('Agotado') }}</span>
                        @elseif($product->current_stock <= $product->minimum_stock)
                            <span class="px-2 py-0.5 text-[10px] font-bold uppercase rounded bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-300">{{ __('Bajo Stock') }}</span>
                        @else
                            <span class="px-2 py-0.5 text-[10px] font-bold uppercase rounded bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300">{{ __('Disponible') }}</span>
                        @endif
                    </div>
                    <p class="text-3xl font-extrabold text-gray-900 dark:text-white mt-2 font-mono">
                        {{ number_format($product->current_stock) }}
                    </p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                        {{ __('Mínimo requerido:') }} <span class="font-semibold">{{ number_format($product->minimum_stock) }}</span>
                    </p>
                </div>

                <!-- Precio Venta -->
                <div class="bg-white dark:bg-gray-800 p-5 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm">
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">{{ __('Precio Venta') }}</span>
                    <p class="text-3xl font-extrabold text-indigo-600 dark:text-indigo-400 mt-2 font-mono">
                        ${{ number_format($product->selling_price, 2) }}
                    </p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ __('Precio para público final') }}</p>
                </div>

                <!-- Precio Compra -->
                <div class="bg-white dark:bg-gray-800 p-5 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm">
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">{{ __('Precio Compra') }}</span>
                    <p class="text-3xl font-extrabold text-gray-700 dark:text-gray-200 mt-2 font-mono">
                        ${{ number_format($product->purchase_price, 2) }}
                    </p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ __('Costo adquisición proveedor') }}</p>
                </div>

                <!-- Margen Estimado -->
                @php
                    $margin = $product->selling_price - $product->purchase_price;
                    $percentage = $product->purchase_price > 0 ? ($margin / $product->purchase_price) * 100 : 0;
                @endphp
                <div class="bg-white dark:bg-gray-800 p-5 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm">
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">{{ __('Margen de Ganancia') }}</span>
                    <p class="text-3xl font-extrabold text-emerald-600 dark:text-emerald-400 mt-2 font-mono">
                        ${{ number_format($margin, 2) }}
                    </p>
                    <p class="text-xs text-emerald-600 dark:text-emerald-400 mt-1 font-semibold">
                        +{{ number_format($percentage, 1) }}% {{ __('retorno') }}
                    </p>
                </div>
            </div>

            <!-- DETALLES GENERALES Y CLASIFICACIÓN -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Columna Izquierda: Información Principal -->
                <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm p-6 space-y-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white border-b pb-3 border-gray-100 dark:border-gray-700">
                        {{ __('Información General') }}
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <span class="block text-xs font-medium text-gray-400 uppercase">{{ __('Nombre del Producto') }}</span>
                            <p class="text-sm font-semibold text-gray-800 dark:text-gray-200 mt-1">{{ $product->name }}</p>
                        </div>

                        <div>
                            <span class="block text-xs font-medium text-gray-400 uppercase">{{ __('Código / SKU') }}</span>
                            <p class="text-sm font-mono font-semibold text-gray-800 dark:text-gray-200 mt-1">{{ $product->code }}</p>
                        </div>
                    </div>

                    <div>
                        <span class="block text-xs font-medium text-gray-400 uppercase mb-1">{{ __('Descripción') }}</span>
                        <div class="bg-gray-50 dark:bg-gray-900/50 p-4 rounded-lg border border-gray-100 dark:border-gray-800 text-sm text-gray-600 dark:text-gray-300 leading-relaxed whitespace-pre-line">
                            {{ $product->description ?? __('Sin descripción asignada.') }}
                        </div>
                    </div>
                </div>

                <!-- Columna Derecha: Categoría & Proveedor -->
                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm p-6 space-y-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white border-b pb-3 border-gray-100 dark:border-gray-700">
                        {{ __('Clasificación y Origen') }}
                    </h3>

                    <!-- Categoría -->
                    <div class="flex items-start gap-3">
                        <div class="p-2.5 rounded-lg bg-indigo-50 dark:bg-indigo-950/50 text-indigo-600 dark:text-indigo-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                        </div>
                        <div>
                            <span class="block text-xs font-medium text-gray-400 uppercase">{{ __('Categoría') }}</span>
                            <p class="text-sm font-semibold text-gray-800 dark:text-gray-200 mt-0.5">
                                {{ $product->category->name ?? __('Sin categoría') }}
                            </p>
                        </div>
                    </div>

                    <!-- Proveedor -->
                    <div class="flex items-start gap-3">
                        <div class="p-2.5 rounded-lg bg-emerald-50 dark:bg-emerald-950/50 text-emerald-600 dark:text-emerald-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        </div>
                        <div>
                            <span class="block text-xs font-medium text-gray-400 uppercase">{{ __('Proveedor') }}</span>
                            <p class="text-sm font-semibold text-gray-800 dark:text-gray-200 mt-0.5">
                                {{ $product->supplier->name ?? $product->supplier->legal_name ?? __('Sin proveedor') }}
                            </p>
                        </div>
                    </div>

                    <!-- Fechas del registro -->
                    <div class="border-t dark:border-gray-700 pt-4 space-y-2 text-xs text-gray-500 dark:text-gray-400">
                        <div class="flex justify-between">
                            <span>{{ __('Registrado:') }}</span>
                            <span class="font-medium text-gray-700 dark:text-gray-300">{{ $product->created_at?->format('d/m/Y H:i') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>{{ __('Última actualización:') }}</span>
                            <span class="font-medium text-gray-700 dark:text-gray-300">{{ $product->updated_at?->format('d/m/Y H:i') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TABLA DE HISTORIAL DE MOVIMIENTOS (Relación $product->movements) -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                        {{ __('Últimos Movimientos de Inventario') }}
                    </h3>
                    <span class="text-xs text-gray-400 font-medium">
                        {{ $product->movements->count() }} {{ __('registros') }}
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
                        <thead class="bg-gray-50 dark:bg-gray-900/50 text-xs text-gray-400 uppercase tracking-wider border-b border-gray-100 dark:border-gray-800">
                            <tr>
                                <th class="px-6 py-3 font-semibold">{{ __('Fecha') }}</th>
                                <th class="px-6 py-3 font-semibold">{{ __('Tipo') }}</th>
                                <th class="px-6 py-3 font-semibold text-right">{{ __('Cantidad') }}</th>
                                <th class="px-6 py-3 font-semibold">{{ __('Motivo / Observación') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                            @forelse ($product->movements->take(5) as $movement)
                                <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700/30 transition">
                                    <td class="px-6 py-4 font-mono text-xs whitespace-nowrap">
                                        {{ $movement->created_at?->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if(in_array(strtolower($movement->type ?? ''), ['entrada', 'in', 'ingreso']))
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-emerald-100 text-emerald-800 dark:bg-emerald-900/40 dark:text-emerald-300">
                                                ↑ {{ __('Entrada') }}
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-rose-100 text-rose-800 dark:bg-rose-900/40 dark:text-rose-300">
                                                ↓ {{ __('Salida') }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 font-mono font-bold text-right text-gray-900 dark:text-white">
                                        {{ $movement->quantity }}
                                    </td>
                                    <td class="px-6 py-4 text-xs text-gray-600 dark:text-gray-300">
                                        {{ $movement->concept ?? $movement->observation ?? '—' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-6 text-center text-xs text-gray-400">
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