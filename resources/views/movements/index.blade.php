<x-app-layout>
    <div class="relative min-h-[calc(100vh-4rem)] -m-4 sm:-m-6 lg:-m-8 p-4 sm:p-6 lg:p-8 bg-[#f3f7f6] dark:bg-slate-950 bg-[radial-gradient(#cbd5e1_1px,transparent_1px)] dark:bg-[radial-gradient(#1e293b_1px,transparent_1px)] [background-size:16px_16px] flex justify-center items-start">
        
        <!-- CONTENEDOR CENTRAL -->
        <div class="w-full max-w-7xl bg-white dark:bg-slate-800 rounded-3xl shadow-xl border border-slate-200/80 dark:border-slate-700/80 overflow-hidden relative z-10 my-4" x-data>
            
            <!-- BANNER ENCABEZADO SUPERIOR VERDE -->
            <div class="bg-emerald-600 dark:bg-emerald-700 px-6 py-6 sm:px-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h2 class="font-bold text-2xl text-white tracking-tight">
                        {{ __('Kardex / Movimientos de Inventario') }}
                    </h2>
                    <p class="text-xs text-emerald-100 mt-1">
                        {{ __('Historial completo de entradas, salidas y ajustes de stock en bodega.') }}
                    </p>
                </div>

                <div class="flex flex-wrap items-center gap-2.5">
                    <a href="{{ route('movimientos.create') }}" 
                       class="inline-flex items-center justify-center px-4 py-2.5 bg-emerald-800 hover:bg-emerald-900 text-white font-semibold text-xs rounded-xl transition-all shadow-sm gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        {{ __('Registrar Movimiento') }}
                    </a>

                    <button type="button" 
                            x-on:click.prevent="$dispatch('open-modal', 'modal-reporte-movimientos')"
                            class="inline-flex items-center justify-center px-4 py-2.5 bg-rose-700 hover:bg-rose-800 text-white font-semibold text-xs rounded-xl transition-all shadow-sm gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        {{ __('Reporte PDF') }}
                    </button>
                </div>
            </div>

            <!-- CUERPO PRINCIPAL -->
            <div class="p-6 sm:p-8 space-y-6">

                <!-- ALERTAS DE SESIÓN -->
                @if(session('success'))
                    <div class="p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800/60 text-emerald-800 dark:text-emerald-300 text-xs font-medium flex items-center gap-2 shadow-sm">
                        <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                <!-- BARRA DE BÚSQUEDA Y FILTROS -->
                <div class="bg-slate-50/70 dark:bg-slate-900/60 p-4 rounded-2xl border border-slate-200/60 dark:border-slate-700/60">
                    <form action="{{ route('movimientos.index') }}" method="GET">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-4 items-end">
                            
                            <!-- Producto -->
                            <div class="lg:col-span-3">
                                <label class="block text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">
                                    {{ __('Producto') }}
                                </label>
                                <input type="text" name="product" value="{{ request('product') }}" placeholder="Nombre o código..." 
                                       class="w-full text-xs rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200 focus:border-emerald-500 focus:ring-emerald-500 py-2.5 shadow-sm">
                            </div>

                            <!-- Encargado -->
                            <div class="lg:col-span-3">
                                <label class="block text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">
                                    {{ __('Encargado') }}
                                </label>
                                <input type="text" name="user" value="{{ request('user') }}" placeholder="Nombre de usuario..." 
                                       class="w-full text-xs rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200 focus:border-emerald-500 focus:ring-emerald-500 py-2.5 shadow-sm">
                            </div>

                            <!-- Tipo de Movimiento -->
                            <div class="lg:col-span-2">
                                <label class="block text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">
                                    {{ __('Tipo Movimiento') }}
                                </label>
                                <select name="movement_type_id" class="w-full text-xs rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200 focus:border-emerald-500 focus:ring-emerald-500 py-2.5 shadow-sm">
                                    <option value="">{{ __('Todos') }}</option>
                                    @foreach($movementTypes as $type)
                                        <option value="{{ $type->id }}" {{ request('movement_type_id') == $type->id ? 'selected' : '' }}>
                                            {{ $type->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Fecha -->
                            <div class="lg:col-span-2">
                                <label class="block text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">
                                    {{ __('Fecha') }}
                                </label>
                                <input type="date" name="date" value="{{ request('date') }}" 
                                       class="w-full text-xs rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200 focus:border-emerald-500 focus:ring-emerald-500 py-2.5 shadow-sm">
                            </div>

                            <!-- Botones -->
                            <div class="lg:col-span-2 flex items-center gap-2">
                                <button type="submit" class="flex-1 h-[38px] bg-slate-800 hover:bg-slate-900 dark:bg-slate-200 dark:hover:bg-white text-white dark:text-slate-900 font-bold text-xs uppercase tracking-wider rounded-xl transition-all shadow-sm flex items-center justify-center">
                                    {{ __('Buscar') }}
                                </button>
                                
                                @if(request()->anyFilled(['product', 'movement_type_id', 'date', 'user']))
                                    <a href="{{ route('movimientos.index') }}" title="{{ __('Limpiar filtros') }}" 
                                       class="h-[38px] px-3 bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-200 font-bold text-xs uppercase rounded-xl hover:bg-slate-300 dark:hover:bg-slate-600 transition-colors flex items-center justify-center">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </a>
                                @endif
                            </div>

                        </div>
                    </form>
                </div>

                <!-- TABLA DE MOVIMIENTOS -->
                <div class="overflow-x-auto rounded-2xl border border-slate-200/80 dark:border-slate-700/80">
                    <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700/80 text-left">
                        <thead class="bg-slate-50/80 dark:bg-slate-900/80 text-slate-500 dark:text-slate-400 uppercase tracking-wider text-[11px] font-bold">
                            <tr>
                                <th class="px-6 py-3.5">{{ __('Fecha') }}</th>
                                <th class="px-6 py-3.5">{{ __('Producto') }}</th>
                                <th class="px-6 py-3.5">{{ __('Tipo') }}</th>
                                <th class="px-6 py-3.5">{{ __('Cantidad') }}</th>
                                <th class="px-6 py-3.5">{{ __('Precio Ref.') }}</th>
                                <th class="px-6 py-3.5">{{ __('Encargado') }}</th>
                                <th class="px-6 py-3.5">{{ __('Observación') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-700/50 text-xs bg-white dark:bg-slate-800">
                            @forelse($movements as $movement)
                                <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-700/30 transition-colors">
                                    <td class="px-6 py-4 font-mono text-slate-500 dark:text-slate-400 whitespace-nowrap">
                                        {{ $movement->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 font-semibold text-slate-800 dark:text-slate-100">
                                        {{ $movement->product->name ?? __('Producto Eliminado') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if(($movement->movementType->type ?? '') === 'suma')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold bg-emerald-100 text-emerald-800 dark:bg-emerald-950/60 dark:text-emerald-300">
                                                <span class="w-1.5 h-1.5 mr-1.5 rounded-full bg-emerald-500"></span>
                                                {{ $movement->movementType->name ?? 'N/A' }}
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold bg-rose-100 text-rose-800 dark:bg-rose-950/60 dark:text-rose-300">
                                                <span class="w-1.5 h-1.5 mr-1.5 rounded-full bg-rose-500"></span>
                                                {{ $movement->movementType->name ?? 'N/A' }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 font-bold text-slate-800 dark:text-slate-200 whitespace-nowrap">
                                        {{ $movement->quantity }} u.
                                    </td>
                                    <td class="px-6 py-4 text-slate-600 dark:text-slate-300 whitespace-nowrap">
                                        ${{ number_format($movement->unit_price, 2) }}
                                    </td>
                                    <td class="px-6 py-4 text-slate-600 dark:text-slate-300 whitespace-nowrap">
                                        {{ $movement->user->name ?? __('Sistema') }}
                                    </td>
                                    <td class="px-6 py-4 text-slate-500 dark:text-slate-400 max-w-xs truncate" title="{{ $movement->observation }}">
                                        {{ $movement->observation ?? '—' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-10 text-center text-slate-500 dark:text-slate-400 italic">
                                        {{ __('No se encontraron registros de movimientos con los filtros aplicados.') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($movements->hasPages())
                    <div class="pt-2">
                        {{ $movements->links() }}
                    </div>
                @endif
            </div>

            <!-- MODAL DE GENERACIÓN DE REPORTE PDF -->
            <x-modal name="modal-reporte-movimientos" focusable>
                <form action="{{ route('movimientos.export-pdf') }}" method="GET" class="p-6 sm:p-8" target="_blank">
                    <div class="border-b border-slate-200/80 dark:border-slate-700/80 pb-4 mb-6">
                        <h3 class="text-xl font-bold text-slate-800 dark:text-slate-100">
                            {{ __('Generar Reporte PDF de Movimientos') }}
                        </h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                            {{ __('Selecciona los filtros para estructurar el reporte de auditoría.') }}
                        </p>
                    </div>

                    <div class="space-y-5">
                        <div>
                            <label for="modal_movement_type_id" class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">
                                {{ __('Tipo de Movimiento') }}
                            </label>
                            <select id="modal_movement_type_id" name="movement_type_id" required 
                                    class="w-full text-xs rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200 focus:border-emerald-500 focus:ring-emerald-500 py-2.5 shadow-sm">
                                <option value="todos">{{ __('Todos los movimientos') }}</option>
                                @foreach($movementTypes as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="date_from" class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">
                                    {{ __('Desde') }}
                                </label>
                                <input type="date" id="date_from" name="date_from" value="{{ date('Y-m-01') }}" required 
                                       class="w-full text-xs rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200 focus:border-emerald-500 focus:ring-emerald-500 py-2.5 shadow-sm">
                            </div>

                            <div>
                                <label for="date_to" class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">
                                    {{ __('Hasta') }}
                                </label>
                                <input type="date" id="date_to" name="date_to" value="{{ date('Y-m-d') }}" required 
                                       class="w-full text-xs rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200 focus:border-emerald-500 focus:ring-emerald-500 py-2.5 shadow-sm">
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end gap-3 pt-4 border-t border-slate-200/80 dark:border-slate-700/80">
                        <button type="button" x-on:click="$dispatch('close')" 
                                class="px-5 py-2.5 bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-200 font-bold text-xs uppercase tracking-wider rounded-xl hover:bg-slate-300 dark:hover:bg-slate-600 transition-colors">
                            {{ __('Cancelar') }}
                        </button>

                        <button type="submit" class="px-6 py-2.5 bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs uppercase tracking-wider rounded-xl transition-all shadow-sm">
                            {{ __('Descargar PDF') }}
                        </button>
                    </div>
                </form>
            </x-modal>

        </div>
    </div>
</x-app-layout>