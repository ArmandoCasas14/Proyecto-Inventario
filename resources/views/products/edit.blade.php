<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar Producto') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 p-6 shadow-sm sm:rounded-lg">
                <form method="POST" action="{{ route('productos.update', $product) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="code" :value="__('Código')" />
                            <x-text-input id="code" name="code" type="text" class="mt-1 block w-full"
                                          :value="old('code', $product->code)" required autofocus />
                            <x-input-error :messages="$errors->get('code')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="name" :value="__('Nombre')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                                          :value="old('name', $product->name)" required />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                    </div>

                    <div>
                        <x-input-label for="description" :value="__('Descripción')" />
                        <textarea id="description" name="description" rows="3"
                                  class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('description', $product->description) }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="category_id" :value="__('Categoría')" />
                            <select id="category_id" name="category_id" required
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id) == $category->id)>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="supplier_id" :value="__('Proveedor')" />
                            <select id="supplier_id" name="supplier_id" required
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}" @selected(old('supplier_id', $product->supplier_id) == $supplier->id)>
                                        {{ $supplier->legal_name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('supplier_id')" class="mt-2" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="purchase_price" :value="__('Precio de Compra')" />
                            <x-text-input id="purchase_price" name="purchase_price" type="number" step="0.01" min="0"
                                          class="mt-1 block w-full" :value="old('purchase_price', $product->purchase_price)" required />
                            <x-input-error :messages="$errors->get('purchase_price')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="selling_price" :value="__('Precio de Venta')" />
                            <x-text-input id="selling_price" name="selling_price" type="number" step="0.01" min="0"
                                          class="mt-1 block w-full" :value="old('selling_price', $product->selling_price)" required />
                            <x-input-error :messages="$errors->get('selling_price')" class="mt-2" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="current_stock" :value="__('Stock Actual')" />
                            <x-text-input id="current_stock" name="current_stock" type="number" min="0"
                                          class="mt-1 block w-full" :value="old('current_stock', $product->current_stock)" required />
                            <x-input-error :messages="$errors->get('current_stock')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="minimum_stock" :value="__('Stock Mínimo')" />
                            <x-text-input id="minimum_stock" name="minimum_stock" type="number" min="0"
                                          class="mt-1 block w-full" :value="old('minimum_stock', $product->minimum_stock)" required />
                            <x-input-error :messages="$errors->get('minimum_stock')" class="mt-2" />
                        </div>
                    </div>

                    <div>
                        <x-input-label for="status" :value="__('Estado')" />
                        <select id="status" name="status" required
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="1" @selected(old('status', $product->status) == 1)>{{ __('Activo') }}</option>
                            <option value="0" @selected(old('status', $product->status) == 0)>{{ __('Inactivo') }}</option>
                        </select>
                        <x-input-error :messages="$errors->get('status')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end gap-3">
                        <a href="{{ route('productos.index') }}"
                           class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-50 dark:hover:bg-gray-600 transition ease-in-out duration-150">
                            {{ __('Cancelar') }}
                        </a>
                        <x-primary-button>{{ __('Actualizar Producto') }}</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>