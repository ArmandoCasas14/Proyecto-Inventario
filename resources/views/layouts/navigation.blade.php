<nav x-data="{ open: false }" class="bg-white/90 dark:bg-slate-900/90 backdrop-blur-md border-b border-slate-200/80 dark:border-slate-800 sticky top-0 z-50 transition-colors duration-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            
            <!-- SECCIÓN IZQUIERDA: LOGO + NAVEGACIÓN PRINCIPAL -->
            <div class="flex items-center gap-6">
                <!-- Brand / Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="font-extrabold text-base tracking-tight text-slate-800 dark:text-slate-100 flex items-center gap-2 group">
                        <span class="w-9 h-9 bg-emerald-600 dark:bg-emerald-600 text-white rounded-xl flex items-center justify-center shadow-md shadow-emerald-600/20 group-hover:scale-105 transition-transform">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        </span>
                        <span class="font-bold text-slate-800 dark:text-white">Stock<span class="text-emerald-600 dark:text-emerald-400">Master</span></span>
                    </a>
                </div>

                <!-- Enlaces de Navegación Escritorio -->
                <div class="hidden lg:flex items-center space-x-1">
                    
                    <!-- Dashboard -->
                    <a href="{{ route('dashboard') }}" 
                       class="px-3 py-2 rounded-xl text-xs font-semibold flex items-center gap-1.5 transition-all duration-150 {{ request()->routeIs('dashboard') ? 'bg-emerald-50 dark:bg-emerald-950/50 text-emerald-600 dark:text-emerald-400' : 'text-slate-600 dark:text-slate-400 hover:text-emerald-600 dark:hover:text-emerald-400 hover:bg-slate-100/60 dark:hover:bg-slate-800/60' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 00-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        <span>{{ __('Dashboard') }}</span>
                    </a>

                    <!-- Registrar Venta -->
                    <a href="{{ route('facturas.create') }}" 
                       class="px-3 py-2 rounded-xl text-xs font-semibold flex items-center gap-1.5 transition-all duration-150 {{ request()->routeIs('facturas.create') ? 'bg-emerald-50 dark:bg-emerald-950/50 text-emerald-600 dark:text-emerald-400' : 'text-slate-600 dark:text-slate-400 hover:text-emerald-600 dark:hover:text-emerald-400 hover:bg-slate-100/60 dark:hover:bg-slate-800/60' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>{{ __('Venta') }}</span>
                    </a>

                    <!-- Ventas / Historial -->
                    <a href="{{ route('facturas.index') }}" 
                       class="px-3 py-2 rounded-xl text-xs font-semibold flex items-center gap-1.5 transition-all duration-150 {{ request()->routeIs('facturas.index') ? 'bg-emerald-50 dark:bg-emerald-950/50 text-emerald-600 dark:text-emerald-400' : 'text-slate-600 dark:text-slate-400 hover:text-emerald-600 dark:hover:text-emerald-400 hover:bg-slate-100/60 dark:hover:bg-slate-800/60' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <span>{{ __('Historial') }}</span>
                    </a>

                    <!-- Productos -->
                    <a href="{{ route('productos.index') }}" 
                       class="px-3 py-2 rounded-xl text-xs font-semibold flex items-center gap-1.5 transition-all duration-150 {{ request()->routeIs('productos.*') ? 'bg-emerald-50 dark:bg-emerald-950/50 text-emerald-600 dark:text-emerald-400' : 'text-slate-600 dark:text-slate-400 hover:text-emerald-600 dark:hover:text-emerald-400 hover:bg-slate-100/60 dark:hover:bg-slate-800/60' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 01-2-2V5a2 2 0 012-2h14a2 2 0 012 2v1a2 2 0 01-2 2M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
                        <span>{{ __('Productos') }}</span>
                    </a>

                    <!-- Categorías -->
                    <a href="{{ route('categorias.index') }}" 
                       class="px-3 py-2 rounded-xl text-xs font-semibold flex items-center gap-1.5 transition-all duration-150 {{ request()->routeIs('categorias.*') ? 'bg-emerald-50 dark:bg-emerald-950/50 text-emerald-600 dark:text-emerald-400' : 'text-slate-600 dark:text-slate-400 hover:text-emerald-600 dark:hover:text-emerald-400 hover:bg-slate-100/60 dark:hover:bg-slate-800/60' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                        <span>{{ __('Categorías') }}</span>
                    </a>

                    <!-- Proveedores -->
                    <a href="{{ route('proveedores.index') }}" 
                       class="px-3 py-2 rounded-xl text-xs font-semibold flex items-center gap-1.5 transition-all duration-150 {{ request()->routeIs('proveedores.*') ? 'bg-emerald-50 dark:bg-emerald-950/50 text-emerald-600 dark:text-emerald-400' : 'text-slate-600 dark:text-slate-400 hover:text-emerald-600 dark:hover:text-emerald-400 hover:bg-slate-100/60 dark:hover:bg-slate-800/60' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        <span>{{ __('Proveedores') }}</span>
                    </a>

                    <!-- Movimientos -->
                    <a href="{{ route('movimientos.index') }}" 
                       class="px-3 py-2 rounded-xl text-xs font-semibold flex items-center gap-1.5 transition-all duration-150 {{ request()->routeIs('movimientos.*') ? 'bg-emerald-50 dark:bg-emerald-950/50 text-emerald-600 dark:text-emerald-400' : 'text-slate-600 dark:text-slate-400 hover:text-emerald-600 dark:hover:text-emerald-400 hover:bg-slate-100/60 dark:hover:bg-slate-800/60' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                        <span>{{ __('Movimientos') }}</span>
                    </a>
                    
                    <!-- Usuarios (Solo Admin) -->
                    @if(auth()->user()->role->name === 'Administrador')
                    <a href="{{ route('usuarios.index') }}" 
                       class="px-3 py-2 rounded-xl text-xs font-semibold flex items-center gap-1.5 transition-all duration-150 {{ request()->routeIs('usuarios.*') ? 'bg-emerald-50 dark:bg-emerald-950/50 text-emerald-600 dark:text-emerald-400' : 'text-slate-600 dark:text-slate-400 hover:text-emerald-600 dark:hover:text-emerald-400 hover:bg-slate-100/60 dark:hover:bg-slate-800/60' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        <span>{{ __('Usuarios') }}</span>
                    </a>
                    @endif
                </div>
            </div>

            <!-- SECCIÓN DERECHA: NOTIFICACIONES Y BOTÓN DE USUARIO -->
            <div class="hidden sm:flex sm:items-center sm:gap-2">

                <!-- 🔔 MENÚ DESPLEGABLE DE NOTIFICACIONES -->
                <div class="relative" x-data="{ openNotifications: false }">
                    <button @click="openNotifications = !openNotifications" 
                            class="relative inline-flex items-center justify-center w-9 h-9 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-emerald-50 hover:text-emerald-600 dark:hover:bg-slate-700 dark:hover:text-emerald-400 transition-all shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                        
                        <!-- Insignia (Badge) de Notificaciones -->
                        @if(auth()->user()->unreadNotifications->count() > 0)
                            <span class="absolute -top-1 -right-1 flex h-4 w-4 items-center justify-center rounded-full bg-rose-600 text-[10px] font-bold text-white ring-2 ring-white dark:ring-slate-900 animate-pulse">
                                {{ auth()->user()->unreadNotifications->count() }}
                            </span>
                        @endif
                    </button>

                    <!-- Modal Desplegable de Notificaciones -->
                    <div x-show="openNotifications" 
                         @click.outside="openNotifications = false" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                         x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
                         style="display: none;" 
                         class="absolute right-0 mt-3 w-80 sm:w-96 bg-white dark:bg-slate-800 rounded-2xl shadow-xl overflow-hidden z-50 border border-slate-200/80 dark:border-slate-700/80">
                        
                        <!-- Encabezado Notificaciones -->
                        <div class="px-4 py-3 bg-slate-50 dark:bg-slate-900/80 font-bold text-xs text-slate-700 dark:text-slate-300 uppercase tracking-wider flex justify-between items-center border-b border-slate-100 dark:border-slate-700/60">
                            <span class="flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                {{ __('Notificaciones') }}
                            </span>
                            @if(auth()->user()->unreadNotifications->count() > 0)
                                <form action="{{ route('notifications.markAsRead') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-[11px] text-emerald-600 dark:text-emerald-400 hover:text-emerald-700 dark:hover:text-emerald-300 font-semibold transition-colors">
                                        {{ __('Marcar leídas') }}
                                    </button>
                                </form>
                            @endif
                        </div>

                        <!-- Lista de Notificaciones -->
                        <div class="max-h-72 overflow-y-auto divide-y divide-slate-100 dark:divide-slate-700/50">
                            @forelse(auth()->user()->unreadNotifications as $notification)
                                <div class="p-3.5 hover:bg-emerald-50/50 dark:hover:bg-slate-700/50 transition duration-150 flex items-start gap-3">
                                    <span class="p-1.5 bg-amber-100 text-amber-700 dark:bg-amber-950/60 dark:text-amber-400 rounded-lg shrink-0 mt-0.5">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                    </span>
                                    <div class="flex-1">
                                        <p class="font-medium text-slate-800 dark:text-slate-200 text-xs leading-relaxed">
                                            {{ $notification->data['message'] }}
                                        </p>
                                        <span class="text-[10px] text-slate-400 dark:text-slate-500 mt-1 block">
                                            {{ $notification->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                </div>
                            @empty
                                <div class="py-8 px-4 text-center text-xs text-slate-400 dark:text-slate-500 italic flex flex-col items-center gap-2">
                                    <svg class="w-8 h-8 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                                    {{ __('Sin notificaciones pendientes') }}
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- 👤 MENU DESPLEGABLE DE USUARIO (SOLO ÍCONO Y FLECHA) -->
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button title="{{ Auth::user()->name }}" class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-slate-800 hover:bg-slate-900 dark:bg-slate-700 dark:hover:bg-slate-600 text-white transition-all shadow-sm focus:outline-none">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <!-- Cabecera opcional dentro del menú desplegable para saber con qué cuenta se está navegando -->
                        <div class="px-4 py-2 border-b border-slate-100 dark:border-slate-700/60">
                            <p class="text-xs font-bold text-slate-800 dark:text-slate-200 truncate">{{ Auth::user()->name }}</p>
                            <p class="text-[10px] text-slate-400 truncate">{{ Auth::user()->email }}</p>
                        </div>

                        <x-dropdown-link :href="route('profile.edit')" class="flex items-center gap-2 text-xs py-2 hover:bg-slate-50 dark:hover:bg-slate-700/60">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            {{ __('Mi Perfil') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();"
                                    class="flex items-center gap-2 text-xs py-2 text-rose-600 dark:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-950/40">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                {{ __('Cerrar Sesión') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>

            </div>

            <!-- BOTÓN MENÚ MÓVIL (HAMBURGUESA) -->
            <div class="-mr-2 flex items-center lg:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-xl text-slate-500 hover:text-slate-700 hover:bg-slate-100 dark:text-slate-400 dark:hover:text-slate-200 dark:hover:bg-slate-800 transition duration-150">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- MENÚ RESPONSIVO (MÓVIL) -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden lg:hidden border-t border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900">
        <div class="pt-2 pb-3 space-y-1 px-4">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('facturas.create')" :active="request()->routeIs('facturas.create')">
                {{ __('Registrar Venta') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('facturas.index')" :active="request()->routeIs('facturas.index')">
                {{ __('Historial Ventas') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('productos.index')" :active="request()->routeIs('productos.*')">
                {{ __('Productos') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('categorias.index')" :active="request()->routeIs('categorias.*')">
                {{ __('Categorías') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('proveedores.index')" :active="request()->routeIs('proveedores.*')">
                {{ __('Proveedores') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('movimientos.index')" :active="request()->routeIs('movimientos.*')">
                {{ __('Movimientos') }}
            </x-responsive-nav-link>
            @if(auth()->user()->role->name === 'Administrador')
            <x-responsive-nav-link :href="route('usuarios.index')" :active="request()->routeIs('usuarios.*')">
                {{ __('Usuarios') }}
            </x-responsive-nav-link>
            @endif
        </div>

        <div class="pt-4 pb-3 border-t border-slate-200 dark:border-slate-800">
            <div class="px-4 flex justify-between items-center mb-3">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-slate-800 text-white flex items-center justify-center text-xs font-bold">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    <div>
                        <div class="font-bold text-xs text-slate-800 dark:text-slate-200">{{ Auth::user()->name }}</div>
                        <div class="text-[10px] text-slate-400">{{ Auth::user()->email }}</div>
                    </div>
                </div>
                
                @if(auth()->user()->unreadNotifications->count() > 0)
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-rose-100 text-rose-800 dark:bg-rose-950/60 dark:text-rose-300">
                        {{ auth()->user()->unreadNotifications->count() }} alertas
                    </span>
                @endif
            </div>

            <div class="space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Mi Perfil') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Cerrar Sesión') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>