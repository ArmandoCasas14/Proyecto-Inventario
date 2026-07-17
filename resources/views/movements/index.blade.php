<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Kardex / Movimientos de Inventario') }}
            </h2>
            <a href="{{ route('movimientos.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-950 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                + Registrar Entrada/Salida
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <!-- DISTRIBUCIÓN EN GRID DE 4 COLUMNAS -->
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 items-start">
                
                <!-- REJILLA LATERAL IZQUIERDA: FILTROS -->
                <div class="lg:col-span-1">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-100 dark:border-gray-700">
                        <div class="flex justify-between items-center mb-4 pb-2 border-b dark:border-gray-700">
                            <h3 class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Filtrar Historial</h3>
                            @if(request()->anyFilled(['product', 'movement_type_id', 'date', 'user']))
                                <a href="{{ route('movimientos.index') }}" class="text-xs text-red-500 hover:underline font-medium">Limpiar</a>
                            @endif
                        </div>

                        <form action="{{ route('movimientos.index') }}" method="GET" class="space-y-4">
                            <!-- Buscar por Producto -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase mb-1">Producto</label>
                                <input type="text" name="product" value="{{ request('product') }}" placeholder="Nombre o código..." class="w-full text-sm rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                            </div>

                            <!-- Buscar por Tipo de Concepto -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase mb-1">Tipo de Movimiento</label>
                                <select name="movement_type_id" class="w-full text-sm rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                                    <option value="">Todos</option>
                                    @foreach($movementTypes as $type)
                                        <option value="{{ $type->id }}" {{ request('movement_type_id') == $type->id ? 'selected' : '' }}>
                                            {{ $type->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Buscar por Fecha -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase mb-1">Fecha</label>
                                <input type="date" name="date" value="{{ request('date') }}" class="w-full text-sm rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                            </div>

                            <!-- Buscar por Encargado -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase mb-1">Encargado</label>
                                <input type="text" name="user" value="{{ request('user') }}" placeholder="Nombre del usuario..." class="w-full text-sm rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                            </div>

                            <div class="pt-2">
                                <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white transition ease-in-out duration-150 cursor-pointer">
                                    Aplicar Filtros
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- TABLA PRINCIPAL DE MOVIMIENTOS -->
                <div class="lg:col-span-3">
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

            </div> <!-- FIN DEL GRID -->
        </div>
    </div>
</x-app-layout>