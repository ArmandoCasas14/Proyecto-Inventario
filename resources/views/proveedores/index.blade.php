<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Gestión de Proveedores') }}
            </h2>
            <a href="{{ route('proveedores.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm">
                + Nuevo Proveedor
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 rounded shadow">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="w-full text-left border-collapse text-gray-600 dark:text-gray-400">
                    <thead>
                        <tr class="border-b dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-700 dark:text-gray-300 font-bold">
                            <th class="p-3">NIT</th>
                            <th class="p-3">Razón Social</th>
                            <th class="p-3">Teléfono</th>
                            <th class="p-3">Email</th>
                            <th class="p-3">Estado</th>
                            <th class="p-3 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($proveedores as $proveedore)
                            <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-900">
                                <td class="p-3 font-mono text-sm">{{ $proveedore->nit }}</td>
                                <td class="p-3 font-semibold text-gray-800 dark:text-gray-200">{{ $proveedore->razon_social }}</td>
                                <td class="p-3">{{ $proveedore->telefono ?? 'N/A' }}</td>
                                <td class="p-3">{{ $proveedore->email ?? 'N/A' }}</td>
                                <td class="p-3">
                                    <span class="px-2 py-1 rounded text-xs font-bold {{ $proveedore->estado == 1 ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                                        {{ $proveedore->estado == 1 ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </td>
                                <td class="p-3 flex justify-center space-x-3">
                                    <a href="{{ route('proveedores.edit', $proveedore) }}" class="text-yellow-600 hover:text-yellow-900 text-sm font-medium">Editar</a>
                                    <form action="{{ route('proveedores.destroy', $proveedore) }}" method="POST" onsubmit="return confirm('¿Seguro de eliminar o desactivar este proveedor?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 text-sm font-medium">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-4 text-center">No hay proveedores registrados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>