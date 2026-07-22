<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Registrar Ajuste Manual de Bodega') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative shadow">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('movimientos.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Producto -->
                        <div>
                            <label for="product_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Seleccionar Producto</label>
                            <select name="product_id" id="product_id" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" required>
                                <option value="">-- Seleccione un producto --</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                        {{ $product->name }} (Stock actual: {{ $product->current_stock }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('product_id')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Tipo de Movimiento -->
                            <div>
                                <label for="movement_type_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tipo de Movimiento</label>
                                <select name="movement_type_id" id="movement_type_id" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" required>
                                    <option value="">-- Seleccione el motivo --</option>
                                    @foreach($movementTypes as $type)
                                        <option value="{{ $type->id }}" {{ old('movement_type_id') == $type->id ? 'selected' : '' }}>
                                            {{ $type->name }} ({{ strtoupper($type->type) }})
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('movement_type_id')" class="mt-2" />
                            </div>

                            <!-- Cantidad -->
                            <div>
                                <label for="quantity" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Cantidad</label>
                                <input type="number" name="quantity" id="quantity" min="1" value="{{ old('quantity') }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" required>
                                <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Precio de referencia (Opcional) -->
                        <div>
                            <label for="unit_price" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Precio unitario referencial (Opcional)</label>
                            <input type="number" name="unit_price" id="unit_price" step="0.01" min="0" value="{{ old('unit_price') }}" placeholder="Dejar vacío para usar precio actual" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                            <span class="text-xs text-gray-400">Si no se especifica, el sistema asignará el valor de venta base del producto.</span>
                        </div>

                        <!-- Observaciones -->
                        <div>
                            <label for="observation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Justificación u Observación</label>
                            <textarea name="observation" id="observation" rows="3" placeholder="Ej: Pérdida por daño de empaque, ingreso por compra a proveedor, etc." class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">{{ old('observation') }}</textarea>
                            <x-input-error :messages="$errors->get('observation')" class="mt-2" />
                        </div>

                        <!-- Botones -->
                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('movimientos.index') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-750 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                Cancelar
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-950 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Guardar Movimiento
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>