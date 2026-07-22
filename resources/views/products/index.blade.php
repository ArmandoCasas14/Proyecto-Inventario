<x-app-layout>
    <!-- CONTENEDOR PRINCIPAL QUE ANULA EL PADDING DEL LAYOUT BASE -->
    <div class="relative min-h-[calc(100vh-4rem)] -m-4 sm:-m-6 lg:-m-8 p-4 sm:p-6 lg:p-8 bg-[#f3f7f6] dark:bg-slate-950 bg-[radial-gradient(#cbd5e1_1px,transparent_1px)] dark:bg-[radial-gradient(#1e293b_1px,transparent_1px)] [background-size:16px_16px] flex justify-center items-start">
        
        <!-- CONTENEDOR CENTRAL UNIFICADO -->
        <div class="w-full max-w-7xl bg-white dark:bg-slate-800 rounded-3xl shadow-xl border border-slate-200/80 dark:border-slate-700/80 overflow-hidden relative z-10 my-4">
            
            <!-- BANNER ENCABEZADO SUPERIOR VERDE -->
            <div class="bg-emerald-600 dark:bg-emerald-700 px-6 py-6 sm:px-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h2 class="font-bold text-2xl text-white tracking-tight">
                        Gestión de Productos
                    </h2>
                    <p class="text-xs text-emerald-100 mt-1">
                        Consulta, filtra y gestiona el catálogo de mercancía y existencias en el sistema
                    </p>
                </div>

                <!-- Botones de Acción Global -->
                <div class="flex items-center gap-3">
                    <a href="{{ route('productos.export-pdf', request()->query()) }}" 
                       class="inline-flex items-center px-4 py-2.5 bg-rose-600 hover:bg-rose-700 active:bg-rose-800 text-white font-semibold text-xs rounded-xl transition-all shadow-sm gap-2 focus:outline-none">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Exportar PDF
                    </a>

                    <a href="{{ route('productos.create') }}"
                       class="inline-flex items-center px-4 py-2.5 bg-emerald-800 hover:bg-emerald-900 text-white font-semibold text-xs rounded-xl transition-all shadow-sm gap-2 focus:outline-none">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        + Crear Nuevo Producto
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

                @if (session('error'))
                    <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 dark:bg-rose-950/30 dark:border-rose-800/50 text-rose-800 dark:text-rose-300 text-sm shadow-sm flex items-center gap-3">
                        <div class="p-1 bg-rose-100 dark:bg-rose-900/50 rounded-lg text-rose-600 dark:text-rose-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                        <span class="font-medium">{{ session('error') }}</span>
                    </div>
                @endif

                <!-- FILTROS Y BÚSQUEDA INTEGRADOS -->
                <div class="bg-slate-50/70 dark:bg-slate-900/60 p-5 rounded-2xl border border-slate-200/60 dark:border-slate-700/60">
                    <form action="{{ route('productos.index') }}" method="GET" class="space-y-4">
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 items-end">
                            
                            <!-- Búsqueda -->
                            <div>
                                <label class="block text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">
                                    Buscar Producto
                                </label>
                                <input type="text" name="search" value="{{ request('search') }}" 
                                       placeholder="Nombre o código..." 
                                       class="w-full text-xs rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm transition-colors py-2.5">
                            </div>

                            <!-- Categoría -->
                            <div>
                                <label for="category_id" class="block text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">
                                    Categoría
                                </label>
                                <select id="category_id" name="category_id" 
                                        class="w-full text-xs rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm transition-colors py-2.5">
                                    <option value="" {{ !request('category_id') ? 'selected' : '' }}>Todas las categorías</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Estado -->
                            <div>
                                <label for="status" class="block text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">
                                    Estado
                                </label>
                                <select id="status" name="status" 
                                        class="w-full text-xs rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm transition-colors py-2.5">
                                    <option value="">Todos los estados</option>
                                    <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Activos</option>
                                    <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Inactivos</option>
                                </select>
                            </div>

                            <!-- Existencias -->
                            <div>
                                <label for="stock" class="block text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">
                                    Existencias
                                </label>
                                <select id="stock" name="stock" 
                                        class="w-full text-xs rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm transition-colors py-2.5">
                                    <option value="" {{ !request('stock') ? 'selected' : '' }}>Cualquier stock</option>
                                    <option value="disponible" {{ request('stock') === 'disponible' ? 'selected' : '' }}>En Stock</option>
                                    <option value="agotado" {{ request('stock') === 'agotado' ? 'selected' : '' }}>Agotados / Mínimo</option>
                                </select>
                            </div>

                        </div>

                        <!-- Botones Buscar / Limpiar -->
                        <div class="flex justify-end gap-2 pt-2 border-t border-slate-200/50 dark:border-slate-700/50">
                            @if(request()->anyFilled(['search', 'category_id', 'status', 'stock']))
                                <a href="{{ route('productos.index') }}" 
                                   class="px-5 py-2.5 bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-200 font-bold text-xs uppercase tracking-wider rounded-xl hover:bg-slate-300 dark:hover:bg-slate-600 transition-colors text-center">
                                    Limpiar
                                </a>
                            @endif
                            <button type="submit" 
                                    class="px-6 py-2.5 bg-slate-800 hover:bg-slate-900 dark:bg-slate-700 dark:hover:bg-slate-600 text-white font-bold text-xs uppercase tracking-wider rounded-xl transition-all shadow-sm">
                                BUSCAR
                            </button>
                        </div>

                    </form>
                </div>

                <!-- TABLA DE RESULTADOS -->
                <div class="overflow-x-auto rounded-2xl border border-slate-200/80 dark:border-slate-700/80">
                    <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700/80 text-left">
                        <thead class="bg-slate-50/80 dark:bg-slate-900/80 text-slate-500 dark:text-slate-400 uppercase tracking-wider text-[11px] font-bold">
                            <tr>
                                <th class="px-6 py-4">{{ __('Código') }}</th>
                                <th class="px-6 py-4">{{ __('Nombre') }}</th>
                                <th class="px-6 py-4">{{ __('Categoría') }}</th>
                                <th class="px-6 py-4">{{ __('Proveedor') }}</th>
                                <th class="px-6 py-4 text-right">{{ __('Precio Venta') }}</th>
                                <th class="px-6 py-4 text-center">{{ __('Stock') }}</th>
                                <th class="px-6 py-4">{{ __('Estado') }}</th>
                                <th class="px-6 py-4 text-right">{{ __('Acciones') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-700/50 text-xs bg-white dark:bg-slate-800">
                            @forelse ($products as $product)
                                <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-700/30 transition-colors">
                                    <td class="px-6 py-4 font-mono font-bold text-emerald-600 dark:text-emerald-400">
                                        #{{ $product->code }}
                                    </td>
                                    <td class="px-6 py-4 font-semibold text-slate-800 dark:text-slate-100">
                                        {{ $product->name }}
                                    </td>
                                    <td class="px-6 py-4 text-slate-600 dark:text-slate-300">
                                        {{ $product->category->name ?? '—' }}
                                    </td>
                                    <td class="px-6 py-4 text-slate-600 dark:text-slate-300">
                                        {{ $product->supplier->legal_name ?? '—' }}
                                    </td>
                                    <td class="px-6 py-4 text-right font-mono font-bold text-slate-800 dark:text-slate-100">
                                        ${{ number_format($product->selling_price, 2) }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if ($product->current_stock <= $product->minimum_stock)
                                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-rose-100 text-rose-800 dark:bg-rose-950/60 dark:text-rose-300" title="{{ __('Stock mínimo: ') . $product->minimum_stock }}">
                                                {{ $product->current_stock }} ⚠
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 dark:bg-emerald-950/60 dark:text-emerald-300">
                                                {{ $product->current_stock }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        @if ($product->status)
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-semibold bg-emerald-100 text-emerald-800 dark:bg-emerald-950/60 dark:text-emerald-300">
                                                {{ __('Activo') }}
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-semibold bg-slate-100 text-slate-600 dark:bg-slate-700/60 dark:text-slate-400">
                                                {{ __('Inactivo') }}
                                            </span>
                                        @endif
                                    </td>

                                    <!-- ACCIONES -->
                                    <td class="px-6 py-4 text-right whitespace-nowrap">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('productos.show', $product) }}"
                                               title="{{ __('Ver Detalle') }}"
                                               class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-sky-100 text-sky-700 hover:bg-sky-500 hover:text-white dark:bg-sky-900/40 dark:text-sky-300 dark:hover:bg-sky-600 dark:hover:text-white transition ease-in-out duration-150 shadow-sm">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>

                                            <a href="{{ route('productos.edit', $product) }}"
                                               title="{{ __('Editar') }}"
                                               class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-amber-100 text-amber-700 hover:bg-amber-500 hover:text-white dark:bg-amber-900/40 dark:text-amber-300 dark:hover:bg-amber-600 dark:hover:text-white transition ease-in-out duration-150 shadow-sm">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>

                                            @if(auth()->user()->role->name === 'Administrador')
                                                <form action="{{ route('productos.toggleStatus', $product) }}" method="POST"
                                                      data-confirm="{{ $product->status ? __('¿Estás seguro de que deseas inactivar este producto?') : __('¿Estás seguro de que deseas activar este producto?') }}">
                                                    @csrf
                                                    @method('PATCH')

                                                    @if($product->status)
                                                        <button type="submit" title="{{ __('Inactivar Producto') }}"
                                                                class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-red-100 text-red-700 hover:bg-red-500 hover:text-white dark:bg-red-900/40 dark:text-red-300 dark:hover:bg-red-600 dark:hover:text-white transition ease-in-out duration-150 shadow-sm">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4" />
                                                            </svg>
                                                        </button>
                                                    @else
                                                        <button type="submit" title="{{ __('Activar Producto') }}"
                                                                class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-green-100 text-green-700 hover:bg-green-500 hover:text-white dark:bg-green-900/40 dark:text-green-300 dark:hover:bg-green-600 dark:hover:text-white transition ease-in-out duration-150 shadow-sm">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                                            </svg>
                                                        </button>
                                                    @endif
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-12 text-center text-slate-500 dark:text-slate-400 italic">
                                        {{ __('No se encontraron productos con los filtros seleccionados.') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($products->hasPages())
                    <div class="pt-2">
                        {{ $products->links() }}
                    </div>
                @endif

            </div>

        </div>
    </div>
</x-app-layout>