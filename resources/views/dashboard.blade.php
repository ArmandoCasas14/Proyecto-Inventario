<x-app-layout>
    <div class="max-w-7xl mx-auto space-y-8">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Dashboard General</h1>
                <p class="text-sm text-gray-500 mt-1">Resumen de operaciones, estadísticas de ventas y alertas de inventario en tiempo real</p>
            </div>
            <a href="{{ route('facturas.create') }}" 
               class="inline-flex items-center justify-center bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-5 py-2.5 rounded-xl shadow-md hover:shadow-lg transition duration-150 gap-2 text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Registrar Nueva Venta
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            
            <div class="bg-white p-6 rounded-2xl shadow-xs border border-gray-200/80 flex flex-col justify-between">
                <div>
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-1">Ventas de Hoy</span>
                    <h3 class="text-3xl font-extrabold text-gray-900 tracking-tight">
                        $1,240,50
                    </h3>
                </div>
                <div class="mt-4 flex items-center gap-2">
                    <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-xs font-semibold bg-green-50 text-green-700">
                        ↑ 12%
                    </span>
                    <span class="text-xs text-gray-400">vs. ayer</span>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-xs border border-gray-200/80 flex flex-col justify-between">
                <div>
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-1">Facturas Emitidas</span>
                    <h3 class="text-3xl font-extrabold text-gray-900 tracking-tight">
                        18
                    </h3>
                </div>
                <div class="mt-4 flex items-center gap-2">
                    <span class="text-xs text-gray-400 font-medium">Ticket promedio:</span>
                    <span class="text-xs font-bold text-indigo-600">$68.90</span>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-xs border border-gray-200/80 flex flex-col justify-between">
                <div>
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-1">Alertas de Stock</span>
                    <h3 class="text-3xl font-extrabold text-red-600 tracking-tight">
                        5
                    </h3>
                </div>
                <div class="mt-4 flex items-center gap-2">
                    <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-xs font-bold bg-red-50 text-red-700 animate-pulse">
                        ⚠️ Crítico
                    </span>
                    <span class="text-xs text-gray-400">requiere reabastecimiento</span>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-xs border border-gray-200/80 flex flex-col justify-between">
                <div>
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-1">Total Productos</span>
                    <h3 class="text-3xl font-extrabold text-gray-900 tracking-tight">
                        142
                    </h3>
                </div>
                <div class="mt-4 flex items-center justify-between">
                    <span class="text-xs text-gray-400">En 8 categorías</span>
                    <a href="{{ route('productos.index') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 transition">Ver todos →</a>
                </div>
            </div>

        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200/80 overflow-hidden lg:col-span-2">
                <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
                    <div>
                        <h2 class="font-bold text-gray-800 text-lg">⚠️ Alertas de Bajo Stock</h2>
                        <p class="text-xs text-gray-400">Productos con existencias inferiores o iguales al mínimo configurado</p>
                    </div>
                    <span class="bg-red-100 text-red-800 text-xs font-bold px-2.5 py-1 rounded-full">Acción Urgente</span>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50/20">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Código</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Producto</th>
                                <th class="px-6 py-3 text-center text-xs font-semibold text-gray-400 uppercase tracking-wider">Stock Actual</th>
                                <th class="px-6 py-3 text-center text-xs font-semibold text-gray-400 uppercase tracking-wider">Mínimo</th>
                                <th class="px-6 py-3 text-center text-xs font-semibold text-gray-400 uppercase tracking-wider">Acción</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            <tr class="hover:bg-gray-50/40 transition">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-mono font-bold text-indigo-600">PROD-0041</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">Salchicha Ranchera de Ternera</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-bold bg-red-50 text-red-700">
                                        3 unidades
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium text-gray-400">15</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                    <a href="{{ route('productos.edit', 1) }}" class="text-indigo-600 hover:text-indigo-900 font-bold transition">Surtir</a>
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50/40 transition">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-mono font-bold text-indigo-600">PROD-0102</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">Lomo de Cerdo Ahumado x 1kg</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-bold bg-red-50 text-red-700">
                                        1 unidad
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium text-gray-400">10</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                    <a href="{{ route('productos.edit', 2) }}" class="text-indigo-600 hover:text-indigo-900 font-bold transition">Surtir</a>
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50/40 transition">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-mono font-bold text-indigo-600">PROD-0012</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">Chorizo Santarrosano Tradicional</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-bold bg-amber-50 text-amber-700">
                                        5 unidades
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium text-gray-400">5</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                    <a href="{{ route('productos.edit', 3) }}" class="text-indigo-600 hover:text-indigo-900 font-bold transition">Surtir</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-200/80 p-6 flex flex-col justify-between">
                <div>
                    <h2 class="font-bold text-gray-800 text-lg">📊 Métodos de Pago</h2>
                    <p class="text-xs text-gray-400 mb-6">Uso y distribución de transacciones de hoy</p>
                    
                    <div class="space-y-4">
                        <div>
                            <div class="flex justify-between text-sm font-semibold text-gray-700 mb-1">
                                <span>💵 Efectivo</span>
                                <span>65%</span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-2">
                                <div class="bg-green-500 h-2 rounded-full" style="width: 65%"></div>
                            </div>
                        </div>

                        <div>
                            <div class="flex justify-between text-sm font-semibold text-gray-700 mb-1">
                                <span>🏦 Transferencia / Nequi</span>
                                <span>25%</span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-2">
                                <div class="bg-indigo-500 h-2 rounded-full" style="width: 25%"></div>
                            </div>
                        </div>

                        <div>
                            <div class="flex justify-between text-sm font-semibold text-gray-700 mb-1">
                                <span>💳 Tarjeta de Crédito/Débito</span>
                                <span>10%</span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-2">
                                <div class="bg-amber-500 h-2 rounded-full" style="width: 10%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-6 border-t border-gray-100 mt-6">
                    <a href="{{ route('invoices.index') }}" class="w-full inline-flex justify-center items-center bg-gray-50 hover:bg-gray-100 text-gray-700 text-xs font-bold py-2.5 rounded-xl border border-gray-200/50 transition">
                        Ver Control de Caja →
                    </a>
                </div>
            </div>

        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200/80 overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
                <div>
                    <h2 class="font-bold text-gray-800 text-lg">🧾 Últimas Ventas Realizadas</h2>
                    <p class="text-xs text-gray-400">Listado de las transacciones procesadas recientemente en caja</p>
                </div>
                <a href="{{ route('invoices.index') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 transition">
                    Ver Historial Completo
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50/20">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Nº Factura</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Cliente</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Hora</th>
                            <th class="px-6 py-3 text-center text-xs font-semibold text-gray-400 uppercase tracking-wider">Estado</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-gray-400 uppercase tracking-wider">Monto Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        <tr class="hover:bg-gray-50/40 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-mono font-bold text-indigo-600">#FAC-0312</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-semibold text-gray-900">Distribuidora Alberth Sur</div>
                                <div class="text-xs text-gray-400">Consumidor Final</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Hace 10 mins</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                    Cobrado
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-bold text-gray-900">$340.00</td>
                        </tr>
                        <tr class="hover:bg-gray-50/40 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-mono font-bold text-indigo-600">#FAC-0311</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-semibold text-gray-900">Carnicería El Buen Sabor</div>
                                <div class="text-xs text-gray-400">NIT: 901.345.122-4</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Hace 45 mins</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                    Cobrado
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-bold text-gray-900">$189.50</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>