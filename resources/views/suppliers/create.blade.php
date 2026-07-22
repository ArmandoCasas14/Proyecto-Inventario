<x-app-layout>
    <div class="relative min-h-[calc(100vh-4rem)] -m-4 sm:-m-6 lg:-m-8 p-4 sm:p-6 lg:p-8 bg-[#f3f7f6] dark:bg-slate-950 bg-[radial-gradient(#cbd5e1_1px,transparent_1px)] dark:bg-[radial-gradient(#1e293b_1px,transparent_1px)] [background-size:16px_16px] flex justify-center items-start">
        
        <!-- CONTENEDOR CENTRAL -->
        <div class="w-full max-w-2xl bg-white dark:bg-slate-800 rounded-3xl shadow-xl border border-slate-200/80 dark:border-slate-700/80 overflow-hidden relative z-10 my-4">
            
            <!-- BANNER ENCABEZADO SUPERIOR VERDE -->
            <div class="bg-emerald-600 dark:bg-emerald-700 px-6 py-6 sm:px-8 flex items-center justify-between gap-4">
                <div>
                    <h2 class="font-bold text-2xl text-white tracking-tight">
                        {{ __('Nuevo Proveedor') }}
                    </h2>
                    <p class="text-xs text-emerald-100 mt-1">
                        {{ __('Registra los datos fiscales y de contacto de un nuevo proveedor.') }}
                    </p>
                </div>
                
                <a href="{{ route('proveedores.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-emerald-800 hover:bg-emerald-900 text-white font-semibold text-xs rounded-xl transition-all shadow-sm gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    {{ __('Volver') }}
                </a>
            </div>

            <!-- FORMULARIO -->
            <div class="p-6 sm:p-8">
                <form method="POST" action="{{ route('proveedores.store') }}" class="space-y-6">
                    @csrf

                    <div>
                        <x-input-label for="legal_name" :value="__('Razón Social')" class="text-xs font-bold uppercase text-slate-500 dark:text-slate-400" />
                        <x-text-input id="legal_name" name="legal_name" type="text" class="mt-1.5 block w-full text-xs rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200 focus:border-emerald-500 focus:ring-emerald-500 py-2.5"
                                      :value="old('legal_name')" required autofocus placeholder="Ej: Distribuidora de Carnes S.A.S." />
                        <x-input-error :messages="$errors->get('legal_name')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="nit" :value="__('NIT / Identificación Fiscal')" class="text-xs font-bold uppercase text-slate-500 dark:text-slate-400" />
                        <x-text-input id="nit" name="nit" type="text" class="mt-1.5 block w-full text-xs rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200 focus:border-emerald-500 focus:ring-emerald-500 py-2.5"
                                      :value="old('nit')" required placeholder="Ej: 900123456-1" />
                        <x-input-error :messages="$errors->get('nit')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="phone" :value="__('Teléfono')" class="text-xs font-bold uppercase text-slate-500 dark:text-slate-400" />
                            <x-text-input id="phone" name="phone" type="text" class="mt-1.5 block w-full text-xs rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200 focus:border-emerald-500 focus:ring-emerald-500 py-2.5"
                                          :value="old('phone')" placeholder="Ej: +57 300 123 4567" />
                            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="email" :value="__('Correo Electrónico')" class="text-xs font-bold uppercase text-slate-500 dark:text-slate-400" />
                            <x-text-input id="email" name="email" type="email" class="mt-1.5 block w-full text-xs rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200 focus:border-emerald-500 focus:ring-emerald-500 py-2.5"
                                          :value="old('email')" placeholder="proveedor@contacto.com" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                    </div>

                    <div>
                        <x-input-label for="address" :value="__('Dirección')" class="text-xs font-bold uppercase text-slate-500 dark:text-slate-400" />
                        <x-text-input id="address" name="address" type="text" class="mt-1.5 block w-full text-xs rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200 focus:border-emerald-500 focus:ring-emerald-500 py-2.5"
                                      :value="old('address')" placeholder="Ej: Calle 10 # 15-20" />
                        <x-input-error :messages="$errors->get('address')" class="mt-2" />
                    </div>

                    <!-- BOTONES -->
                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-200/60 dark:border-slate-700/60">
                        <a href="{{ route('proveedores.index') }}"
                           class="px-5 py-2.5 bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-200 font-bold text-xs uppercase tracking-wider rounded-xl hover:bg-slate-300 dark:hover:bg-slate-600 transition-colors">
                            {{ __('Cancelar') }}
                        </a>
                        <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs uppercase tracking-wider rounded-xl transition-all shadow-sm">
                            {{ __('Guardar Proveedor') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>