<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Registrar Nuevo Producto') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <form method="POST" action="{{ route('products.store') }}" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="code" :value="__('Código del Producto')" />
                            <x-text-input id="code" name="code" type="text" class="mt-1 block w-full" 
                                value="{{ old('code') }}" required autofocus placeholder="Ej: PROD-1002" />
                            <x-input-error class="mt-2" :messages="$errors->get('code')" />
                        </div>

                        <div>
                            <x-input-label for="name" :value="__('Nombre del Producto')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" 
                                value="{{ old('name') }}" required placeholder="Ej: Laptop Dell Inspiron" />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>
                    </div>

                    <div>
                        <x-input-label for="description" :value="__('Descripción')" />
                        <textarea id="description" name="description" 
                            class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" 
                            rows="3" placeholder="Detalles o especificaciones del producto...">{{ old('description') }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('description')" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="category_id" :value="__('Categoría')" />
                            <select id="category_id" name="category_id" required
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                <option value="" disabled selected>{{ __('Seleccione una categoría') }}</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('category_id')" />
                        </div>

                        <div>
                            <x-input-label for="supplier_id" :value="__('Proveedor')" />
                            <select id="supplier_id" name="supplier_id" required
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                <option value="" disabled selected>{{ __('Seleccione un proveedor') }}</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                        {{ $supplier->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('supplier_id')" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="purchase_price" :value="__('Precio de Compra ($)')" />
                            <x-text-input id="purchase_price" name="purchase_price" type="number" step="0.01" class="mt-1 block w-full" 
                                value="{{ old('purchase_price') }}" required placeholder="0.00" />
                            <x-input-error class="mt-2" :messages="$errors->get('purchase_price')" />
                        </div>

                        <div>
                            <x-input-label for="selling_price" :value="__('Precio de Venta ($)')" />
                            <x-text-input id="selling_price" name="selling_price" type="number" step="0.01" class="mt-1 block w-full" 
                                value="{{ old('selling_price') }}" required placeholder="0.00" />
                            <x-input-error class="mt-2" :messages="$errors->get('selling_price')" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <x-input-label for="current_stock" :value="__('Stock Actual')" />
                            <x-text-input id="current_stock" name="current_stock" type="number" class="mt-1 block w-full" 
                                value="{{ old('current_stock') }}" required placeholder="0" />
                            <x-input-error class="mt-2" :messages="$errors->get('current_stock')" />
                        </div>

                        <div>
                            <x-input-label for="minimum_stock" :value="__('Stock Mínimo')" />
                            <x-text-input id="minimum_stock" name="minimum_stock" type="number" class="mt-1 block w-full" 
                                value="{{ old('minimum_stock', 5) }}" required placeholder="5" />
                            <x-input-error class="mt-2" :messages="$errors->get('minimum_stock')" />
                        </div>

                        <div>
                            <x-input-label for="status" :value="__('Estado')" />
                            <select id="status" name="status" required
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                <option value="1" {{ old('status', '1') == '1' ? 'selected' : '' }}>{{ __('Activo') }}</option>
                                <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>{{ __('Inactivo') }}</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('status')" />
                        </div>
                    </div>

                    <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-100 dark:border-gray-700">
                        <a href="{{ route('products.index') }}" class="text-gray-600 dark:text-gray-400 text-sm hover:underline">
                            {{ __('Cancelar') }}
                        </a>
                        <x-primary-button>
                            {{ __('Registrar Producto') }}
                        </x-primary-button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>