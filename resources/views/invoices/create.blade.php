<x-app-layout>
    <div class="py-10" x-data="invoicePOS({{ $products->toJson() }})">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <template x-if="message">
                <div class="mb-6 p-4 bg-emerald-50 dark:bg-emerald-950/30 border-l-4 border-emerald-500 rounded-r-xl flex items-center justify-between shadow-xs">
                    <span class="text-sm font-semibold text-emerald-800 dark:text-emerald-300" x-text="message"></span>
                    <button @click="message = ''" class="text-emerald-500 hover:text-emerald-700 font-bold">×</button>
                </div>
            </template>

            <form action="{{ route('invoices.store') }}" method="POST">
                @csrf
                
                <template x-for="(item, index) in cart" :key="item.product_id">
                    <div>
                        <input type="hidden" :name="'items['+index+'][product_id]'" :value="item.product_id">
                        <input type="hidden" :name="'items['+index+'][quantity]'" :value="item.quantity">
                        <input type="hidden" :name="'items['+index+'][unit_price]'" :value="item.unit_price">
                    </div>
                </template>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    <div class="space-y-6">
                        
                        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-150 dark:border-gray-700 shadow-sm">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                                <span>👤</span> Datos del Cliente
                            </h3>

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Nombre Completo</label>
                                    <input type="text" name="customer_name" required placeholder="Consumidor Final"
                                           class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 shadow-xs">
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Método de Pago</label>
                                    <select name="payment_type" required
                                            class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 shadow-xs">
                                        <option value="Efectivo">💵 Efectivo</option>
                                        <option value="Tarjeta">💳 Tarjeta</option>
                                        <option value="Transferencia">📱 Transferencia bancaria</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-150 dark:border-gray-700 shadow-sm">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                                <span>🔍</span> Añadir Producto
                            </h3>

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Producto</label>
                                    <select x-model="selectedProductId" @change="updateSelectedProductDetails()"
                                            class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 shadow-xs">
                                        <option value="">-- Seleccionar producto --</option>
                                        <template x-for="p in products" :key="p.id">
                                            <option :value="p.id" x-text="p.name + ' - Stock: ' + p.current_stock"></option>
                                        </template>
                                    </select>
                                </div>

                                <template x-if="currentProduct">
                                    <div class="p-3 bg-indigo-50/50 dark:bg-indigo-950/20 border border-indigo-100 dark:border-indigo-900/40 rounded-xl space-y-1">
                                        <div class="flex justify-between text-xs">
                                            <span class="text-gray-500 dark:text-gray-400">Precio Unitario:</span>
                                            <span class="font-bold text-indigo-600 dark:text-indigo-400" x-text="'$' + parseFloat(currentProduct.selling_price).toFixed(2)"></span>
                                        </div>
                                        <div class="flex justify-between text-xs">
                                            <span class="text-gray-500 dark:text-gray-400">Stock Actual:</span>
                                            <span class="font-bold" :class="currentProduct.current_stock <= currentProduct.minimum_stock ? 'text-red-500' : 'text-emerald-600 dark:text-emerald-400'" x-text="currentProduct.current_stock"></span>
                                        </div>
                                    </div>
                                </template>

                                <div>
                                    <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Cantidad a Vender</label>
                                    <input type="number" x-model="selectedQuantity" min="1"
                                           class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 shadow-xs">
                                </div>

                                <button type="button" @click="addToCart()"
                                        class="w-full inline-flex justify-center items-center gap-2 bg-indigo-600 hover:bg-indigo-500 text-white font-bold py-3 px-4 rounded-xl shadow-md transition duration-150 text-sm">
                                    <span>➕</span> Agregar a la Tabla
                                </button>
                            </div>
                        </div>

                    </div>

                    <div class="lg:col-span-2 space-y-6">
                        
                        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-150 dark:border-gray-700 shadow-sm overflow-hidden flex flex-col h-full">
                            <div class="bg-indigo-600 dark:bg-indigo-900 text-white px-8 py-5 flex items-center justify-between">
                                <div>
                                    <h2 class="text-xl font-extrabold tracking-tight">Detalles de la Factura</h2>
                                    <p class="text-indigo-200 text-xs mt-1">Revisa los productos agregados a la transacción actual.</p>
                                </div>
                                <div class="bg-indigo-500 dark:bg-indigo-800/80 px-4 py-2 rounded-xl border border-indigo-400/35">
                                    <span class="text-[10px] uppercase font-bold tracking-wider block text-indigo-200">Total Acumulado</span>
                                    <span class="text-2xl font-black" x-text="'$' + cartTotal.toFixed(2)">$0.00</span>
                                </div>
                            </div>

                            <div class="p-6 flex-1">
                                <div class="overflow-x-auto rounded-xl border border-gray-150 dark:border-gray-750">
                                    <table class="w-full text-left border-collapse">
                                        <thead>
                                            <tr class="bg-gray-50 dark:bg-gray-900/40 border-b border-gray-150 dark:border-gray-700 text-gray-400 dark:text-gray-500 font-bold text-[11px] uppercase tracking-wider">
                                                <th class="px-6 py-4">Código</th>
                                                <th class="px-6 py-4">Producto</th>
                                                <th class="px-6 py-4 text-center">Cantidad</th>
                                                <th class="px-6 py-4 text-right">Precio Unitario</th>
                                                <th class="px-6 py-4 text-right">Subtotal</th>
                                                <th class="px-6 py-4 text-center">Remover</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                            <template x-if="cart.length === 0">
                                                <tr>
                                                    <td colspan="6" class="px-6 py-16 text-center text-gray-400 dark:text-gray-500">
                                                        <span class="text-4xl block mb-2">🛒</span>
                                                        <p class="font-bold">El detalle de la venta está vacío.</p>
                                                        <p class="text-xs mt-1">Busca un producto y agrégalo para comenzar.</p>
                                                    </td>
                                                </tr>
                                            </template>

                                            <template x-for="(item, index) in cart" :key="item.product_id">
                                                <tr class="hover:bg-indigo-50/10 dark:hover:bg-indigo-950/5 transition">
                                                    <td class="px-6 py-4 text-sm font-mono text-gray-400 dark:text-gray-500" x-text="item.code"></td>
                                                    <td class="px-6 py-4 text-sm font-bold text-gray-900 dark:text-white" x-text="item.name"></td>
                                                    <td class="px-6 py-4 text-sm text-center font-semibold text-gray-700 dark:text-gray-300" x-text="item.quantity"></td>
                                                    <td class="px-6 py-4 text-sm text-right font-medium text-gray-900 dark:text-white" x-text="'$' + item.unit_price.toFixed(2)"></td>
                                                    <td class="px-6 py-4 text-sm text-right font-bold text-indigo-600 dark:text-indigo-400" x-text="'$' + (item.quantity * item.unit_price).toFixed(2)"></td>
                                                    <td class="px-6 py-4 text-center">
                                                        <button type="button" @click="removeItem(index)"
                                                                class="inline-flex p-1.5 rounded-lg bg-red-50 hover:bg-red-100 dark:bg-red-950/20 dark:hover:bg-red-950/40 text-red-600 dark:text-red-400 transition">
                                                            🗑️
                                                        </button>
                                                    </td>
                                                </tr>
                                            </template>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="p-6 bg-gray-50 dark:bg-gray-900/20 border-t border-gray-150 dark:border-gray-700 flex justify-end">
                                <button type="submit" ::disabled="cart.length === 0"
                                        class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-500 text-white font-bold py-3.5 px-8 rounded-xl shadow-md transition duration-150 text-sm disabled:opacity-50 disabled:cursor-not-allowed">
                                    <span>💾</span> Emitir y Registrar Venta
                                </button>
                            </div>

                        </div>

                    </div>

                </div>
            </form>
        </div>
    </div>

    <script>
        function invoicePOS(productsList) {
            return {
                products: productsList,
                selectedProductId: '',
                selectedQuantity: 1,
                currentProduct: null,
                cart: [],
                message: '',

                updateSelectedProductDetails() {
                    this.currentProduct = this.products.find(p => p.id == this.selectedProductId) || null;
                    this.selectedQuantity = 1;
                },

                addToCart() {
                    if (!this.currentProduct) {
                        alert('Selecciona un producto válido primero.');
                        return;
                    }

                    const qty = parseInt(this.selectedQuantity);
                    if (qty <= 0) {
                        alert('La cantidad debe ser mayor a 0.');
                        return;
                    }

                    // Validar Stock actual
                    if (qty > this.currentProduct.current_stock) {
                        alert(`Stock insuficiente. Solo quedan ${this.currentProduct.current_stock} unidades.`);
                        return;
                    }

                    // Validar si ya está en el carrito para unificar cantidades
                    const existingIndex = this.cart.findIndex(item => item.product_id === this.currentProduct.id);
                    if (existingIndex !== -1) {
                        const newQty = this.cart[existingIndex].quantity + qty;
                        if (newQty > this.currentProduct.current_stock) {
                            alert(`No puedes agregar más de esta cantidad. Superaría el stock disponible (${this.currentProduct.current_stock}).`);
                            return;
                        }
                        this.cart[existingIndex].quantity = newQty;
                    } else {
                        this.cart.push({
                            product_id: this.currentProduct.id,
                            name: this.currentProduct.name,
                            code: this.currentProduct.code,
                            quantity: qty,
                            unit_price: parseFloat(this.currentProduct.selling_price)
                        });
                    }

                    this.message = `¡"${this.currentProduct.name}" agregado a los detalles de venta!`;
                    
                    // Limpiar el selector
                    this.selectedProductId = '';
                    this.currentProduct = null;
                    this.selectedQuantity = 1;

                    // Limpiar la notificación después de unos segundos
                    setTimeout(() => this.message = '', 3500);
                },

                removeItem(index) {
                    this.cart.splice(index, 1);
                },

                get cartTotal() {
                    return this.cart.reduce((acc, item) => acc + (item.quantity * item.unit_price), 0);
                }
            }
        }
    </script>
</x-app-layout>