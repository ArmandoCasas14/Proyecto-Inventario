<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Proveedores') }}
            </h2>
            <a href="{{ route('suppliers.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __('+ Registrar Proveedor') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if (session('success'))
                <div class="mb-6 p-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                    <span class="font-semibold">¡Éxito!</span> {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 overflow-x-auto">
                    
                    @if($suppliers->isEmpty())
                        <div class="text-center py-8">
                            <p class="text-gray-500 dark:text-gray-400 text-lg">{{ __('No hay proveedores registrados en el sistema.') }}</p>
                        </div>
                    @else
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm text-left">
                            <thead class="bg-gray-50 dark:bg-gray-700 text-xs uppercase text-gray-700 dark:text-gray-300">
                                <tr>
                                    <th scope="col" class="px-6 py-3">{{ __('Razón Social') }}</th>
                                    <th scope="col" class="px-6 py-3">{{ __('NIT') }}</th>
                                    <th scope="col" class="px-6 py-3">{{ __('Teléfono') }}</th>
                                    <th scope="col" class="px-6 py-3">{{ __('Email') }}</th>
                                    <th scope="col" class="px-6 py-3">{{ __('Dirección') }}</th>
                                    <th scope="col" class="px-6 py-3 text-center">{{ __('Estado') }}</th>
                                    <th scope="col" class="px-6 py-3 text-center">{{ __('Acciones') }}</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach ($suppliers as $supplier)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                        <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                                            {{ $supplier->legal_name }}
                                        </td>
                                        <td class="px-6 py-4 font-mono">{{ $supplier->nit }}</td>
                                        <td class="px-6 py-4">{{ $supplier->phone ?? '—' }}</td>
                                        <td class="px-6 py-4">{{ $supplier->email ?? '—' }}</td>
                                        <td class="px-6 py-4 truncate max-w-xs">{{ $supplier->address ?? '—' }}</td>
                                        <td class="px-6 py-4 text-center">
                                            @if ($supplier->status)
                                                <span class="px-2.5 py-1 text-xs font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700/20 dark:text-green-400">
                                                    {{ __('Activo') }}
                                                </span>
                                            @else
                                                <span class="px-2.5 py-1 text-xs font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:bg-red-700/20 dark:text-red-400">
                                                    {{ __('Inactivo') }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-center space-x-2 whitespace-nowrap">
                                            <a href="{{ route('suppliers.edit', $supplier) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 font-semibold text-sm">
                                                {{ __('Editar') }}
                                            </a>
                                            <span class="text-gray-300 dark:text-gray-600">|</span>
                                            <form action="{{ route('suppliers.destroy', $supplier) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este proveedor?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 font-semibold text-sm">
                                                    {{ __('Eliminar') }}
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>