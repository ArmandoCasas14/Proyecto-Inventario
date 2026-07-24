<x-app-layout>
    <!-- Fondo General Punteado -->
    <div class="relative min-h-screen bg-slate-100/70 -m-4 sm:-m-6 lg:-m-8 p-4 sm:p-6 lg:p-8 overflow-hidden flex justify-center">
        
        <!-- Textura Punteada de Fondo -->
        <div class="absolute inset-0 opacity-15 bg-[radial-gradient(#059669_1px,transparent_1px)] [background-size:16px_16px] pointer-events-none"></div>

        <!-- CONTENEDOR CENTRAL UNIFICADO -->
        <div class="w-full max-w-5xl bg-white rounded-3xl shadow-xl border border-slate-200/80 overflow-hidden relative z-10 my-auto">
            
            <!-- 1. HEADER INTEGRADO DENTRO DEL CARD -->
            <div class="bg-emerald-600 px-6 py-6 md:px-8 text-white flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight">Registrar Nueva Venta</h1>
                    <p class="text-emerald-100 text-xs md:text-sm mt-1">El inventario se actualizará automáticamente al guardar</p>
                </div>
                <div>
                    <a href="{{ route('facturas.index') }}" 
                       class="inline-flex items-center justify-center bg-emerald-700 hover:bg-emerald-800 text-white font-semibold px-4 py-2 rounded-xl text-xs md:text-sm shadow-xs transition gap-2 border border-emerald-500/50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Ver Facturas
                    </a>
                </div>
            </div>

            <!-- Alertas de Error -->
            @if(session('error'))
                <div class="m-6 md:m-8 p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-2xl flex items-center gap-3 text-sm font-medium shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-rose-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <form action="{{ route('facturas.store') }}" method="POST" id="invoice-form" class="p-6 md:p-8 space-y-8">
                @csrf
                
                <!-- 2. SECCIÓN: CLIENTE Y MÉTODO DE PAGO -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="customer_name" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">Nombre del Cliente</label>
                        <input type="text" name="customer_name" id="customer_name" value="{{ old('customer_name', 'Cliente General') }}" 
                               class="block w-full rounded-xl border-slate-200 bg-slate-50/50 text-slate-800 focus:border-emerald-500 focus:ring-emerald-500 text-sm py-2.5 px-3.5 transition" required>
                    </div>
                    <div>
                        <label for="payment_type" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">Método de Pago</label>
                        <select name="payment_type" id="payment_type" 
                                class="block w-full rounded-xl border-slate-200 bg-slate-50/50 text-slate-800 focus:border-emerald-500 focus:ring-emerald-500 text-sm py-2.5 px-3.5 transition" required>
                            <option value="Efectivo">Efectivo</option>
                            <option value="Transferencia">Transferencia Bancaria / Nequi</option>
                            <option value="Tarjeta">Tarjeta Débito / Crédito</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label for="observations" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">Observaciones / Referencia</label>
                    <input type="text" name="observations" id="observations" value="{{ old('observations') }}" 
                        placeholder="Ej: Número de comprobante o notas adicionales..."
                        class="block w-full rounded-xl border-slate-200 bg-slate-50/50 text-slate-800 focus:border-emerald-500 focus:ring-emerald-500 text-sm py-2.5 px-3.5 transition">
                </div>      

                <!-- 3. SECCIÓN: BÚSQUEDA DE PRODUCTOS (CAJA DESTACADA CON FONDO SUTIL) -->
                <div class="bg-slate-50/80 border border-slate-200/80 rounded-2xl p-5 md:p-6 space-y-4">
                    <h2 class="text-sm font-bold text-slate-800 uppercase tracking-wide">Agregar Productos al Detalle</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                        <!-- Entrada por Código Único -->
                        <div class="md:col-span-4">
                            <label for="product_code" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Código / Scanner</label>
                            <input type="text" id="product_code" placeholder="Escriba código + Enter" 
                                   class="block w-full rounded-xl border-slate-200 bg-white text-emerald-700 font-mono font-bold focus:border-emerald-500 focus:ring-emerald-500 text-sm py-2 px-3 transition">
                        </div>

                        <!-- Selector por Nombre -->
                        <div class="md:col-span-5">
                            <label for="product_selector" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Producto Disponible</label>
                            <select id="product_selector" class="block w-full rounded-xl border-slate-200 bg-white text-slate-800 focus:border-emerald-500 focus:ring-emerald-500 text-sm py-2 px-3 transition">
                                <option value="">-- Seleccionar producto del catálogo --</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" data-code="{{ $product->code }}" data-name="{{ $product->name }}" data-price="{{ $product->selling_price }}" data-stock="{{ $product->current_stock }}">
                                        [{{ $product->code }}] {{ $product->name }} - ${{ number_format($product->selling_price, 2) }} (Disponibles: {{ $product->current_stock }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Botón Añadir -->
                        <div class="md:col-span-3">
                            <button type="button" id="btn-add-product" 
                                    class="w-full inline-flex justify-center items-center bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded-xl shadow-sm transition text-sm gap-1.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                </svg>
                                Añadir
                            </button>
                        </div>
                    </div>
                </div>

                <!-- 4. SECCIÓN: TABLA DETALLE DE PRODUCTOS -->
                <div class="overflow-x-auto rounded-xl border border-slate-100">
                    <table class="min-w-full divide-y divide-slate-100 text-sm text-left">
                        <thead class="bg-slate-100/70">
                            <tr>
                                <th scope="col" class="px-4 py-3 text-xs font-bold text-slate-500 uppercase tracking-wider">Código</th>
                                <th scope="col" class="px-4 py-3 text-xs font-bold text-slate-500 uppercase tracking-wider">Producto</th>
                                <th scope="col" class="px-4 py-3 text-center text-xs font-bold text-slate-500 uppercase tracking-wider" style="width: 120px;">P. Unitario</th>
                                <th scope="col" class="px-4 py-3 text-center text-xs font-bold text-slate-500 uppercase tracking-wider" style="width: 110px;">Cantidad</th>
                                <th scope="col" class="px-4 py-3 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">Subtotal</th>
                                <th scope="col" class="px-4 py-3 text-center text-xs font-bold text-slate-500 uppercase tracking-wider" style="width: 90px;">Acción</th>
                            </tr>
                        </thead>
                        <tbody id="detail-wrapper" class="divide-y divide-slate-100 bg-white">
                            <tr id="empty-row">
                                <td colspan="6" class="px-6 py-10 text-center text-slate-400 italic">
                                    No has añadido ningún producto al detalle todavía.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- 5. SECCIÓN: RESUMEN DE TOTALES Y BOTÓN FINAL -->
                <div class="pt-4 border-t border-slate-100 flex flex-col md:flex-row justify-between items-end md:items-center gap-6">
                    <div class="text-right w-full md:w-auto ml-auto space-y-1">
                        <div class="flex justify-between md:justify-end gap-8 text-sm text-slate-500 font-medium">
                            <span>Subtotal:</span>
                            <span id="subtotal-label" class="font-mono">$0.00</span>
                        </div>
                        <div class="flex justify-between md:justify-end gap-8 text-xl font-black text-slate-900 pt-1">
                            <span>Total a Cobrar:</span>
                            <span id="grand-total" class="font-mono text-emerald-600">$0.00</span>
                        </div>
                    </div>
                </div>

                <!-- Botones de Acción -->
                <div class="flex items-center justify-end gap-3 pt-4">
                    <a href="{{ route('facturas.index') }}" 
                       class="inline-flex items-center justify-center bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold px-5 py-2.5 rounded-xl transition text-sm">
                        Cancelar
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center justify-center bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-6 py-2.5 rounded-xl shadow-md shadow-emerald-600/20 transition text-sm">
                        Completar Venta
                    </button>
                </div>

            </form>
        </div>
    </div>

    <!-- JS CONTROLADOR DE LA TABLA -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inputCode = document.getElementById('product_code');
            const selector = document.getElementById('product_selector');
            const btnAdd = document.getElementById('btn-add-product');
            const detailWrapper = document.getElementById('detail-wrapper');
            const emptyRow = document.getElementById('empty-row');
            const grandTotalLabel = document.getElementById('grand-total');
            const subtotalLabel = document.getElementById('subtotal-label');
            const paymentTypeSelect = document.getElementById('payment_type');
            const observationsInput = document.getElementById('observations');  
            
            let itemIndex = 0;

            selector.addEventListener('change', function() {
                if(this.value) {
                    const selectedOption = this.options[this.selectedIndex];
                    inputCode.value = selectedOption.dataset.code;
                }
            });
            paymentTypeSelect.addEventListener('change', function() {
                const selectedValue = this.value;

                if (selectedValue === 'Efectivo') {
                    observationsInput.value = ''; // No ponga nada por defecto
                } else if (selectedValue === 'Transferencia') {
                    observationsInput.value = 'Número de transferencia: ';
                } else if (selectedValue === 'Tarjeta') {
                    observationsInput.value = 'Número de pago: ';
                }
            
            // Opcional: enfocar el input para que el usuario escriba de una vez el número si lo desea
            // observationsInput.focus();
             });

            inputCode.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    processSelection();
                }
            });

            btnAdd.addEventListener('click', processSelection);

            function processSelection() {
                const codeValue = inputCode.value.trim().toLowerCase();
                if (!codeValue) return Swal.fire({
                    icon: 'warning',
                    title: 'Atención',
                    text: 'Debe ingresar un código o seleccionar un producto.',
                    confirmButtonColor: '#059669'
                });

                let optionFound = null;
                for (let i = 0; i < selector.options.length; i++) {
                    const opt = selector.options[i];
                    if (opt.dataset.code && opt.dataset.code.toLowerCase() === codeValue) {
                        optionFound = opt;
                        break;
                    }
                }

                if (!optionFound) {
                    return Swal.fire({
                        icon: 'warning',
                        title: 'Atención',
                        text: 'El código ingresado no existe en el catálogo.',
                        confirmButtonColor: '#059669'
                    });
                }

                const productId = optionFound.value;
                const code = optionFound.dataset.code;
                const name = optionFound.dataset.name;
                const price = parseFloat(optionFound.dataset.price);
                const maxStock = parseInt(optionFound.dataset.stock);

                const existingInput = document.querySelector(`input[value="${productId}"][name*="product_id"]`);
                if (existingInput) {
                    const row = existingInput.closest('tr');
                    const qtyInput = row.querySelector('.qty-input');
                    let currentQty = parseInt(qtyInput.value) || 0;
                    if (currentQty >= maxStock) {
                        return Swal.fire({
                            icon: 'warning',
                            title: 'Stock Límite',
                            text: `No puedes agregar más. Disponibles: ${maxStock}`,
                            confirmButtonColor: '#059669'
                        });
                    }
                    qtyInput.value = currentQty + 1;
                    qtyInput.dispatchEvent(new Event('input'));
                    clearInputs();
                    return;
                }

                if (emptyRow && emptyRow.parentNode) emptyRow.remove();

                const tr = document.createElement('tr');
                tr.className = 'hover:bg-slate-50 transition item-row';
                    tr.innerHTML = `
                        <td class="px-4 py-3 font-mono text-xs font-bold text-slate-600">${code}</td>
                        <td class="px-4 py-3">
                            <span class="text-sm font-semibold text-slate-800">${name}</span>
                            <input type="hidden" name="items[${itemIndex}][product_id]" value="${productId}">
                        </td>
                        <td class="px-4 py-3 text-center font-mono text-slate-600">$${price.toFixed(2)}</td>
                        <td class="px-4 py-3 text-center">
                            <input type="number" name="items[${itemIndex}][quantity]" value="1" min="1" max="${maxStock}" 
                                class="qty-input block w-16 text-center rounded-lg border-slate-200 bg-white text-slate-800 font-bold focus:border-emerald-500 focus:ring-emerald-500 text-sm py-1 px-1 mx-auto transition" data-price="${price}">
                        </td>
                        <td class="px-4 py-3 text-right font-bold font-mono text-slate-900 row-subtotal">$${price.toFixed(2)}</td>
                        <td class="px-4 py-3 text-center">
                            <button type="button" class="text-rose-500 hover:text-rose-700 font-bold text-xs p-1 hover:bg-rose-50 rounded transition btn-remove">
                                Quitar
                            </button>
                        </td>
                    `;

                detailWrapper.appendChild(tr);
                itemIndex++;
                calculateGrandTotal();
                clearInputs();

                tr.querySelector('.qty-input').addEventListener('input', function() {
                    let qty = parseInt(this.value) || 0;
                    if(qty > maxStock) {
                        return Swal.fire({
                            icon: 'warning',
                            title: 'Stock Límite',
                            text: `Máximo disponible para ${name}: ${maxStock}`,
                            confirmButtonColor: '#059669'
                        });
                    }
                    const subtotal = qty * price;
                    tr.querySelector('.row-subtotal').innerText = `$${subtotal.toFixed(2)}`;
                    calculateGrandTotal();
                });

                tr.querySelector('.btn-remove').addEventListener('click', function() {
                    tr.remove();
                    if (detailWrapper.querySelectorAll('.item-row').length === 0) {
                        detailWrapper.appendChild(emptyRow);
                    }
                    calculateGrandTotal();
                });
            }

            function clearInputs() {
                inputCode.value = "";
                selector.value = "";
                inputCode.focus();
            }

            function calculateGrandTotal() {
                let total = 0;
                document.querySelectorAll('.item-row').forEach(row => {
                    const qty = parseInt(row.querySelector('.qty-input').value) || 0;
                    const price = parseFloat(row.querySelector('.qty-input').dataset.price);
                    total += (qty * price);
                });
                subtotalLabel.innerText = `$${total.toFixed(2)}`;
                grandTotalLabel.innerText = `$${total.toFixed(2)}`;
            }
        });
    </script>
</x-app-layout>