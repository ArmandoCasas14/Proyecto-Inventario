<x-app-layout>
    <div class="max-w-7xl mx-auto space-y-8">

        <!-- Encabezado -->
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

        <!-- Tarjetas Estadísticas -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            
            <!-- Ventas de Hoy -->
            <div class="bg-white p-6 rounded-2xl shadow-xs border border-gray-200/80 flex flex-col justify-between">
                <div>
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-1">Ventas de Hoy</span>
                    <h3 class="text-3xl font-extrabold text-gray-900 tracking-tight">
                        ${{ number_format($ventasHoy, 2) }}
                    </h3>
                </div>
                <div class="mt-4 flex items-center gap-2">
                    @if($porcentajeVariacion >= 0)
                        <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-xs font-semibold bg-green-50 text-green-700">
                            ↑ {{ round($porcentajeVariacion) }}%
                        </span>
                    @else
                        <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-xs font-semibold bg-red-50 text-red-700">
                            ↓ {{ abs(round($porcentajeVariacion)) }}%
                        </span>
                    @endif
                    <span class="text-xs text-gray-400">vs. ayer</span>
                </div>
            </div>

            <!-- Facturas Emitidas -->
            <div class="bg-white p-6 rounded-2xl shadow-xs border border-gray-200/80 flex flex-col justify-between">
                <div>
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-1">Facturas Emitidas</span>
                    <h3 class="text-3xl font-extrabold text-gray-900 tracking-tight">
                        {{ $cantidadFacturas }}
                    </h3>
                </div>
                <div class="mt-4 flex items-center gap-2">
                    <span class="text-xs text-gray-400 font-medium">Ticket promedio:</span>
                    <span class="text-xs font-bold text-indigo-600">${{ number_format($ticketPromedio, 2) }}</span>
                </div>
            </div>

            <!-- Alertas de Stock -->
            <div class="bg-white p-6 rounded-2xl shadow-xs border border-gray-200/80 flex flex-col justify-between">
                <div>
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-1">Alertas de Stock</span>
                    <h3 class="text-3xl font-extrabold {{ $cantidadAlertas > 0 ? 'text-red-600' : 'text-gray-900' }} tracking-tight">
                        {{ $cantidadAlertas }}
                    </h3>
                </div>
                <div class="mt-4 flex items-center gap-2">
                    @if($cantidadAlertas > 0)
                        <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-xs font-bold bg-red-50 text-red-700 {{ $cantidadAlertas > 0 ? 'animate-pulse' : '' }}">
                            ⚠️ Crítico
                        </span>
                        <span class="text-xs text-gray-400">requiere reabastecimiento</span>
                    @else
                        <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-xs font-bold bg-green-50 text-green-700">
                            ✓ Óptimo
                        </span>
                        <span class="text-xs text-gray-400">Inventario al día</span>
                    @endif
                </div>
            </div>

            <!-- Total Productos -->
            <div class="bg-white p-6 rounded-2xl shadow-xs border border-gray-200/80 flex flex-col justify-between">
                <div>
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-1">Total Productos</span>
                    <h3 class="text-3xl font-extrabold text-gray-900 tracking-tight">
                        {{ $totalProductos }}
                    </h3>
                </div>
                <div class="mt-4 flex items-center justify-between">
                    <span class="text-xs text-gray-400">En {{ $totalCategorias }} categorías</span>
                    <a href="{{ route('productos.index') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 transition">Ver todos →</a>
                </div>
            </div>

        </div>

        <!-- Secciones Inferiores -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Tabla Alertas de Bajo Stock -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200/80 overflow-hidden lg:col-span-2">
                <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
                    <div>
                        <h2 class="font-bold text-gray-800 text-lg">⚠️ Alertas de Bajo Stock</h2>
                        <p class="text-xs text-gray-400">Productos con existencias inferiores o iguales al mínimo configurado</p>
                    </div>
                    @if($cantidadAlertas > 0)
                        <span class="bg-red-100 text-red-800 text-xs font-bold px-2.5 py-1 rounded-full">Acción Urgente</span>
                    @endif
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
                            @forelse($alertasStock as $producto)
                                <tr class="hover:bg-gray-50/40 transition">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-mono font-bold text-indigo-600">{{ $producto->code ?? $producto->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">{{ $producto->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-bold {{ $producto->current_stock == 0 ? 'bg-red-100 text-red-800' : 'bg-amber-50 text-amber-700' }}">
                                            {{ $producto->current_stock }} unidades
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium text-gray-400">{{ $producto->minimum_stock }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                        <a href="{{ route('productos.edit', $producto->id) }}" class="text-indigo-600 hover:text-indigo-900 font-bold transition">Surtir</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-sm text-gray-400">
                                        🎉 No hay alertas de stock bajo. ¡Buen trabajo!
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Métodos de Pago -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200/80 p-6 flex flex-col justify-between">
                <div>
                    <h2 class="font-bold text-gray-800 text-lg">📊 Métodos de Pago</h2>
                    <p class="text-xs text-gray-400 mb-6">Uso y distribución de transacciones de hoy</p>
                    
                    <div class="space-y-4">
                        <!-- Efectivo -->
                        <div>
                            <div class="flex justify-between text-sm font-semibold text-gray-700 mb-1">
                                <span>💵 Efectivo</span>
                                <span>{{ $porcentajesPago['efectivo'] }}%</span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-2">
                                <div class="bg-green-500 h-2 rounded-full" style="width: {{ $porcentajesPago['efectivo'] }}%"></div>
                            </div>
                        </div>

                        <!-- Transferencia -->
                        <div>
                            <div class="flex justify-between text-sm font-semibold text-gray-700 mb-1">
                                <span>🏦 Transferencia / Nequi</span>
                                <span>{{ $porcentajesPago['transferencia'] }}%</span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-2">
                                <div class="bg-indigo-500 h-2 rounded-full" style="width: {{ $porcentajesPago['transferencia'] }}%"></div>
                            </div>
                        </div>

                        <!-- Tarjeta -->
                        <div>
                            <div class="flex justify-between text-sm font-semibold text-gray-700 mb-1">
                                <span>💳 Tarjeta de Crédito/Débito</span>
                                <span>{{ $porcentajesPago['tarjeta'] }}%</span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-2">
                                <div class="bg-amber-500 h-2 rounded-full" style="width: {{ $porcentajesPago['tarjeta'] }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-6 border-t border-gray-100 mt-6">
                    <a href="{{ route('facturas.index') }}" class="w-full inline-flex justify-center items-center bg-gray-50 hover:bg-gray-100 text-gray-700 text-xs font-bold py-2.5 rounded-xl border border-gray-200/50 transition">
                        Ver Control de Caja →
                    </a>
                </div>
            </div>

        </div>

        <!-- Tabla Últimas Ventas -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200/80 overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
                <div>
                    <h2 class="font-bold text-gray-800 text-lg">🧾 Últimas Ventas Realizadas</h2>
                    <p class="text-xs text-gray-400">Listado de las transacciones procesadas recientemente en caja</p>
                </div>
                <a href="{{ route('facturas.index') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 transition">
                    Ver Historial Completo
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50/20">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Nº Factura</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Cliente</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Hora / Fecha</th>
                            <th class="px-6 py-3 text-center text-xs font-semibold text-gray-400 uppercase tracking-wider">Método</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-gray-400 uppercase tracking-wider">Monto Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @forelse($ultimasVentas as $factura)
                            <tr class="hover:bg-gray-50/40 transition">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-mono font-bold text-indigo-600">
                                    {{ $factura->numero_factura ?? '#FAC-' . str_pad($factura->id, 4, '0', STR_PAD_LEFT) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <!-- Reemplaza con las columnas reales de tu cliente -->
                                    <div class="text-sm font-semibold text-gray-900">{{ $factura->cliente_nombre ?? 'Consumidor Final' }}</div>
                                    <div class="text-xs text-gray-400">{{ $factura->cliente_documento ?? 'Sin Documento' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <!-- Muestra la hora de forma legible o la diferencia de tiempo (Ej: "hace 5 minutos") -->
                                    {{ $factura->created_at->diffForHumans() }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800 uppercase">
                                        {{ $factura->metodo_pago }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-bold text-gray-900">
                                    ${{ number_format($factura->total, 2) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-sm text-gray-400">
                                    🏪 No se han registrado ventas recientemente.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>