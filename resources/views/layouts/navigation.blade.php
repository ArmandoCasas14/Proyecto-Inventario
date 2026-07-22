<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="text-indigo-600 dark:text-indigo-400 font-extrabold tracking-wider flex items-center gap-2">
                        <span class="p-1.5 bg-indigo-100 dark:bg-indigo-900/50 rounded-lg text-sm">📦</span>
                        Stock Master
                    </a>
                </div>

                <div class="hidden space-x-6 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link class="text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400" :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    <x-nav-link class="text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 ms-2" :href="route('facturas.create')" :active="request()->routeIs('facturas.create')">
                        {{ __('Registrar Venta') }}
                    </x-nav-link>

                    <x-nav-link class="text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 ms-2" :href="route('facturas.index')" :active="request()->routeIs('facturas.index')">
                        {{ __('Historial Ventas') }}
                    </x-nav-link>

                    <x-nav-link class="text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 ms-2" :href="route('productos.index')" :active="request()->routeIs('productos.*')">
                        {{ __('Productos') }}
                    </x-nav-link>

                    <x-nav-link class="text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 ms-2" :href="route('categorias.index')" :active="request()->routeIs('categorias.*')">
                        {{ __('Categorías') }}
                    </x-nav-link>

                    <x-nav-link class="text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 ms-2" :href="route('proveedores.index')" :active="request()->routeIs('proveedores.*')">
                        {{ __('Proveedores') }}
                    </x-nav-link>

                    <x-nav-link class="text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 ms-2" :href="route('movimientos.index')" :active="request()->routeIs('movimientos.*')">
                        {{ __('Movimientos') }}
                    </x-nav-link>
                    
                    @if(auth()->user()->role->name === 'Administrador')
                    <x-nav-link class="text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 ms-2" :href="route('usuarios.index')" :active="request()->routeIs('usuarios.*')">
                        {{ __('Usuarios') }}
                    </x-nav-link>
                    @endif
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6 space-x-3">
                <!-- 🔔 MENÚ DESPLEGABLE DE NOTIFICACIONES -->
                <div class="relative" x-data="{ openNotifications: false }">
                    <button @click="openNotifications = !openNotifications" class="relative p-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 focus:outline-none transition ease-in-out duration-150">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                        
                        <!-- Globo rojo de número de alertas no leídas -->
                        @if(auth()->user()->unreadNotifications->count() > 0)
                            <span class="absolute top-1 right-1 inline-flex items-center justify-center px-1.5 py-0.5 text-[10px] font-bold leading-none text-white transform translate-x-1/3 -translate-y-1/3 bg-red-600 rounded-full">
                                {{ auth()->user()->unreadNotifications->count() }}
                            </span>
                        @endif
                    </button>

                    <!-- Desplegable -->
                    <div x-show="openNotifications" @click.outside="openNotifications = false" style="display: none;" 
                         class="absolute right-0 mt-2 w-80 bg-white dark:bg-gray-800 rounded-md shadow-lg overflow-hidden z-50 border border-gray-200 dark:border-gray-700">
                        
                        <div class="py-2 px-4 bg-gray-50 dark:bg-gray-700/50 font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-wider flex justify-between items-center border-b border-gray-100 dark:border-gray-700">
                            <span>Notificaciones</span>
                            @if(auth()->user()->unreadNotifications->count() > 0)
                                <form action="{{ route('notifications.markAsRead') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-xs text-indigo-600 dark:text-indigo-400 hover:underline lowercase font-normal">
                                        marcar leídas
                                    </button>
                                </form>
                            @endif
                        </div>

                        <div class="max-h-64 overflow-y-auto divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse(auth()->user()->unreadNotifications as $notification)
                                <div class="p-3 text-sm hover:bg-gray-50 dark:hover:bg-gray-700/50 transition duration-150">
                                    <p class="font-semibold text-gray-800 dark:text-gray-200 text-xs leading-relaxed">
                                        {{ $notification->data['message'] }}
                                    </p>
                                    <span class="text-[10px] text-gray-400 mt-1 block">
                                        {{ $notification->created_at->diffForHumans() }}
                                    </span>
                                </div>
                            @empty
                                <div class="p-4 text-center text-xs text-gray-500 dark:text-gray-400">
                                    Sin notificaciones pendientes
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- MENU PERFIL USUARIO -->
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Mi Perfil') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Cerrar Sesión') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Menú Responsivo (Móvil) -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
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

        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4 flex justify-between items-center">
                <div>
                    <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
                
                <!-- Globo de notificaciones en móvil -->
                @if(auth()->user()->unreadNotifications->count() > 0)
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-300">
                        {{ auth()->user()->unreadNotifications->count() }} alertas
                    </span>
                @endif
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Mi Perfil') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Cerrar Sesión') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>