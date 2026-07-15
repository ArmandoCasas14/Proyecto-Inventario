<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Lista de Productos') }}
            </h2>
            <a href="{{ route('products.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __('+ Registrar Producto') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if (session('success'))
                <div class="mb-6 p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                    <span class="font-semibold">¡Éxito!</span> {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 overflow-x-auto">
                    
                    @if($products->isEmpty())
                        <div class="text-center py-8">
                            <p class="text-gray-500 dark:text-gray-400 text-lg">{{ __('No hay productos registrados en el sistema.') }}</p>
                        </div>
                    @else
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm text-left">
                            <thead class="bg-gray-50 dark:bg-gray-700 text-xs uppercase text-gray-700 dark:text-gray-300">
                                <tr>
                                    <th scope="col" class="px-6 py-3">{{ __('Código') }}</th>
                                    <th scope="col" class="px-6 py-3">{{ __('Nombre') }}</th>
                                    <th scope="col" class="px-6 py-3">{{ __('Categoría') }}</th>
                                    <th scope="col" class="px-6 py-3">{{ __('Proveedor') }}</th>
                                    <th scope="col" class="px-6 py-3 text-right">{{ __('P. Compra') }}</th>
                                    <th scope="col" class="px-6 py-3 text-right">{{ __('P. Venta') }}</th>
                                    <th scope="col" class="px-6 py-3 text-center">{{ __('Stock') }}</th>
                                    <th scope="col" class="px-6 py-3 text-center">{{ __('Estado') }}</th>
                                    <th scope="col" class="px-6 py-3 text-center">{{ __('Acciones') }}</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach ($products as $product)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                        <td class="px-6 py-4 font-mono font-bold text-gray-900 dark:text-white">
                                            {{ $product->code }}
                                        </td>
                                        <td class="px-6 py-4 font-medium">
                                            {{ $product->name }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $product->category->name ?? __('Sin Categoría') }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $product->supplier->name ?? __('Sin Proveedor') }}
                                        </td>
                                        <td class="px-6 py-4 text-right font-mono">
                                            ${{ number_format($product->purchase_price, 2) }}
                                        </td>
                                        <td class="px-6 py-4 text-right font-mono">
                                            ${{ number_format($product->selling_price, 2) }}
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            @if ($product->current_stock <= $product->minimum_stock)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-300" title="¡Stock crítico o menor al mínimo!">
                                                    {{ $product->current_stock }} (Mín: {{ $product->minimum_stock }})
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300">
                                                    {{ $product->current_stock }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            @if ($product->status)
                                                <span class="px-2 py-1 text-xs font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700/20 dark:text-green-400">
                                                    {{ __('Activo') }}
                                                </span>
                                            @else
                                                <span class="px-2 py-1 text-xs font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:bg-red-700/20 dark:text-red-400">
                                                    {{ __('Inactivo') }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-center space-x-2 whitespace-nowrap">
                                            <a href="{{ route('products.edit', $product) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 font-semibold text-sm">
                                                {{ __('Editar') }}
                                            </a>
                                            
                                            <span class="text-gray-300 dark:text-gray-600">|</span>

                                            <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este producto?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 font-semibold text-sm">
                                                    {{ __('Eliminar') }}
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>