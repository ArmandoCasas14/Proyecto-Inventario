<x-app-layout>
    <div class="relative min-h-[calc(100vh-4rem)] -m-4 sm:-m-6 lg:-m-8 p-4 sm:p-6 lg:p-8 bg-[#f3f7f6] dark:bg-slate-950 bg-[radial-gradient(#cbd5e1_1px,transparent_1px)] dark:bg-[radial-gradient(#1e293b_1px,transparent_1px)] [background-size:16px_16px] flex justify-center items-start">
        
        <!-- CONTENEDOR CENTRAL -->
        <div class="w-full max-w-4xl bg-white dark:bg-slate-800 rounded-3xl shadow-xl border border-slate-200/80 dark:border-slate-700/80 overflow-hidden relative z-10 my-4">
            
            <!-- BANNER ENCABEZADO SUPERIOR VERDE -->
            <div class="bg-emerald-600 dark:bg-emerald-700 px-6 py-6 sm:px-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h2 class="font-bold text-2xl text-white tracking-tight">
                        {{ __('Seguridad de la Cuenta') }}
                    </h2>
                    <p class="text-xs text-emerald-100 mt-1">
                        {{ __('Actualiza y gestiona las credenciales de acceso a tu perfil.') }}
                    </p>
                </div>

                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-semibold bg-emerald-800/80 text-emerald-100 border border-emerald-500/30">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        {{ auth()->user()->role->name ?? __('Usuario') }}
                    </span>
                </div>
            </div>

            <!-- CUERPO PRINCIPAL (FORMULARIO CONTRASEÑA) -->
            <div class="p-6 sm:p-8 space-y-6">
                @include('profile.partials.update-password-form')
            </div>

        </div>
    </div>
</x-app-layout>