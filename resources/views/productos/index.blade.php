<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Agregar Nuevo Producto') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('productos.store') }}" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @csrf

                    <div>
                        <x-input-label for="codigo" :value="__('Código / Barra')" />
                        <x-text-input id="codigo" name="codigo" type="text" class="mt-1 block w-full" required />
                        <x-input-error class="mt-2" :messages="$errors->get('codigo')" />
                    </div>

                    <div>
                        <x-input-label for="nombre" :value="__('Nombre del Producto')" />
                        <x-text-input id="nombre" name="nombre" type="text" class="mt-1 block w-full" required />
                        <x-input-error class="mt-2" :messages="$errors->get('nombre')" />
                    </div>

                    <div>
                        <x-input-label for="categoria_id" :value="__('Categoría')" />
                        <select id="categoria_id" name="categoria_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 rounded-md shadow-sm" required>
                            <option value="">Seleccione una categoría</option>
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria->id }}">{{ $categoria->  nombre }}</option>
                            @endforeach
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('categoria_id')" />
                    </div>

                    <div>
                        <x-input-label for="proveedor_id" :value="__('Proveedor Principal')" />
                        <select id="proveedor_id" name="proveedor_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 rounded-md shadow-sm" required>
                            <option value="">Seleccione un proveedor</option>
                            @foreach($proveedores as $proveedor)
                                <option value="{{ $proveedor->id }}">{{ $proveedor->razon_social }}</option>
                            @endforeach
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('proveedor_id')" />
                    </div>

                    <div>
                        <x-input-label for="precio_compra" :value="__('Precio de Compra ($)')" />
                        <x-text-input id="precio_compra" name="precio_compra" type="number" step="0.01" class="mt-1 block w-full" required />
                    </div>

                    <div>
                        <x-input-label for="precio_venta" :value="__('Precio de Venta ($)')" />
                        <x-text-input id="precio_venta" name="precio_venta" type="number" step="0.01" class="mt-1 block w-full" required />
                    </div>

                    <div>
                        <x-input-label for="stock_actual" :value="__('Stock Inicial')" />
                        <x-text-input id="stock_actual" name="stock_actual" type="number" class="mt-1 block w-full" required />
                    </div>

                    <div>
                        <x-input-label for="stock_minimo" :value="__('Stock Mínimo (Alerta)')" />
                        <x-text-input id="stock_minimo" name="stock_minimo" type="number" class="mt-1 block w-full" required />
                    </div>

                    <div class="md:col-span-2">
                        <x-input-label for="descripcion" :value="__('Descripción del Producto')" />
                        <textarea id="descripcion" name="descripcion" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 rounded-md shadow-sm" rows="3"></textarea>
                    </div>

                    <div class="md:col-span-2 flex items-center justify-end space-x-2">
                        <a href="{{ route('productos.index') }}" class="text-gray-600 dark:text-gray-400 text-sm hover:underline">Cancelar</a>
                        <x-primary-button>{{ __('Guardar Producto') }}</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>