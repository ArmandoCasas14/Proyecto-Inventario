<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Gestión de Usuarios') }}
            </h2>
            <!-- Puedes añadir un botón para crear usuario si lo necesitas -->
            <a href="{{ route('usuarios.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition">
                + Nuevo Usuario
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <!-- Filtros -->
            <div class="mb-6 bg-white dark:bg-gray-800 p-4 rounded-lg shadow-sm border border-gray-100 dark:border-gray-700">
                <form action="{{ route('usuarios.index') }}" method="GET" class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase mb-1">Buscar</label>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Nombre o email..." class="w-full text-sm rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase mb-1">Rol</label>
                            <select name="role_id" class="w-full text-sm rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm">
                                <option value="">Todos los roles</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}" {{ request('role_id') == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex items-end gap-2">
                            <button type="submit" class="px-6 py-2 bg-gray-800 dark:bg-gray-200 text-white dark:text-gray-800 font-semibold text-xs uppercase rounded-md hover:bg-gray-700 transition">
                                Buscar
                            </button>
                            @if(request()->anyFilled(['search', 'role_id']))
                                <a href="{{ route('usuarios.index') }}" title="Limpiar filtros" class="h-[38px] px-3 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 font-semibold text-xs uppercase rounded-md hover:bg-gray-300 dark:hover:bg-gray-600 transition flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>

            <!-- Tabla -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th class="px-6 py-3">Nombre</th>
                                <th class="px-6 py-3">Email</th>
                                <th class="px-6 py-3">Rol</th>
                                <th class="px-6 py-3">Estado</th>
                                <th class="px-6 py-3 text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                            <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $user->name }}</td>
                                <td class="px-6 py-4">{{ $user->email }}</td>
                                <td class="px-6 py-4">{{ $user->role->name ?? 'Sin rol' }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 text-xs rounded-full {{ $user->status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $user->status ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    @if(auth()->user()->role->name === 'Administrador')
                                        <div class="flex items-center justify-end gap-2">
                                            
                                            <!-- EDITAR (Mantiene tu diseño original) -->
                                            <a href="{{ route('usuarios.edit', $user) }}"
                                               title="{{ __('Editar') }}"
                                               class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-amber-100 text-amber-700 hover:bg-amber-500 hover:text-white dark:bg-amber-900/40 dark:text-amber-300 dark:hover:bg-amber-600 dark:hover:text-white transition ease-in-out duration-150 shadow-sm">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>

                                            <!-- BOTÓN CONMUTADOR DE ESTADO (Reemplaza a Delete) -->
                                            <form action="{{ route('usuarios.toggleStatus', $user) }}" method="POST"
                                                  data-confirm="{{ $user->status ? __('¿Estás seguro de que deseas inactivar este usuario?') : __('¿Estás seguro de que deseas activar este usuario?') }}">
                                                @csrf
                                                @method('PATCH')
                                                
                                                @if($user->status)
                                                    <!-- BOTÓN PARA INACTIVAR (- Rojo) -->
                                                    <button type="submit" title="{{ __('Inactivar Usuario') }}"
                                                            class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-red-100 text-red-700 hover:bg-red-500 hover:text-white dark:bg-red-900/40 dark:text-red-300 dark:hover:bg-red-600 dark:hover:text-white transition ease-in-out duration-150 shadow-sm">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4" />
                                                        </svg>
                                                    </button>
                                                @else
                                                    <!-- BOTÓN PARA ACTIVAR (+ Verde) -->
                                                    <button type="submit" title="{{ __('Activar Usuario') }}"
                                                            class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-green-100 text-green-700 hover:bg-green-500 hover:text-white dark:bg-green-900/40 dark:text-green-300 dark:hover:bg-green-600 dark:hover:text-white transition ease-in-out duration-150 shadow-sm">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                                        </svg>
                                                    </button>
                                                @endif
                                            </form>
                                        </div>
                                        @endif
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="text-center py-4">No hay usuarios registrados.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4">{{ $users->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>