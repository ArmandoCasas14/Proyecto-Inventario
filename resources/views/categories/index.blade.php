<x-app-layout>
    <div class="relative min-h-[calc(100vh-4rem)] -m-4 sm:-m-6 lg:-m-8 p-4 sm:p-6 lg:p-8 bg-[#f3f7f6] dark:bg-slate-950 bg-[radial-gradient(#cbd5e1_1px,transparent_1px)] dark:bg-[radial-gradient(#1e293b_1px,transparent_1px)] [background-size:16px_16px] flex justify-center items-start">
        
        <!-- CONTENEDOR CENTRAL -->
        <div class="w-full max-w-7xl bg-white dark:bg-slate-800 rounded-3xl shadow-xl border border-slate-200/80 dark:border-slate-700/80 overflow-hidden relative z-10 my-4">
            
            <!-- BANNER ENCABEZADO SUPERIOR VERDE -->
            <div class="bg-emerald-600 dark:bg-emerald-700 px-6 py-6 sm:px-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h2 class="font-bold text-2xl text-white tracking-tight">
                        {{ __('Gestión de Categorías') }}
                    </h2>
                    <p class="text-xs text-emerald-100 mt-1">
                        {{ __('Administra la clasificación general de los productos en inventario.') }}
                    </p>
                </div>

                <a href="{{ route('categorias.create') }}"
                   class="inline-flex items-center justify-center px-4 py-2.5 bg-emerald-800 hover:bg-emerald-900 text-white font-semibold text-xs rounded-xl transition-all shadow-sm gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    {{ __('Nueva Categoría') }}
                </a>
            </div>

            <!-- CUERPO PRINCIPAL -->
            <div class="p-6 sm:p-8 space-y-6">

                <!-- ALERTAS DE SESIÓN -->
                @if (session('success'))
                    <div class="p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800/60 text-emerald-800 dark:text-emerald-300 text-xs font-medium flex items-center justify-between shadow-sm">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span>{{ session('success') }}</span>
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="p-4 rounded-2xl bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-800/60 text-rose-800 dark:text-rose-300 text-xs font-medium flex items-center gap-2 shadow-sm">
                        <svg class="w-5 h-5 text-rose-600 dark:text-rose-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                <!-- BARRA DE BÚSQUEDA Y FILTROS -->
                <div class="bg-slate-50/70 dark:bg-slate-900/60 p-4 rounded-2xl border border-slate-200/60 dark:border-slate-700/60">
                    <form action="{{ route('categorias.index') }}" method="GET">
                        <div class="grid grid-cols-1 md:grid-cols-12 gap-3 items-end">
                            
                            <!-- Campo de Búsqueda -->
                            <div class="md:col-span-10">
                                <label class="block text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">
                                    {{ __('Buscar Categoría') }}
                                </label>
                                <div class="relative">
                                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por nombre o descripción..." 
                                           class="w-full text-xs rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 focus:border-emerald-500 focus:ring-emerald-500 py-2.5 pl-9 shadow-sm transition-colors">
                                    <svg class="w-4 h-4 text-slate-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                </div>
                            </div>
                            
                            <!-- Botones Buscar y Limpiar (X) -->
                            <div class="md:col-span-2 flex items-center gap-2">
                                <button type="submit" 
                                        class="w-full h-[38px] bg-slate-800 hover:bg-slate-900 dark:bg-slate-700 dark:hover:bg-slate-600 text-white font-bold text-xs uppercase tracking-wider rounded-xl transition-all shadow-sm flex items-center justify-center">
                                    {{ __('BUSCAR') }}
                                </button>

                                @if(request()->filled('search'))
                                    <a href="{{ route('categorias.index') }}" title="{{ __('Limpiar filtros') }}"
                                       class="h-[38px] px-3 bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-200 font-bold text-xs uppercase rounded-xl hover:bg-slate-300 dark:hover:bg-slate-600 transition-colors flex items-center justify-center shrink-0">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </a>
                                @endif
                            </div>

                        </div>
                    </form>
                </div>

                <!-- TABLA DE CATEGORÍAS -->
                <div class="overflow-x-auto rounded-2xl border border-slate-200/80 dark:border-slate-700/80">
                    <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700/80 text-left">
                        <thead class="bg-slate-50/80 dark:bg-slate-900/80 text-slate-500 dark:text-slate-400 uppercase tracking-wider text-[11px] font-bold">
                            <tr>
                                <th class="px-6 py-3.5">{{ __('Nombre') }}</th>
                                <th class="px-6 py-3.5">{{ __('Descripción') }}</th>
                                <th class="px-6 py-3.5">{{ __('Estado') }}</th>
                                <th class="px-6 py-3.5 text-right">{{ __('Acciones') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-700/50 text-xs bg-white dark:bg-slate-800">
                            @forelse ($categories as $category)
                                <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-700/30 transition-colors">
                                    <td class="px-6 py-4 font-semibold text-slate-800 dark:text-slate-100 whitespace-nowrap">
                                        {{ $category->name }}
                                    </td>
                                    <td class="px-6 py-4 text-slate-500 dark:text-slate-400 max-w-sm truncate">
                                        {{ $category->description ?? '—' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($category->status)
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold bg-emerald-100 text-emerald-800 dark:bg-emerald-950/60 dark:text-emerald-300">
                                                <span class="w-1.5 h-1.5 mr-1.5 rounded-full bg-emerald-500"></span>
                                                {{ __('Activo') }}
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold bg-slate-100 text-slate-600 dark:bg-slate-700/60 dark:text-slate-400">
                                                <span class="w-1.5 h-1.5 mr-1.5 rounded-full bg-slate-400"></span>
                                                {{ __('Inactivo') }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        @if(auth()->user()->role->name === 'Administrador')
                                            <div class="flex items-center justify-end gap-2">
                                                <a href="{{ route('categorias.edit', $category) }}"
                                                   title="{{ __('Editar') }}"
                                                   class="inline-flex items-center justify-center w-8 h-8 rounded-xl bg-amber-100 text-amber-700 hover:bg-amber-500 hover:text-white dark:bg-amber-950/50 dark:text-amber-400 dark:hover:bg-amber-600 dark:hover:text-white transition-all shadow-sm">
                                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </a>
                                                <form action="{{ route('categorias.toggleStatus', $category) }}" method="POST"
                                                     data-confirm="{{ $category->status ? __('¿Estás seguro de que deseas inactivar esta categoría?') : __('¿Estás seguro de que deseas activar esta categoría?') }}">
                                                    @csrf
                                                    @method('PATCH')

                                                    @if($category->status)
                                                        <button type="submit" title="{{ __('Inactivar Categoría') }}"
                                                                class="inline-flex items-center justify-center w-8 h-8 rounded-xl bg-rose-100 text-rose-700 hover:bg-rose-500 hover:text-white dark:bg-rose-950/50 dark:text-rose-400 dark:hover:bg-rose-600 dark:hover:text-white transition-all shadow-sm">
                                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4" />
                                                            </svg>
                                                        </button>
                                                    @else
                                                        <button type="submit" title="{{ __('Activar Categoría') }}"
                                                                class="inline-flex items-center justify-center w-8 h-8 rounded-xl bg-emerald-100 text-emerald-700 hover:bg-emerald-500 hover:text-white dark:bg-emerald-950/50 dark:text-emerald-400 dark:hover:bg-emerald-600 dark:hover:text-white transition-all shadow-sm">
                                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
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
                                <tr>
                                    <td colspan="4" class="px-6 py-10 text-center text-slate-500 dark:text-slate-400 italic">
                                        {{ __('No se encontraron categorías asociadas.') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($categories->hasPages())
                    <div class="pt-2">
                        {{ $categories->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>