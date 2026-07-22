<section>
    <header class="mb-6">
        <h3 class="text-base font-bold text-slate-800 dark:text-slate-100 flex items-center gap-2">
            <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
            </svg>
            {{ __('Cambiar Contraseña') }}
        </h3>
        <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
            {{ __('Asegúrate de utilizar una contraseña segura y compleja para mantener tu cuenta protegida.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-5">
        @csrf
        @method('put')

        <!-- Contraseña Actual -->
        <div>
            <label for="update_password_current_password" class="block text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">
                {{ __('Contraseña Actual') }}
            </label>
            <input id="update_password_current_password" 
                   name="current_password" 
                   type="password" 
                   autocomplete="current-password"
                   placeholder="••••••••"
                   class="w-full text-xs rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200 focus:border-emerald-500 focus:ring-emerald-500 py-2.5 px-3.5 shadow-sm transition-colors">
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-1.5 text-xs text-rose-600 dark:text-rose-400" />
        </div>

        <!-- Nueva Contraseña -->
        <div>
            <label for="update_password_password" class="block text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">
                {{ __('Nueva Contraseña') }}
            </label>
            <input id="update_password_password" 
                   name="password" 
                   type="password" 
                   autocomplete="new-password"
                   placeholder="••••••••"
                   class="w-full text-xs rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200 focus:border-emerald-500 focus:ring-emerald-500 py-2.5 px-3.5 shadow-sm transition-colors">
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-1.5 text-xs text-rose-600 dark:text-rose-400" />
        </div>

        <!-- Confirmar Contraseña -->
        <div>
            <label for="update_password_password_confirmation" class="block text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">
                {{ __('Confirmar Nueva Contraseña') }}
            </label>
            <input id="update_password_password_confirmation" 
                   name="password_confirmation" 
                   type="password" 
                   autocomplete="new-password"
                   placeholder="••••••••"
                   class="w-full text-xs rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200 focus:border-emerald-500 focus:ring-emerald-500 py-2.5 px-3.5 shadow-sm transition-colors">
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-1.5 text-xs text-rose-600 dark:text-rose-400" />
        </div>

        <!-- Botón Guardar y Alerta -->
        <div class="flex items-center gap-4 pt-2">
            <button type="submit" 
                    class="h-[38px] px-6 bg-slate-800 hover:bg-slate-900 dark:bg-slate-700 dark:hover:bg-slate-600 text-white font-bold text-xs uppercase tracking-wider rounded-xl transition-all shadow-sm flex items-center justify-center gap-2">
                <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                {{ __('GUARDAR CAMBIOS') }}
            </button>

            @if (session('status') === 'password-updated')
                <div x-data="{ show: true }"
                     x-show="show"
                     x-transition
                     x-init="setTimeout(() => show = false, 3000)"
                     class="text-xs font-semibold text-emerald-600 dark:text-emerald-400 flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ __('Contraseña actualizada con éxito.') }}
                </div>
            @endif
        </div>
    </form>
</section>