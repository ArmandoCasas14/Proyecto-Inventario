<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Productos') }}
            </h2>
            <a href="{{ route('productos.create') }}"
               class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-800 transition ease-in-out duration-150">
                + {{ __('Nuevo Producto') }}
            </a>
            <a href="{{ route('productos.export-pdf', request()->query()) }}" class="btn btn-danger">Exportar PDF</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            
            @if (session('success'))
                <div class="mb-6 p-4 rounded-md bg-green-50 dark:bg-green-900/30 text-green-700 dark:text-green-300 text-sm shadow-sm">
                    {{ session('success') }}
                </div>
            @endif
             @if (session('error'))
            <div class="mb-4 p-4 rounded-md bg-red-50 dark:bg-red-900/30 text-red-700 dark:text-red-300 text-sm border border-red-200 dark:border-red-800/50">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            </div>
            @endif

            <!-- REJILLA PRINCIPAL -->
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 items-start">
                
                <!-- ====================================================
                    COLUMNA IZQUIERDA: PANEL LATERAL DE FILTROS (1 de 4)
                ===================================================== -->
                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-100 dark:border-gray-700">
                        <div class="flex justify-between items-center mb-4 pb-2 border-b dark:border-gray-700">
                            <h3 class="text-sm font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Filtros</h3>
                        </div>

                        <form action="{{ route('productos.index') }}" method="GET" class="space-y-6">
                            <!-- Conservar la palabra buscada al aplicar categorías/existencias -->
                            @if(request('search')) <input type="hidden" name="search" value="{{ request('search') }}"> @endif
                            
                            <!-- Filtro por Categorías -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase mb-2">Categorías</label>
                                <div class="space-y-2 max-h-64 overflow-y-auto pr-2">
                                    <label class="flex items-center text-sm cursor-pointer">
                                        <input type="radio" name="category_id" value="" {{ !request('category_id') ? 'checked' : '' }} class="text-indigo-600 focus:ring-indigo-500 dark:bg-gray-900 dark:border-gray-700">
                                        <span class="ms-2 text-gray-700 dark:text-gray-300 font-medium">Todas</span>
                                    </label>
                                    @foreach($categories as $category)
                                        <label class="flex items-center text-sm cursor-pointer">
                                            <input type="radio" name="category_id" value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'checked' : '' }} class="text-indigo-600 focus:ring-indigo-500 dark:bg-gray-900 dark:border-gray-700">
                                            <span class="ms-2 text-gray-600 dark:text-gray-400">{{ $category->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Filtro por Disponibilidad de Stock -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase mb-2">Existencias</label>
                                <div class="space-y-2">
                                    <label class="flex items-center text-sm cursor-pointer">
                                        <input type="radio" name="stock" value="" {{ !request('stock') ? 'checked' : '' }} class="text-indigo-600 focus:ring-indigo-500 dark:bg-gray-900 dark:border-gray-700">
                                        <span class="ms-2 text-gray-600 dark:text-gray-400">Cualquiera</span>
                                    </label>
                                    <label class="flex items-center text-sm cursor-pointer">
                                        <input type="radio" name="stock" value="disponible" {{ request('stock') === 'disponible' ? 'checked' : '' }} class="text-indigo-600 focus:ring-indigo-500 dark:bg-gray-900 dark:border-gray-700">
                                        <span class="ms-2 text-gray-600 dark:text-gray-400 text-green-600 dark:text-green-400 font-medium">En Stock</span>
                                    </label>
                                    <label class="flex items-center text-sm cursor-pointer">
                                        <input type="radio" name="stock" value="agotado" {{ request('stock') === 'agotado' ? 'checked' : '' }} class="text-indigo-600 focus:ring-indigo-500 dark:bg-gray-900 dark:border-gray-700">
                                        <span class="ms-2 text-gray-600 dark:text-gray-400 text-red-600 dark:text-red-400 font-medium">Agotados</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Botón de Envío de Filtros -->
                            <div class="pt-2">
                                <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2.5 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-800 focus:outline-none transition ease-in-out duration-150 shadow-sm cursor-pointer">
                                    Aplicar Filtro
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- ====================================================
                    COLUMNA DERECHA: BUSCADOR + TABLA APILADOS (3 de 4)
                ===================================================== -->
                <div class="lg:col-span-4 space-y-6">
                    
                    <!-- BARRA DE BÚSQUEDA (Justo encima de la tabla) -->
                    <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-sm border border-gray-100 dark:border-gray-700">
                        <form action="{{ route('productos.index') }}" method="GET" class="flex flex-col sm:flex-row gap-4 items-end">
                            <!-- Conservar filtros laterales al buscar por texto -->
                            @if(request('category_id')) <input type="hidden" name="category_id" value="{{ request('category_id') }}"> @endif
                            @if(request('stock')) <input type="hidden" name="stock" value="{{ request('stock') }}"> @endif

                            <div class="flex-1 w-full">
                                <label class="block text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase mb-1">Buscar Producto</label>
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Nombre o código..." class="w-full text-sm rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                            </div>
                            <div class="w-full sm:w-48">
                                <label class="block text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase mb-1">Filtrar por Estado</label>
                                <select name="status" class="w-full text-sm rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                                    <option value="">Todos</option>
                                    <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Activos</option>
                                    <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Inactivos</option>
                                </select>
                            </div>
                            
                            <div class="flex gap-2 w-full sm:w-auto">
                                <button type="submit" class="px-4 py-2 bg-gray-800 dark:bg-gray-200 text-white dark:text-gray-800 font-semibold text-xs uppercase tracking-widest rounded-md hover:bg-gray-700 dark:hover:bg-white transition cursor-pointer">
                                    Buscar
                                </button>
                                @if(request()->anyFilled(['search', 'category_id', 'stock']))
                                    <a href="{{ route('productos.index') }}" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 font-semibold text-xs uppercase tracking-widest rounded-md hover:bg-gray-300 dark:hover:bg-gray-600 transition text-center">
                                        Limpiar
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>

                    <!-- TABLA DE RESULTADOS -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 dark:border-gray-700">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-900/40">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Código') }}</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Nombre') }}</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Categoría') }}</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Proveedor') }}</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Precio Venta') }}</th>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Stock') }}</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Estado') }}</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Acciones') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                    @forelse ($products as $product)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/40">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 font-mono">
                                                {{ $product->code }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                                {{ $product->name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                {{ $product->category->name ?? '—' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                {{ $product->supplier->legal_name ?? '—' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300 text-right font-mono">
                                                ${{ number_format($product->selling_price, 2) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                @if ($product->current_stock <= $product->minimum_stock)
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900/40 dark:text-red-300"
                                                          title="{{ __('Stock mínimo: ') . $product->minimum_stock }}">
                                                        {{ $product->current_stock }} ⚠
                                                    </span>
                                                @else
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-300">
                                                        {{ $product->current_stock }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if ($product->status)
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-300">
                                                        {{ __('Activo') }}
                                                    </span>
                                                @else
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300">
                                                        {{ __('Inactivo') }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                                <div class="flex items-center justify-end gap-2">
                                                    <a href="{{ route('productos.edit', $product) }}"
                                                       title="{{ __('Editar') }}"
                                                       class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-amber-100 text-amber-700 hover:bg-amber-500 hover:text-white dark:bg-amber-900/40 dark:text-amber-300 dark:hover:bg-amber-600 dark:hover:text-white transition ease-in-out duration-150 shadow-sm">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                        </svg>
                                                    </a>
                                                    @if(auth()->user()->role->name === 'Administrador')
                                                    <form action="{{ route('productos.toggleStatus', $product) }}" method="POST"
                                                  onsubmit="return confirm('¿Deseas cambiar el estado de este producto?');">
                                                @csrf
                                                @method('PATCH')

                                                @if($product->status)
                                                    <!-- BOTÓN PARA INACTIVAR (- Rojo) -->
                                                    <button type="submit" title="{{ __('Inactivar Producto') }}"
                                                            class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-red-100 text-red-700 hover:bg-red-500 hover:text-white dark:bg-red-900/40 dark:text-red-300 dark:hover:bg-red-600 dark:hover:text-white transition ease-in-out duration-150 shadow-sm">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4" />
                                                        </svg>
                                                    </button>
                                                @else
                                                    <!-- BOTÓN PARA ACTIVAR (+ Verde) -->
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
                                            <td colspan="8" class="px-6 py-10 text-center text-sm text-gray-500 dark:text-gray-400 italic">
                                                {{ __('No se encontraron productos con los filtros seleccionados.') }}
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        
                        @if($products->hasPages())
                            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-900/20 border-t border-gray-200 dark:border-gray-700">
                                {{ $products->links() }}
                            </div>
                        @endif
                    </div>

                </div> <!-- FIN COLUMNA DERECHA -->

            </div> <!-- FIN GRID PRINCIPAL -->
        </div>
    </div>
</x-app-layout>