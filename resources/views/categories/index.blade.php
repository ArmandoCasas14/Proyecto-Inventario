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

            <!-- 1. BARRA DE BÚSQUEDA POR TEXTO (ANCHO COMPLETO) -->
            <div class="mb-6 bg-white dark:bg-gray-800 p-4 rounded-lg shadow-sm border border-gray-100 dark:border-gray-700">
                <form action="{{ route('categorias.index') }}" method="GET" class="flex flex-col sm:flex-row gap-4 items-end">
                    <div class="flex-1 w-full">
                        <label class="block text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase mb-1">Buscar Categoría</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Nombre o descripción..." class="w-full text-sm rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                    </div>
                    
                    <div class="flex gap-2 w-full sm:w-auto">
                        <button type="submit" class="px-4 py-2 bg-gray-800 dark:bg-gray-200 text-white dark:text-gray-800 font-semibold text-xs uppercase tracking-widest rounded-md hover:bg-gray-700 dark:hover:bg-white transition cursor-pointer">
                            Buscar
                        </button>
                        @if(request()->filled('search'))
                            <a href="{{ route('categorias.index') }}" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 font-semibold text-xs uppercase tracking-widest rounded-md hover:bg-gray-300 dark:hover:bg-gray-600 transition text-center">
                                Limpiar
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- 2. TABLA DE CATEGORÍAS -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 dark:border-gray-700">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-900/40">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Nombre') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Descripción') }}</th>
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
                                    <td class="px-6 py-4 whitespace-nowrap">
                                                @if ($category->status)
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
                                            <a href="{{ route('categorias.edit', $category) }}"
                                               title="{{ __('Editar') }}"
                                               class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-amber-100 text-amber-700 hover:bg-amber-500 hover:text-white dark:bg-amber-900/40 dark:text-amber-300 dark:hover:bg-amber-600 dark:hover:text-white transition ease-in-out duration-150 shadow-sm">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                            <form action="{{ route('categorias.toggleStatus', $category) }}" method="POST"
                                                  onsubmit="return confirm('¿Deseas cambiar el estado de esta categoría?');">
                                                @csrf
                                                @method('PATCH')

                                                @if($category->status)
                                                    <!-- BOTÓN PARA INACTIVAR (- Rojo) -->
                                                    <button type="submit" title="{{ __('Inactivar Categoría') }}"
                                                            class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-red-100 text-red-700 hover:bg-red-500 hover:text-white dark:bg-red-900/40 dark:text-red-300 dark:hover:bg-red-600 dark:hover:text-white transition ease-in-out duration-150 shadow-sm">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4" />
                                                        </svg>
                                                    </button>
                                                @else
                                                    <!-- BOTÓN PARA ACTIVAR (+ Verde) -->
                                                    <button type="submit" title="{{ __('Activar Categoría') }}"
                                                            class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-green-100 text-green-700 hover:bg-green-500 hover:text-white dark:bg-green-900/40 dark:text-green-300 dark:hover:bg-green-600 dark:hover:text-white transition ease-in-out duration-150 shadow-sm">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                                        </svg>
                                                    </button>
                                                @endif
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-10 text-center text-sm text-gray-500 dark:text-gray-400 italic">
                                        {{ __('No se encontraron categorías con el término buscado.') }}
                                    </td>
                                </tr>
                            @endempty
                        </tbody>
                    </table>
                </div>
                
                @if($categories->hasPages())
                    <div class="px-6 py-4 bg-gray-50 dark:bg-gray-900/20 border-t border-gray-200 dark:border-gray-700">
                        {{ $categories->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>