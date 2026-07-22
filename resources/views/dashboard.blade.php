<x-app-layout>
    <!-- Contenedor Principal con Fondo Esmeralda Sutil + Patrón Punteado -->
    <div class="relative min-h-screen bg-slate-50/80 -m-4 sm:-m-6 lg:-m-8 p-4 sm:p-6 lg:p-8 overflow-hidden">
        
        <!-- Fondo Decorativo Punteado (Mismo del Login) -->
        <div class="absolute inset-0 opacity-15 bg-[radial-gradient(#059669_1px,transparent_1px)] [background-size:16px_16px] pointer-events-none"></div>

        <div class="max-w-7xl mx-auto space-y-8 relative z-10">

            <!-- Encabezado -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Dashboard General</h1>
                    <p class="text-sm text-slate-500 mt-1">Resumen analítico de operaciones, rendimiento mensual y hábitos de consumo</p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('facturas.create') }}" 
                       class="inline-flex items-center justify-center bg-emerald-600 hover:bg-emerald-700 text-white font-semibold px-5 py-2.5 rounded-xl shadow-md shadow-emerald-600/20 hover:shadow-lg transition duration-150 gap-2 text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                        Registrar Nueva Venta
                    </a>
                </div>
            </div>

            <!-- Tarjetas Estadísticas Principales (KPIs) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                
                <!-- Ventas de Hoy -->
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-emerald-100/80 flex flex-col justify-between hover:shadow-md transition">
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Ventas de Hoy</span>
                            <div class="p-2 bg-emerald-50 text-emerald-600 rounded-xl">
                                💵
                            </div>
                        </div>
                        <h3 class="text-3xl font-extrabold text-slate-900 tracking-tight">
                            ${{ number_format($ventasHoy, 2) }}
                        </h3>
                    </div>
                    <div class="mt-4 flex items-center gap-2">
                        @if(($porcentajeVariacion ?? 0) >= 0)
                            <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                ↑ {{ round($porcentajeVariacion ?? 0) }}%
                            </span>
                        @else
                            <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-100">
                                ↓ {{ abs(round($porcentajeVariacion ?? 0)) }}%
                            </span>
                        @endif
                        <span class="text-xs text-slate-400">vs. ayer</span>
                    </div>
                </div>

                <!-- Ventas del Mes Acumuladas -->
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-emerald-100/80 flex flex-col justify-between hover:shadow-md transition">
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Ventas del Mes</span>
                            <div class="p-2 bg-emerald-50 text-emerald-600 rounded-xl">
                                📈
                            </div>
                        </div>
                        <h3 class="text-3xl font-extrabold text-emerald-600 tracking-tight">
                            ${{ number_format($ventasMes ?? 0, 2) }}
                        </h3>
                    </div>
                    <div class="mt-4 flex items-center gap-2">
                        <span class="text-xs text-slate-400 font-medium">Transacciones:</span>
                        <span class="text-xs font-bold text-slate-800 bg-slate-100 px-2 py-0.5 rounded-md">{{ $cantidadFacturasMes ?? $cantidadFacturas }}</span>
                    </div>
                </div>

                <!-- Ticket Promedio -->
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-emerald-100/80 flex flex-col justify-between hover:shadow-md transition">
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Ticket Promedio</span>
                            <div class="p-2 bg-emerald-50 text-emerald-600 rounded-xl">
                                🧾
                            </div>
                        </div>
                        <h3 class="text-3xl font-extrabold text-slate-900 tracking-tight">
                            ${{ number_format($ticketPromedio, 2) }}
                        </h3>
                    </div>
                    <div class="mt-4 flex items-center gap-2">
                        <span class="text-xs text-slate-400">Por factura emitida</span>
                    </div>
                </div>

                <!-- Total Catálogo -->
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-emerald-100/80 flex flex-col justify-between hover:shadow-md transition">
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Catálogo Activo</span>
                            <div class="p-2 bg-emerald-50 text-emerald-600 rounded-xl">
                                📦
                            </div>
                        </div>
                        <h3 class="text-3xl font-extrabold text-slate-900 tracking-tight">
                            {{ $totalProductos }}
                        </h3>
                    </div>
                    <div class="mt-4 flex items-center justify-between">
                        <span class="text-xs text-slate-400">En {{ $totalCategorias }} categorías</span>
                        <a href="{{ route('productos.index') }}" class="text-xs font-bold text-emerald-700 hover:text-emerald-800 transition hover:underline">Ver productos →</a>
                    </div>
                </div>

            </div>

            <!-- Sección de Gráficos Analíticos -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Gráfico 1: Ventas Diarias del Mes (Ocupa 2 Columnas) -->
                <div class="bg-white rounded-3xl shadow-sm border border-emerald-100/80 p-6 lg:col-span-2 flex flex-col justify-between">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h2 class="font-bold text-slate-800 text-lg flex items-center gap-2">
                                📊 Ventas Diarias del Mes
                            </h2>
                            <p class="text-xs text-slate-400">Comportamiento diario de los ingresos acumulados en el mes en curso</p>
                        </div>
                        <span class="text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-100 px-3 py-1 rounded-xl uppercase">
                            {{ now()->isoFormat('MMMM YYYY') }}
                        </span>
                    </div>
                    
                    <div class="relative w-full h-72">
                        <canvas id="chartVentasDiarias"></canvas>
                    </div>
                </div>

                <!-- Distribución Métodos de Pago (Ocupa 1 Columna) -->
                <div class="bg-white rounded-3xl shadow-sm border border-emerald-100/80 p-6 flex flex-col justify-between">
                    <div>
                        <h2 class="font-bold text-slate-800 text-lg">💳 Métodos de Pago</h2>
                        <p class="text-xs text-slate-400 mb-6">Uso y distribución de transacciones registradas</p>
                        
                        <div class="space-y-5">
                            <!-- Efectivo -->
                            <div>
                                <div class="flex justify-between text-sm font-semibold text-slate-700 mb-1.5">
                                    <span class="flex items-center gap-1.5">💵 Efectivo</span>
                                    <span class="text-emerald-700 font-bold">{{ $porcentajesPago['efectivo'] ?? 0 }}%</span>
                                </div>
                                <div class="w-full bg-slate-100 rounded-full h-2.5">
                                    <div class="bg-emerald-600 h-2.5 rounded-full" style="width: {{ $porcentajesPago['efectivo'] ?? 0 }}%"></div>
                                </div>
                            </div>

                            <!-- Transferencia -->
                            <div>
                                <div class="flex justify-between text-sm font-semibold text-slate-700 mb-1.5">
                                    <span class="flex items-center gap-1.5">🏦 Transferencia / Nequi</span>
                                    <span class="text-teal-700 font-bold">{{ $porcentajesPago['transferencia'] ?? 0 }}%</span>
                                </div>
                                <div class="w-full bg-slate-100 rounded-full h-2.5">
                                    <div class="bg-teal-500 h-2.5 rounded-full" style="width: {{ $porcentajesPago['transferencia'] ?? 0 }}%"></div>
                                </div>
                            </div>

                            <!-- Tarjeta -->
                            <div>
                                <div class="flex justify-between text-sm font-semibold text-slate-700 mb-1.5">
                                    <span class="flex items-center gap-1.5">💳 Tarjetas</span>
                                    <span class="text-amber-700 font-bold">{{ $porcentajesPago['tarjeta'] ?? 0 }}%</span>
                                </div>
                                <div class="w-full bg-slate-100 rounded-full h-2.5">
                                    <div class="bg-amber-500 h-2.5 rounded-full" style="width: {{ $porcentajesPago['tarjeta'] ?? 0 }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-6 border-t border-slate-100 mt-6">
                        <a href="{{ route('facturas.index') }}" class="w-full inline-flex justify-center items-center bg-slate-50 hover:bg-slate-100 text-slate-700 text-xs font-bold py-3 rounded-xl border border-slate-200/80 transition">
                            Ver Historial Completo →
                        </a>
                    </div>
                </div>

            </div>

            <!-- Tabla Últimas Ventas Realizadas -->
            <div class="bg-white rounded-3xl shadow-sm border border-emerald-100/80 overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                    <div>
                        <h2 class="font-bold text-slate-800 text-lg">🧾 Últimas Ventas Realizadas</h2>
                        <p class="text-xs text-slate-400">Listado de transacciones procesadas recientemente</p>
                    </div>
                    <a href="{{ route('facturas.index') }}" class="text-xs font-bold text-emerald-700 hover:text-emerald-800 transition hover:underline">
                        Ver Historial Completo
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100">
                        <thead class="bg-slate-50/50">
                            <tr>
                                <th class="px-6 py-3.5 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Nº Factura</th>
                                <th class="px-6 py-3.5 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Cliente</th>
                                <th class="px-6 py-3.5 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Fecha / Hora</th>
                                <th class="px-6 py-3.5 text-center text-xs font-semibold text-slate-400 uppercase tracking-wider">Método</th>
                                <th class="px-6 py-3.5 text-right text-xs font-semibold text-slate-400 uppercase tracking-wider">Monto Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white">
                            @forelse($ultimasVentas as $factura)
                                <tr class="hover:bg-emerald-50/30 transition">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-mono font-bold text-emerald-700">
                                        {{ $factura->numero_factura ?? '#' . str_pad($factura->id, STR_PAD_LEFT) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-semibold text-slate-900">{{ $factura->customer_name ?? 'Consumidor Final' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                                        {{ $factura->created_at->diffForHumans() }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-100/80 text-emerald-800 uppercase">
                                            {{ $factura->payment_type }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-bold text-slate-900">
                                        ${{ number_format($factura->total, 2) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-sm text-slate-400">
                                        🏪 No se han registrado ventas recientemente.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <!-- Script de Chart.js con colores Esmeralda -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const ctx = document.getElementById('chartVentasDiarias').getContext('2d');
            
            const labelsDias = @json($graficoVentas['labels'] ?? []);
            const dataVentas = @json($graficoVentas['valores'] ?? []);

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labelsDias,
                    datasets: [{
                        label: 'Ventas ($)',
                        data: dataVentas,
                        backgroundColor: '#059669', // Emerald-600
                        hoverBackgroundColor: '#047857', // Emerald-700
                        borderRadius: 8,
                        borderSkipped: false,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#0f172a',
                            padding: 12,
                            cornerRadius: 10,
                            callbacks: {
                                label: function(context) {
                                    return ' Total: $' + context.raw.toLocaleString();
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: { font: { size: 11 }, color: '#94a3b8' }
                        },
                        y: {
                            grid: { color: '#f1f5f9' },
                            ticks: {
                                font: { size: 11 },
                                color: '#94a3b8',
                                callback: function(value) {
                                    return '$' + value;
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>