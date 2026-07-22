<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
            <!-- Título principal -->
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Kardex / Movimientos de Inventario') }}
            </h2>

            <!-- Botonera superior alineada -->
            <div class="flex items-center gap-3">
                <!-- 1. Botón Exportar Reporte PDF (Modal Trigger) -->
                <button type="button" 
                        x-data="" 
                        x-on:click.prevent="$dispatch('open-modal', 'modal-reporte-movimientos')"
                        class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Generar Reporte PDF
                </button>

                <!-- 2. Botón Registrar Entrada/Salida -->
                <a href="{{ route('movimientos.create') }}" 
                   class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-950 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                    + Registrar Entrada/Salida
                </a>
            </div>
        </div>

        <!-- Modal de Selección de Parámetros -->
        <x-modal name="modal-reporte-movimientos" focusable>
            <form action="{{ route('movimientos.export-pdf') }}" method="GET" class="p-6" target="_blank">
                
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                    Generar Reporte de Movimientos
                </h2>

                <div class="space-y-4">
                    <!-- 1. Tipo de Movimiento -->
                    <div>
                        <label for="movement_type_id" class="block text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase mb-1">
                            Tipo de Movimiento
                        </label>
                        <select id="movement_type_id" 
                                name="movement_type_id" 
                                required 
                                class="w-full text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm focus:ring-indigo-500">
                            
                            <option value="todos">Todos los movimientos</option>
                            
                            @foreach($movementTypes as $type)
                                <option value="{{ $type->id }}">
                                    {{ $type->name }}
                                </option>
                            @endforeach
                            
                        </select>
                    </div>

                    <!-- 2. Rango de Fechas -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="date_from" class="block text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase mb-1">
                                Desde
                            </label>
                            <input type="date" id="date_from" name="date_from" value="{{ date('Y-m-01') }}" required class="w-full text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                        </div>

                        <div>
                            <label for="date_to" class="block text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase mb-1">
                                Hasta
                            </label>
                            <input type="date" id="date_to" name="date_to" value="{{ date('Y-m-d') }}" required class="w-full text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <x-secondary-button x-on:click="$dispatch('close')">
                        Cancelar
                    </x-secondary-button>

                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition">
                        Descargar PDF
                    </button>
                </div>
            </form>
        </x-modal>
    </x-slot>

    <div class="py-12">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <!-- PANEL DE BÚSQUEDA REDISEÑADO -->
            <div class="mb-6 bg-white dark:bg-gray-800 p-4 rounded-lg shadow-sm border border-gray-100 dark:border-gray-700">
                <form action="{{ route('movimientos.index') }}" method="GET">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-4 items-end">
                        
                        <!-- Campo 1: Producto (Buscador por texto) -->
                        <div class="lg:col-span-3">
                            <label class="block text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase mb-1">Producto</label>
                            <input type="text" name="product" value="{{ request('product') }}" placeholder="Nombre o código..." class="w-full text-sm rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                        </div>

                        <!-- Campo 2: Encargado (Buscador por texto - Colocado junto a Producto) -->
                        <div class="lg:col-span-3">
                            <label class="block text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase mb-1">Encargado</label>
                            <input type="text" name="user" value="{{ request('user') }}" placeholder="Nombre del usuario..." class="w-full text-sm rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                        </div>

                        <!-- Campo 3: Tipo de Movimiento -->
                        <div class="lg:col-span-2">
                            <label class="block text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase mb-1">Tipo Movimiento</label>
                            <select name="movement_type_id" class="w-full text-sm rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                                <option value="">Todos</option>
                                @foreach($movementTypes as $type)
                                    <option value="{{ $type->id }}" {{ request('movement_type_id') == $type->id ? 'selected' : '' }}>
                                        {{ $type->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Campo 4: Fecha -->
                        <div class="lg:col-span-2">
                            <label class="block text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase mb-1">Fecha</label>
                            <input type="date" name="date" value="{{ request('date') }}" class="w-full text-sm rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                        </div>

                        <!-- Botonera de Acción Alineada Horizontalmente -->
                        <div class="lg:col-span-2 flex items-center gap-2">
                            <button type="submit" class="w-full h-[38px] bg-gray-800 dark:bg-gray-200 text-white dark:text-gray-800 font-semibold text-xs uppercase tracking-widest rounded-md hover:bg-gray-700 dark:hover:bg-white transition cursor-pointer flex items-center justify-center">
                                Buscar
                            </button>
                            
                            @if(request()->anyFilled(['product', 'movement_type_id', 'date', 'user']))
                                <a href="{{ route('movimientos.index') }}" title="Limpiar filtros" class="h-[38px] px-3 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 font-semibold text-xs uppercase rounded-md hover:bg-gray-300 dark:hover:bg-gray-600 transition flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </a>
                            @endif
                        </div>

                    </div>
                </form>
            </div>

            <!-- TABLA PRINCIPAL DE MOVIMIENTOS -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Fecha</th>
                                    <th scope="col" class="px-6 py-3">Producto</th>
                                    <th scope="col" class="px-6 py-3">Tipo</th>
                                    <th scope="col" class="px-6 py-3">Cantidad</th>
                                    <th scope="col" class="px-6 py-3">Precio Ref.</th>
                                    <th scope="col" class="px-6 py-3">Encargado</th>
                                    <th scope="col" class="px-6 py-3">Observación</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($movements as $movement)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $movement->created_at->format('d/m/Y H:i') }}</td>
                                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                            {{ $movement->product->name ?? 'Producto Eliminado' }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                                {{ ($movement->movementType->type ?? '') === 'suma' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $movement->movementType->name ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 font-semibold">{{ $movement->quantity }} u.</td>
                                        <td class="px-6 py-4">${{ number_format($movement->unit_price, 2) }}</td>
                                        <td class="px-6 py-4">{{ $movement->user->name ?? 'Sistema' }}</td>
                                        <td class="px-6 py-4 text-xs max-w-xs truncate" title="{{ $movement->observation }}">{{ $movement->observation }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-10 text-center text-gray-500 italic">
                                            No se encontraron registros de movimientos con los filtros aplicados.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        {{ $movements->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>