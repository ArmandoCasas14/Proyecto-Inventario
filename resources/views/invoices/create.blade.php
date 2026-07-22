<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Módulo de Facturación e Ingreso de Ventas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative shadow">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <form action="{{ route('facturas.store') }}" method="POST" id="invoice-form">
                @csrf
                
                <!-- SECCIÓN 1: DATOS CABECERA DE LA FACTURA -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4 border-b pb-2">Información General</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="customer_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Cliente / Razón Social</label>
                            <input type="text" name="customer_name" id="customer_name" value="{{ old('customer_name', 'Cliente General') }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" required>
                        </div>
                        <div>
                            <label for="payment_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Forma de Pago</label>
                            <select name="payment_type" id="payment_type" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" required>
                                <option value="Efectivo">Efectivo</option>
                                <option value="Transferencia">Transferencia Bancaria</option>
                                <option value="Tarjeta">Tarjeta</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- SECCIÓN 2: ENTRADA DE PRODUCTOS (CÓDIGO O BUSCADOR) -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4 border-b pb-2">Ingreso de Artículos</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                        <!-- Entrada por Código Único -->
                        <div>
                            <label for="product_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Código Único</label>
                            <input type="text" id="product_code" placeholder="Escriba el código y presione Enter" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm font-mono text-indigo-600 dark:text-indigo-400">
                        </div>

                        <!-- Entrada por Buscador de Nombre -->
                        <div>
                            <label for="product_selector" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Buscar por Nombre</label>
                            <select id="product_selector" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                                <option value="">Seleccione un producto</option>
                                @foreach($products as $product)
                                    <!-- Guardamos el código único en data-code -->
                                    <option value="{{ $product->id }}" data-code="{{ $product->code }}" data-name="{{ $product->name }}" data-price="{{ $product->selling_price }}" data-stock="{{ $product->current_stock }}">
                                        {{ $product->code }} - {{ $product->name }} - Stock: {{ $product->current_stock }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <button type="button" id="btn-add-product" class="w-full inline-flex justify-center items-center px-4 py-2.5 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none shadow">
                                + Agregar Fila
                            </button>
                        </div>
                    </div>
                </div>

                <!-- SECCIÓN 3: TABLA DE DETALLE INTERNA -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4 border-b pb-2">Artículos a Facturar</h3>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-4 py-3">Código</th>
                                    <th scope="col" class="px-4 py-3">Descripción</th>
                                    <th scope="col" class="px-4 py-3 text-center" style="width: 100px;">Precio Unit.</th>
                                    <th scope="col" class="px-4 py-3 text-center" style="width: 120px;">Cantidad</th>
                                    <th scope="col" class="px-4 py-3 text-right">Subtotal</th>
                                    <th scope="col" class="px-4 py-3 text-center">Acción</th>
                                </tr>
                            </thead>
                            <tbody id="detail-wrapper">
                                <tr id="empty-row">
                                    <td colspan="6" class="px-4 py-8 text-center text-gray-400 italic">Ningún artículo cargado en este documento.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Totales y Envío -->
                    <div class="border-t mt-6 pt-4 dark:border-gray-700 flex flex-col md:flex-row justify-between items-center gap-4">
                        <div class="text-left">
                            <span class="text-sm text-gray-500 dark:text-gray-400">Monto Total Liquidado:</span>
                            <div class="text-3xl font-black text-indigo-600 dark:text-indigo-400" id="grand-total">$0.00</div>
                        </div>

                        <div class="flex space-x-3">
                            <a href="{{ route('facturas.index') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50">
                                Cancelar
                            </a>
                            <button type="submit" class="inline-flex items-center px-6 py-3 bg-green-600 border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest hover:bg-green-700 shadow-md">
                                Guardar y Emitir Factura
                            </button>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>

    <!-- CONTROLADOR JAVASCRIPT DE LA TABLA TEMPORAL -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inputCode = document.getElementById('product_code');
            const selector = document.getElementById('product_selector');
            const btnAdd = document.getElementById('btn-add-product');
            const detailWrapper = document.getElementById('detail-wrapper');
            const emptyRow = document.getElementById('empty-row');
            const grandTotalLabel = document.getElementById('grand-total');
            
            let itemIndex = 0;

            // Al cambiar el buscador por nombre, autocompleta el campo de código único
            selector.addEventListener('change', function() {
                if(this.value) {
                    const selectedOption = this.options[this.selectedIndex];
                    inputCode.value = selectedOption.dataset.code;
                }
            });

            // Si el usuario escribe el código y presiona ENTER, agrega automáticamente el producto
            inputCode.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault(); // Evita que se envíe el formulario por error
                    processSelection();
                }
            });

            // Si le da clic al botón Agregar
            btnAdd.addEventListener('click', processSelection);

            function processSelection() {
                const codeValue = inputCode.value.trim().toLowerCase();
                if (!codeValue) return Swal.fire({
                                        icon: 'warning',
                                        title: '¡Atención!',
                                        text: 'Debe ingresar un código de producto o seleccionar uno del buscador.',
                                        confirmButtonColor: '#4f46e5', // Color índigo para combinar con tu tema
                                        confirmButtonText: 'Entendido'
                                    });;

                // Buscar las propiedades del producto dentro del select de datos
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
                        title: '¡Atención!',
                        text: 'El código de producto no existe o está inactivo.',
                        confirmButtonColor: '#4f46e5',
                        confirmButtonText: 'Entendido'
                    });
                }

                const productId = optionFound.value;
                const code = optionFound.dataset.code;
                const name = optionFound.dataset.name;
                const price = parseFloat(optionFound.dataset.price);
                const maxStock = parseInt(optionFound.dataset.stock);

                // Comprobar si ya existe en la tabla. Si existe, le sumamos 1 a su cantidad.
                const existingInput = document.querySelector(`input[value="${productId}"][name*="product_id"]`);
                if (existingInput) {
                    const row = existingInput.closest('tr');
                    const qtyInput = row.querySelector('.qty-input');
                    let currentQty = parseInt(qtyInput.value) || 0;
                    if (currentQty >= maxStock) {
                        return Swal.fire({
                            icon: 'warning',
                            title: '¡Atención!',
                            text: `No puedes agregar más. El stock máximo en bodega es: ${maxStock}`,
                            confirmButtonColor: '#4f46e5',
                            confirmButtonText: 'Entendido'
                        });
                    }
                    qtyInput.value = currentQty + 1;
                    qtyInput.dispatchEvent(new Event('input')); // Disparar recálculo
                    clearInputs();
                    return;
                }

                // Remover fila vacía
                if (emptyRow && emptyRow.parentNode) emptyRow.remove();

                // Construcción de la fila del detalle
                const tr = document.createElement('tr');
                tr.className = 'border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 item-row';
                tr.innerHTML = `
                    <td class="px-4 py-4 font-mono text-xs font-bold text-gray-400">${code}</td>
                    <td class="px-4 py-4 font-medium text-gray-900 dark:text-white">
                        ${name}
                        <input type="hidden" name="items[${itemIndex}][product_id]" value="${productId}">
                    </td>
                    <td class="px-4 py-4 text-center font-mono">$${price.toFixed(2)}</td>
                    <td class="px-4 py-4 text-center">
                        <input type="number" name="items[${itemIndex}][quantity]" value="1" min="1" max="${maxStock}" class="qty-input block w-20 text-center rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm sm:text-sm mx-auto" data-price="${price}">
                    </td>
                    <td class="px-4 py-4 text-right font-bold font-mono text-gray-900 dark:text-white row-subtotal">$${price.toFixed(2)}</td>
                    <td class="px-4 py-4 text-center">
                        <button type="button" class="text-red-500 hover:text-red-700 font-bold btn-remove">Eliminar</button>
                    </td>
                `;

                detailWrapper.appendChild(tr);
                itemIndex++;
                calculateGrandTotal();
                clearInputs();

                // Listener de cambios en la cantidad de esta fila específica
                tr.querySelector('.qty-input').addEventListener('input', function() {
                    let qty = parseInt(this.value) || 0;
                    if(qty > maxStock) {
                        return Swal.fire({
                            icon: 'warning',
                            title: '¡Atención!',
                            text: `Excede las existencias del producto: ${name}. Máximo disponible: ${maxStock}`,
                            confirmButtonColor: '#4f46e5',
                            confirmButtonText: 'Entendido'
                        });
                    }
                    const subtotal = qty * price;
                    tr.querySelector('.row-subtotal').innerText = `$${subtotal.toFixed(2)}`;
                    calculateGrandTotal();
                });

                // Listener para remover fila
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
                inputCode.focus(); // Mantiene el cursor listo para la siguiente lectura de código
            }

            function calculateGrandTotal() {
                let total = 0;
                document.querySelectorAll('.item-row').forEach(row => {
                    const qty = parseInt(row.querySelector('.qty-input').value) || 0;
                    const price = parseFloat(row.querySelector('.qty-input').dataset.price);
                    total += (qty * price);
                });
                grandTotalLabel.innerText = `$${total.toFixed(2)}`;
            }
        });
    </script>
</x-app-layout>