<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Categorías') }}
            </h2>
            <a href="{{ route('categorias.create') }}"
               class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-800 transition ease-in-out duration-150">
                + {{ __('Nueva Categoría') }}
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-4 rounded-md bg-green-50 dark:bg-green-900/30 text-green-700 dark:text-green-300 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 p-4 rounded-md bg-red-50 dark:bg-red-900/30 text-red-700 dark:text-red-300 text-sm">
                    {{ session('error') }}
                </div>
            @endif

            <!-- CONTENEDOR DE LA REJILLA PRINCIPAL -->
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 items-start">
                
                <!-- COLUMNA BANNER LATERAL: BUSCADOR (1 de 4) -->
                <div class="lg:col-span-1">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-100 dark:border-gray-700">
                        <div class="flex justify-between items-center mb-4 pb-2 border-b dark:border-gray-700">
                            <h3 class="text-sm font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Filtrar</h3>
                            @if(request()->filled('search'))
                                <a href="{{ route('categorias.index') }}" class="text-xs text-red-500 hover:underline font-medium">Limpiar</a>
                            @endif
                        </div>

                        <!-- Formulario de Consulta Directa por HTML -->
                        <form action="{{ route('categorias.index') }}" method="GET" class="space-y-4">
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase mb-2">Nombre de Categoría</label>
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar categoría..." class="w-full text-sm rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                            </div>

                            <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white active:bg-gray-900 transition ease-in-out duration-150 shadow-sm cursor-pointer">
                                Buscar
                            </button>
                        </form>
                    </div>
                </div>

                <!-- COLUMNA PRINCIPAL: LISTADO Y DATOS DETALLADOS (3 de 4) -->
                <div class="lg:col-span-3">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 dark:border-gray-700">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-900/40">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Nombre') }}</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Descripción') }}</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Productos') }}</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Estado') }}</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Acciones') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                    @forelse ($categories as $category)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/40">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                                {{ $category->name }}
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400 max-w-xs truncate">
                                                {{ $category->description ?? '—' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                <span class="px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded text-xs font-mono">
                                                    {{ $category->products_count ?? $category->products()->count() }}
                                                </span>
                                            </td>
                                            <!-- Columna de Estado Añadida por Requerimiento -->
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                @if($category->status ?? true)
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300">
                                                        Activo
                                                    </span>
                                                @else
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300">
                                                        Inactivo
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                                <div class="flex items-center justify-end gap-2">
                                                    <a href="{{ route('categorias.edit', $category) }}"
                                                       title="{{ __('Editar') }}"
                                                       class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-amber-100 text-amber-700 hover:bg-amber-500 hover:text-white dark:bg-amber-900/40 dark:text-amber-300 dark:hover:bg-amber-600 dark:hover:text-white transition ease-in-out duration-150 shadow-sm">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                        </svg>
                                                    </a>
                                                    <form action="{{ route('categorias.destroy', $category) }}" method="POST"
                                                          onsubmit="return confirm('¿Seguro que deseas eliminar esta categoría?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" title="{{ __('Eliminar') }}"
                                                                class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-red-100 text-red-700 hover:bg-red-500 hover:text-white dark:bg-red-900/40 dark:text-red-300 dark:hover:bg-red-600 dark:hover:text-white transition ease-in-out duration-150 shadow-sm">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-6 py-10 text-center text-sm text-gray-500 dark:text-gray-400 italic">
                                                {{ __('No se encontraron categorías con los criterios de búsqueda.') }}
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Paginación Acoplada al contenedor -->
                        @if($categories->hasPages())
                            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-900/20 border-t border-gray-200 dark:border-gray-700">
                                {{ $categories->links() }}
                            </div>
                        @endif
                    </div>
                </div>

            </div> <!-- FIN DEL GRID PRINCIPAL -->
        </div>
    </div>
</x-app-layout>