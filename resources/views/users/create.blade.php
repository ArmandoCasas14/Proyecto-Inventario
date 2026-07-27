<x-app-layout>
    <div class="relative min-h-[calc(100vh-4rem)] -m-4 sm:-m-6 lg:-m-8 p-4 sm:p-6 lg:p-8 bg-[#f3f7f6] dark:bg-slate-950 bg-[radial-gradient(#cbd5e1_1px,transparent_1px)] dark:bg-[radial-gradient(#1e293b_1px,transparent_1px)] [background-size:16px_16px] flex justify-center items-start">
        
        <!-- CONTENEDOR CENTRAL -->
        <div class="w-full max-w-2xl bg-white dark:bg-slate-800 rounded-3xl shadow-xl border border-slate-200/80 dark:border-slate-700/80 overflow-hidden relative z-10 my-4">
            
            <!-- BANNER ENCABEZADO SUPERIOR VERDE -->
            <div class="bg-emerald-600 dark:bg-emerald-700 px-6 py-6 sm:px-8 flex items-center justify-between gap-4">
                <div>
                    <h2 class="font-bold text-2xl text-white tracking-tight">
                        {{ __('Registrar Nuevo Usuario') }}
                    </h2>
                    <p class="text-xs text-emerald-100 mt-1">
                        {{ __('Crea una nueva cuenta de usuario y asigna sus credenciales de acceso iniciales.') }}
                    </p>
                </div>

                <a href="{{ route('usuarios.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-emerald-800 hover:bg-emerald-900 text-white font-semibold text-xs rounded-xl transition-all shadow-sm gap-2 shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    {{ __('Volver') }}
                </a>
            </div>

            <!-- FORMULARIO -->
            <div class="p-6 sm:p-8">
                <form method="POST" action="{{ route('usuarios.store') }}" class="space-y-6">
                    @csrf

                    <!-- Nombre -->
                    <div>
                        <x-input-label for="name" :value="__('Nombre Completo')" class="text-xs font-bold uppercase text-slate-500 dark:text-slate-400" />
                        <x-text-input id="name" name="name" type="text" 
                                      class="mt-1.5 block w-full text-xs rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200 focus:border-emerald-500 focus:ring-emerald-500 py-2.5"
                                      :value="old('name')" required autofocus />
                        <x-input-error :messages="$errors->get('name')" class="mt-1.5" />
                    </div>

                    <!-- Email -->
                    <div>
                        <x-input-label for="email" :value="__('Correo Electrónico')" class="text-xs font-bold uppercase text-slate-500 dark:text-slate-400" />
                        <x-text-input id="email" name="email" type="email" 
                                      class="mt-1.5 block w-full text-xs rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200 focus:border-emerald-500 focus:ring-emerald-500 py-2.5"
                                      :value="old('email')" required />
                        <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
                    </div>

                    <!-- FILA DOBLE: ROL Y CONTRASEÑA (items-start evita deformaciones) -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 items-start">
                        
                        <!-- Rol -->
                        <div>
                            <x-input-label for="role_id" :value="__('Rol')" class="text-xs font-bold uppercase text-slate-500 dark:text-slate-400" />
                            <select id="role_id" name="role_id" required 
                                    class="mt-1.5 block w-full text-xs rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200 focus:border-emerald-500 focus:ring-emerald-500 py-2.5 shadow-sm">
                                <option value="">{{ __('Seleccione un rol...') }}</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('role_id')" class="mt-1.5" />
                        </div>

                        <!-- Contraseña (Temporal) -->
                        <div>
                            <x-input-label for="password" :value="__('Contraseña Inicial')" class="text-xs font-bold uppercase text-slate-500 dark:text-slate-400" />
                            <x-text-input id="password" name="password" type="password" 
                                          class="mt-1.5 block w-full text-xs rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200 focus:border-emerald-500 focus:ring-emerald-500 py-2.5" 
                                          required />
                            
                            <!-- ALERTA ORGANIZADA PARA MULTIPLES ERRORES DE CONTRASEÑA -->
                            @if ($errors->has('password'))
                                <div class="mt-2.5 p-3 bg-red-50 dark:bg-red-950/40 border border-red-200 dark:border-red-900/60 rounded-xl space-y-1">
                                    <div class="text-[11px] font-bold text-red-600 dark:text-red-400 flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                        </svg>
                                        <span>{{ __('Requisitos no cumplidos:') }}</span>
                                    </div>
                                    <ul class="list-disc list-inside text-[11px] text-red-600 dark:text-red-300 space-y-0.5 pl-1">
                                        @foreach ($errors->get('password') as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- BOTONES -->
                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-200/60 dark:border-slate-700/60">
                        <a href="{{ route('usuarios.index') }}"
                           class="px-5 py-2.5 bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-200 font-bold text-xs uppercase tracking-wider rounded-xl hover:bg-slate-300 dark:hover:bg-slate-600 transition-colors">
                            {{ __('Cancelar') }}
                        </a>
                        <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs uppercase tracking-wider rounded-xl transition-all shadow-sm">
                            {{ __('Crear Usuario') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>