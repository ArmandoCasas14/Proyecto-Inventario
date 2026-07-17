<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Historial de Ventas y Facturación') }}
            </h2>
            <a href="{{ route('facturas.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                + Crear Nueva Venta
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">Nº Factura</th>
                                <th scope="col" class="px-6 py-3">Fecha y Hora</th>
                                <th scope="col" class="px-6 py-3">Cliente</th>
                                <th scope="col" class="px-6 py-3">Método Pago</th>
                                <th scope="col" class="px-6 py-3 text-right">Total Cobrado</th>
                                <th scope="col" class="px-6 py-3 text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($invoices as $invoice)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="px-6 py-4 font-mono font-bold text-indigo-600 dark:text-indigo-400">#{{ $invoice->id }}</td>
                                <td class="px-6 py-4">{{ $invoice->created_at->format('d/m/Y H:i') }}</td>
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $invoice->customer_name }}</td>
                                <td class="px-6 py-4">{{ $invoice->payment_type }}</td>
                                <td class="px-6 py-4 text-right font-bold font-mono">${{ number_format($invoice->total, 2) }}</td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('facturas.show', $invoice->id) }}" class="text-indigo-600 dark:text-indigo-400 hover:underline font-semibold">Ver Recibo ➔</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $invoices->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>