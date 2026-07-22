<x-app-layout>
    <div class="relative min-h-[calc(100vh-4rem)] -m-4 sm:-m-6 lg:-m-8 p-4 sm:p-6 lg:p-8 bg-[#f3f7f6] dark:bg-slate-950 bg-[radial-gradient(#cbd5e1_1px,transparent_1px)] dark:bg-[radial-gradient(#1e293b_1px,transparent_1px)] [background-size:16px_16px] flex justify-center items-start">
        
        <!-- CONTENEDOR CENTRAL -->
        <div class="w-full max-w-2xl bg-white dark:bg-slate-800 rounded-3xl shadow-xl border border-slate-200/80 dark:border-slate-700/80 overflow-hidden relative z-10 my-4">
            
            <!-- BANNER ENCABEZADO SUPERIOR VERDE -->
            <div class="bg-emerald-600 dark:bg-emerald-700 px-6 py-6 sm:px-8 flex items-center justify-between gap-4">
                <div>
                    <h2 class="font-bold text-2xl text-white tracking-tight">
                        {{ __('Nueva Categoría') }}
                    </h2>
                    <p class="text-xs text-emerald-100 mt-1">
                        {{ __('Registra una nueva categoría para agrupar productos en el inventario.') }}
                    </p>
                </div>
                
                <a href="{{ route('categorias.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-emerald-800 hover:bg-emerald-900 text-white font-semibold text-xs rounded-xl transition-all shadow-sm gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    {{ __('Volver') }}
                </a>
            </div>

            <!-- FORMULARIO -->
            <div class="p-6 sm:p-8">
                <form method="POST" action="{{ route('categorias.store') }}" class="space-y-6">
                    @csrf

                    <div>
                        <x-input-label for="name" :value="__('Nombre de la Categoría')" class="text-xs font-bold uppercase text-slate-500 dark:text-slate-400" />
                        <x-text-input id="name" name="name" type="text" class="mt-1.5 block w-full text-xs rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200 focus:border-emerald-500 focus:ring-emerald-500 py-2.5"
                                      :value="old('name')" required autofocus placeholder="Ej: Embutidos y Carnes Frías" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="description" :value="__('Descripción')" class="text-xs font-bold uppercase text-slate-500 dark:text-slate-400" />
                        <textarea id="description" name="description" rows="4"
                                  placeholder="Ingresa una breve descripción informativa..."
                                  class="mt-1.5 block w-full text-xs rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm">{{ old('description') }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <!-- BOTONES -->
                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-200/60 dark:border-slate-700/60">
                        <a href="{{ route('categorias.index') }}"
                           class="px-5 py-2.5 bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-200 font-bold text-xs uppercase tracking-wider rounded-xl hover:bg-slate-300 dark:hover:bg-slate-600 transition-colors">
                            {{ __('Cancelar') }}
                        </a>
                        <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs uppercase tracking-wider rounded-xl transition-all shadow-sm">
                            {{ __('Guardar Categoría') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>