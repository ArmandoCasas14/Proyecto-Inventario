<x-app-layout>
    <div class="relative min-h-[calc(100vh-4rem)] -m-4 sm:-m-6 lg:-m-8 p-4 sm:p-6 lg:p-8 bg-[#f3f7f6] dark:bg-slate-950 bg-[radial-gradient(#cbd5e1_1px,transparent_1px)] dark:bg-[radial-gradient(#1e293b_1px,transparent_1px)] [background-size:16px_16px] flex justify-center items-start">
        
        <!-- CONTENEDOR CENTRAL -->
        <div class="w-full max-w-4xl bg-white dark:bg-slate-800 rounded-3xl shadow-xl border border-slate-200/80 dark:border-slate-700/80 overflow-hidden relative z-10 my-4">
            
            <!-- BANNER ENCABEZADO SUPERIOR VERDE -->
            <div class="bg-emerald-600 dark:bg-emerald-700 px-6 py-6 sm:px-8 flex items-center justify-between gap-4">
                <div>
                    <h2 class="font-bold text-2xl text-white tracking-tight">
                        {{ __('Nuevo Producto') }}
                    </h2>
                    <p class="text-xs text-emerald-100 mt-1">
                        {{ __('Ingresa los detalles técnicos, categoría y existencias para registrar un nuevo ítem.') }}
                    </p>
                </div>
                
                <a href="{{ route('productos.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-emerald-800 hover:bg-emerald-900 text-white font-semibold text-xs rounded-xl transition-all shadow-sm gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    {{ __('Volver') }}
                </a>
            </div>

            <!-- FORMULARIO -->
            <div class="p-6 sm:p-8">
                <form method="POST" action="{{ route('productos.store') }}" class="space-y-6">
                    @csrf

                    <!-- Código y Nombre -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="code" :value="__('Código / SKU')" class="text-xs font-bold uppercase text-slate-500 dark:text-slate-400" />
                            <x-text-input id="code" name="code" type="text" class="mt-1.5 block w-full text-xs rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200 focus:border-emerald-500 focus:ring-emerald-500 py-2.5"
                                          :value="old('code')" required autofocus placeholder="Ej: PRD-001" />
                            <x-input-error :messages="$errors->get('code')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="name" :value="__('Nombre del Producto')" class="text-xs font-bold uppercase text-slate-500 dark:text-slate-400" />
                            <x-text-input id="name" name="name" type="text" class="mt-1.5 block w-full text-xs rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200 focus:border-emerald-500 focus:ring-emerald-500 py-2.5"
                                          :value="old('name')" required placeholder="Ej: Carne Molida Especial 500g" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Descripción -->
                    <div>
                        <x-input-label for="description" :value="__('Descripción')" class="text-xs font-bold uppercase text-slate-500 dark:text-slate-400" />
                        <textarea id="description" name="description" rows="3"
                                  placeholder="Detalles adicionales del producto..."
                                  class="mt-1.5 block w-full text-xs rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm">{{ old('description') }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <!-- Categoría y Proveedor -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="category_id" :value="__('Categoría')" class="text-xs font-bold uppercase text-slate-500 dark:text-slate-400" />
                            <select id="category_id" name="category_id" required
                                    class="mt-1.5 block w-full text-xs rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200 focus:border-emerald-500 focus:ring-emerald-500 py-2.5">
                                <option value="">{{ __('Selecciona una categoría') }}</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="supplier_id" :value="__('Proveedor')" class="text-xs font-bold uppercase text-slate-500 dark:text-slate-400" />
                            <select id="supplier_id" name="supplier_id" required
                                    class="mt-1.5 block w-full text-xs rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200 focus:border-emerald-500 focus:ring-emerald-500 py-2.5">
                                <option value="">{{ __('Selecciona un proveedor') }}</option>
                                @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}" @selected(old('supplier_id') == $supplier->id)>
                                        {{ $supplier->legal_name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('supplier_id')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Precios -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="purchase_price" :value="__('Precio de Compra ($)')" class="text-xs font-bold uppercase text-slate-500 dark:text-slate-400" />
                            <x-text-input id="purchase_price" name="purchase_price" type="number" step="0.01" min="0"
                                          class="mt-1.5 block w-full text-xs font-mono rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200 focus:border-emerald-500 focus:ring-emerald-500 py-2.5" 
                                          :value="old('purchase_price')" required placeholder="0.00" />
                            <x-input-error :messages="$errors->get('purchase_price')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="selling_price" :value="__('Precio de Venta ($)')" class="text-xs font-bold uppercase text-slate-500 dark:text-slate-400" />
                            <x-text-input id="selling_price" name="selling_price" type="number" step="0.01" min="0"
                                          class="mt-1.5 block w-full text-xs font-mono rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200 focus:border-emerald-500 focus:ring-emerald-500 py-2.5" 
                                          :value="old('selling_price')" required placeholder="0.00" />
                            <x-input-error :messages="$errors->get('selling_price')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Stocks -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="current_stock" :value="__('Stock Inicial')" class="text-xs font-bold uppercase text-slate-500 dark:text-slate-400" />
                            <x-text-input id="current_stock" name="current_stock" type="number" min="0"
                                          class="mt-1.5 block w-full text-xs font-mono rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200 focus:border-emerald-500 focus:ring-emerald-500 py-2.5" 
                                          :value="old('current_stock', 0)" required />
                            <x-input-error :messages="$errors->get('current_stock')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="minimum_stock" :value="__('Stock Mínimo')" class="text-xs font-bold uppercase text-slate-500 dark:text-slate-400" />
                            <x-text-input id="minimum_stock" name="minimum_stock" type="number" min="0"
                                          class="mt-1.5 block w-full text-xs font-mono rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200 focus:border-emerald-500 focus:ring-emerald-500 py-2.5" 
                                          :value="old('minimum_stock', 0)" required />
                            <x-input-error :messages="$errors->get('minimum_stock')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Botones -->
                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-200/60 dark:border-slate-700/60">
                        <a href="{{ route('productos.index') }}"
                           class="px-5 py-2.5 bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-200 font-bold text-xs uppercase tracking-wider rounded-xl hover:bg-slate-300 dark:hover:bg-slate-600 transition-colors">
                            {{ __('Cancelar') }}
                        </a>
                        <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs uppercase tracking-wider rounded-xl transition-all shadow-sm">
                            {{ __('Guardar Producto') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>