<x-app-layout>
    <div class="relative min-h-[calc(100vh-4rem)] -m-4 sm:-m-6 lg:-m-8 p-4 sm:p-6 lg:p-8 bg-[#f3f7f6] dark:bg-slate-950 bg-[radial-gradient(#cbd5e1_1px,transparent_1px)] dark:bg-[radial-gradient(#1e293b_1px,transparent_1px)] [background-size:16px_16px] flex justify-center items-start">
        
        <!-- CONTENEDOR CENTRAL -->
        <div class="w-full max-w-3xl bg-white dark:bg-slate-800 rounded-3xl shadow-xl border border-slate-200/80 dark:border-slate-700/80 overflow-hidden relative z-10 my-4">
            
            <!-- BANNER ENCABEZADO SUPERIOR VERDE -->
            <div class="bg-emerald-600 dark:bg-emerald-700 px-6 py-6 sm:px-8 flex items-center justify-between gap-4">
                <div>
                    <h2 class="font-bold text-2xl text-white tracking-tight">
                        {{ __('Registrar Ajuste Manual de Bodega') }}
                    </h2>
                    <p class="text-xs text-emerald-100 mt-1">
                        {{ __('Ingresa entradas o salidas manuales para actualizar existencias de producto.') }}
                    </p>
                </div>

                <a href="{{ route('movimientos.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-emerald-800 hover:bg-emerald-900 text-white font-semibold text-xs rounded-xl transition-all shadow-sm gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    {{ __('Volver') }}
                </a>
            </div>

            <!-- FORMULARIO -->
            <div class="p-6 sm:p-8">

                @if(session('error'))
                    <div class="mb-6 p-4 rounded-2xl bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-800/60 text-rose-800 dark:text-rose-300 text-xs font-medium flex items-center gap-2 shadow-sm">
                        <svg class="w-5 h-5 text-rose-600 dark:text-rose-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                <form action="{{ route('movimientos.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Producto -->
                    <div>
                        <x-input-label for="product_id" :value="__('Seleccionar Producto')" class="text-xs font-bold uppercase text-slate-500 dark:text-slate-400" />
                        <select name="product_id" id="product_id" required 
                                class="mt-1.5 block w-full text-xs rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200 focus:border-emerald-500 focus:ring-emerald-500 py-2.5 shadow-sm">
                            <option value="">{{ __('Seleccione un producto') }}</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                    {{ $product->name }} — Stock Actual: {{ $product->current_stock }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('product_id')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Tipo de Movimiento -->
                        <div>
                            <x-input-label for="movement_type_id" :value="__('Tipo de Movimiento')" class="text-xs font-bold uppercase text-slate-500 dark:text-slate-400" />
                            <select name="movement_type_id" id="movement_type_id" required 
                                    class="mt-1.5 block w-full text-xs rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200 focus:border-emerald-500 focus:ring-emerald-500 py-2.5 shadow-sm">
                                <option value="">{{ __('Seleccione el motivo') }}</option>
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
                            <x-input-label for="quantity" :value="__('Cantidad')" class="text-xs font-bold uppercase text-slate-500 dark:text-slate-400" />
                            <x-text-input type="number" name="quantity" id="quantity" min="1" :value="old('quantity')" required 
                                          class="mt-1.5 block w-full text-xs rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200 focus:border-emerald-500 focus:ring-emerald-500 py-2.5" />
                            <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Precio de referencia (Opcional) -->
                    <div>
                        <x-input-label for="unit_price" :value="__('Precio Unitario Referencial (Opcional)')" class="text-xs font-bold uppercase text-slate-500 dark:text-slate-400" />
                        <x-text-input type="number" name="unit_price" id="unit_price" step="0.01" min="0" :value="old('unit_price')" placeholder="Dejar vacío para usar precio base" 
                                      class="mt-1.5 block w-full text-xs rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200 focus:border-emerald-500 focus:ring-emerald-500 py-2.5" />
                        <p class="text-[11px] text-slate-400 dark:text-slate-500 mt-1">
                            {{ __('Si no se especifica, el sistema asignará el valor de venta base configurado en el producto.') }}
                        </p>
                    </div>

                    <!-- Observaciones -->
                    <div>
                        <x-input-label for="observation" :value="__('Justificación u Observación')" class="text-xs font-bold uppercase text-slate-500 dark:text-slate-400" />
                        <textarea name="observation" id="observation" rows="3" placeholder="Ej: Pérdida por daño de empaque, ingreso por compra a proveedor, etc." 
                                  class="mt-1.5 block w-full text-xs rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200 focus:border-emerald-500 focus:ring-emerald-500 p-3 shadow-sm">{{ old('observation') }}</textarea>
                        <x-input-error :messages="$errors->get('observation')" class="mt-2" />
                    </div>

                    <!-- BOTONES -->
                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-200/60 dark:border-slate-700/60">
                        <a href="{{ route('movimientos.index') }}"
                           class="px-5 py-2.5 bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-200 font-bold text-xs uppercase tracking-wider rounded-xl hover:bg-slate-300 dark:hover:bg-slate-600 transition-colors">
                            {{ __('Cancelar') }}
                        </a>
                        <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs uppercase tracking-wider rounded-xl transition-all shadow-sm">
                            {{ __('Guardar Movimiento') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>