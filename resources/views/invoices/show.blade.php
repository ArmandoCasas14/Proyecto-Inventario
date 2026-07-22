<x-app-layout>
    <!-- Fondo General Punteado -->
    <div class="relative min-h-screen bg-slate-100/70 -m-4 sm:-m-6 lg:-m-8 p-4 sm:p-6 lg:p-8 overflow-hidden flex justify-center items-center">
        
        <!-- Textura Punteada de Fondo (No imprimible) -->
        <div class="absolute inset-0 opacity-15 bg-[radial-gradient(#059669_1px,transparent_1px)] [background-size:16px_16px] pointer-events-none no-print"></div>

        <!-- CONTENEDOR CENTRAL UNIFICADO -->
        <div class="w-full max-w-4xl bg-white rounded-3xl shadow-xl border border-slate-200/80 overflow-hidden relative z-10 my-auto print-card">
            
            <!-- 1. CABECERA VERDE INTEGRADA -->
            <div class="bg-emerald-600 px-6 py-6 md:px-8 text-white flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 print-header">
                <div>
                    <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight">Detalle de Factura #{{ $invoice->id }}</h1>
                    <p class="text-emerald-100 text-xs md:text-sm mt-1">Comprobante electrónico de venta interna</p>
                </div>
                <!-- Botones de Acción (Se ocultan en impresión) -->
                <div class="flex items-center gap-2 no-print">
                    <a href="{{ route('facturas.index') }}" 
                       class="inline-flex items-center justify-center bg-emerald-700 hover:bg-emerald-800 text-white font-semibold px-3.5 py-2 rounded-xl text-xs shadow-xs transition gap-1.5 border border-emerald-500/50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Volver
                    </a>
                    <button onclick="window.print()" 
                            class="inline-flex items-center justify-center bg-slate-900 hover:bg-slate-800 text-white font-bold px-4 py-2 rounded-xl text-xs shadow-md transition gap-2 cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                        </svg>
                        Imprimir
                    </button>
                </div>
            </div>

            <!-- Alerta de Éxito si aplica -->
            @if(session('success'))
                <div class="m-6 md:m-8 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl flex items-center gap-3 text-sm font-medium shadow-2xs no-print">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <div class="p-6 md:p-8 space-y-8">

                <!-- 2. DATOS DE LA EMPRESA Y FECHA -->
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center pb-6 border-b border-slate-100 gap-4">
                    <div>
                        <span class="text-xs font-black tracking-wider text-emerald-600 uppercase">Sistema de Inventario</span>
                        <h2 class="text-2xl font-black text-slate-800 tracking-tight">STOCK MASTER</h2>
                    </div>
                    <div class="sm:text-right bg-slate-50 px-4 py-2.5 rounded-2xl border border-slate-200/60 w-full sm:w-auto">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-400 block mb-0.5">Fecha de Emisión</span>
                        <p class="text-sm font-bold text-slate-800 font-mono">{{ $invoice->created_at->format('d/m/Y h:i A') }}</p>
                    </div>
                </div>

                <!-- 3. INFORMACIÓN DEL CLIENTE Y MÉTODO DE PAGO -->
                <div class="bg-slate-50/80 border border-slate-200/80 rounded-2xl p-5 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-400 block mb-1">Cliente / Razón Social</span>
                        <p class="text-base font-bold text-slate-800">{{ $invoice->customer_name }}</p>
                    </div>
                    <div class="md:text-right">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-400 block mb-1">Método de Pago</span>
                        <span class="inline-flex items-center px-3 py-1 rounded-xl text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-200/80">
                            {{ $invoice->payment_type }}
                        </span>
                    </div>
                </div>

                <!-- 4. TABLA DE ARTÍCULOS -->
                <div class="overflow-x-auto rounded-2xl border border-slate-100">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-slate-100/70 text-slate-500 text-xs font-bold uppercase tracking-wider">
                            <tr>
                                <th scope="col" class="px-6 py-3.5">Descripción Artículo</th>
                                <th scope="col" class="px-6 py-3.5 text-center" style="width: 100px;">Cantidad</th>
                                <th scope="col" class="px-6 py-3.5 text-right" style="width: 140px;">Precio Unit.</th>
                                <th scope="col" class="px-6 py-3.5 text-right" style="width: 140px;">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white">
                            @foreach($invoice->items as $item)
                                <tr class="hover:bg-slate-50/50 transition">
                                    <td class="px-6 py-4 font-semibold text-slate-800">
                                        {{ $item->product->name }}
                                        @if($item->product->trashed())
                                            <span class="text-xs text-rose-500 font-normal italic ml-1">(Eliminado del catálogo)</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center font-mono font-bold text-slate-700">
                                        {{ $item->quantity }}
                                    </td>
                                    <td class="px-6 py-4 text-right font-mono text-slate-600">
                                        ${{ number_format($item->unit_price, 2) }}
                                    </td>
                                    <td class="px-6 py-4 text-right font-mono font-bold text-slate-900">
                                        ${{ number_format($item->quantity * $item->unit_price, 2) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- 5. CIERRE Y TOTALES -->
                <div class="pt-2 flex justify-end">
                    <div class="w-full md:w-72 space-y-2 bg-slate-50/80 p-5 rounded-2xl border border-slate-200/80">
                        <div class="flex justify-between text-sm text-slate-500 font-medium">
                            <span>Subtotal:</span>
                            <span class="font-mono text-slate-700">${{ number_format($invoice->total, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-sm text-slate-500 font-medium">
                            <span>Impuestos (0%):</span>
                            <span class="font-mono text-slate-700">$0.00</span>
                        </div>
                        <div class="pt-3 border-t border-slate-200 flex justify-between items-center text-lg font-black text-slate-900">
                            <span>Total Neto:</span>
                            <span class="text-emerald-600 font-mono text-xl">${{ number_format($invoice->total, 2) }}</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- ESTILOS EXCLUSIVOS PARA IMPRESIÓN IMPRESCINDIBLES -->
    <style>
        @media print {
            /* Ocultar elementos no imprimibles */
            nav, .no-print, button, a {
                display: none !important;
            }
            body {
                background-color: white !important;
                color: black !important;
            }
            .print-card {
                box-shadow: none !important;
                border: 1px solid #cbd5e1 !important;
                margin: 0 auto !important;
                width: 100% !important;
                max-width: 100% !important;
                border-radius: 0 !important;
            }
            .print-header {
                background-color: #059669 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
                color: white !important;
            }
        }
    </style>
</x-app-layout>