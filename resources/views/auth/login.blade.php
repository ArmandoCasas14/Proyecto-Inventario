<x-guest-layout>
    <div class="min-h-screen grid grid-cols-1 lg:grid-cols-12 bg-slate-50">
        
        <!-- SECCIÓN IZQUIERDA: Banner Informativo Claro (Sin gradientes) -->
        <div class="hidden lg:flex lg:col-span-6 xl:col-span-7 relative bg-emerald-50/80 flex-col justify-between p-12 border-r border-emerald-100">
            
            <!-- Patrón de Fondo Decorativo Sutil -->
            <div class="absolute inset-0 opacity-20 bg-[radial-gradient(#059669_1px,transparent_1px)] [background-size:16px_16px]"></div>

            <!-- Header / Branding -->
            <div class="relative z-10 flex items-center gap-3">
                <div class="p-2.5 bg-emerald-600 rounded-xl text-white shadow-sm">
                    <!-- Icono de Caja/Inventario -->
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-xl font-bold tracking-wide text-gray-900 uppercase">StockMaster</h1>
                    <p class="text-xs text-emerald-700 font-semibold">Sistema de Gestión e Inventarios</p>
                </div>
            </div>

            <!-- Centro: Mensaje e Ilustración de Métricas -->
            <div class="relative z-10 my-auto py-12 max-w-xl">
                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 border border-emerald-200 mb-6">
                    <span class="w-2 h-2 rounded-full bg-emerald-600 animate-pulse"></span>
                    {{ __('Control Total en Tiempo Real') }}
                </span>

                <h2 class="text-4xl font-extrabold text-gray-900 leading-tight tracking-tight">
                    Optimiza tu almacén, gestiona tus productos y domina tus ventas.
                </h2>
                
                <p class="mt-4 text-gray-600 text-sm leading-relaxed">
                    Supervisa trazabilidad de movimientos, existencias mínimas, proveedores y niveles de stock con precisión absoluta.
                </p>

                <!-- Tarjetas Ilustrativas Flotantes -->
                <div class="grid grid-cols-2 gap-4 mt-8">
                    <div class="p-4 rounded-xl bg-white border border-emerald-100 shadow-sm">
                        <div class="flex items-center gap-2 text-emerald-700 mb-1">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                            <span class="text-xs font-bold uppercase tracking-wider text-gray-500">Eficiencia</span>
                        </div>
                        <p class="text-xl font-bold text-gray-900">+99.4%</p>
                        <p class="text-[11px] text-gray-500">Precisión de existencias</p>
                    </div>

                    <div class="p-4 rounded-xl bg-white border border-emerald-100 shadow-sm">
                        <div class="flex items-center gap-2 text-emerald-700 mb-1">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            <span class="text-xs font-bold uppercase tracking-wider text-gray-500">Alertas</span>
                        </div>
                        <p class="text-xl font-bold text-gray-900">Automatizadas</p>
                        <p class="text-[11px] text-gray-500">Reabastecimiento y Stock mínimo</p>
                    </div>
                </div>
            </div>

            <!-- Footer Izquierdo -->
            <div class="relative z-10 text-xs text-gray-500">
                &copy; {{ date('Y') }} StockControl System. Todos los derechos reservados.
            </div>
        </div>

        <!-- SECCIÓN DERECHA: Formulario de Login -->
        <div class="col-span-1 lg:col-span-6 xl:col-span-5 flex flex-col justify-center items-center p-6 sm:p-12 bg-white">
            <div class="w-full max-w-md space-y-8">
                
                <!-- Encabezado Titulo -->
                <div class="text-left">
                    <div class="inline-flex lg:hidden items-center gap-2 mb-6">
                        <div class="p-2 bg-emerald-600 rounded-lg text-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                        <span class="font-bold text-lg text-gray-900">StockControl</span>
                    </div>

                    <h2 class="text-2xl font-bold text-gray-900 tracking-tight">
                        {{ __('Iniciar Sesión') }}
                    </h2>
                    <p class="mt-1 text-sm text-gray-500">
                        {{ __('Ingresa tus credenciales para acceder al panel de control.') }}
                    </p>
                </div>

                <!-- Session Status (Errores globales de sesión) -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <!-- Correo Electrónico -->
                    <div>
                        <x-input-label for="email" :value="__('Correo Electrónico')" class="text-gray-700 text-xs uppercase font-bold tracking-wider" />
                        <div class="relative mt-1.5">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/></svg>
                            </div>
                            <x-text-input id="email" 
                                class="block w-full pl-10 pr-4 py-2.5 bg-gray-50 border-gray-300 text-gray-900 focus:bg-white focus:border-emerald-600 focus:ring-emerald-600/20 rounded-xl shadow-sm text-sm" 
                                type="email" 
                                name="email" 
                                :value="old('email')" 
                                required 
                                autofocus 
                                autocomplete="username" 
                                placeholder="usuario@empresa.com" />
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
                    </div>

                    <!-- Contraseña -->
                    <div>
                        <div class="flex items-center justify-between">
                            <x-input-label for="password" :value="__('Contraseña')" class="text-gray-700 text-xs uppercase font-bold tracking-wider" />
                            @if (Route::has('password.request'))
                                <a class="text-xs text-emerald-700 hover:text-emerald-800 transition-colors font-semibold" href="{{ route('password.request') }}">
                                    {{ __('¿Olvidaste tu contraseña?') }}
                                </a>
                            @endif
                        </div>
                        <div class="relative mt-1.5">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            </div>
                            <x-text-input id="password" 
                                class="block w-full pl-10 pr-4 py-2.5 bg-gray-50 border-gray-300 text-gray-900 focus:bg-white focus:border-emerald-600 focus:ring-emerald-600/20 rounded-xl shadow-sm text-sm" 
                                type="password" 
                                name="password" 
                                required 
                                autocomplete="current-password" 
                                placeholder="••••••••" />
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
                    </div>

                    <!-- Botón Ingresar (Sólido sin gradiente) -->
                    <button type="submit" 
                        class="w-full inline-flex justify-center items-center gap-2 px-5 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm rounded-xl transition duration-150 shadow-md shadow-emerald-600/20 focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:ring-offset-2">
                        <span>{{ __('Ingresar al Sistema') }}</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </button>
                </form>

            </div>
        </div>

    </div>
</x-guest-layout>