<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Factura / Registro de Venta</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen py-8 px-4">

    <div class="max-w-5xl mx-auto bg-white rounded-xl shadow-lg overflow-hidden">
        
        <div class="bg-indigo-600 px-6 py-4 text-white flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold">Registrar Nueva Venta</h1>
                <p class="text-xs text-indigo-200">El inventario se actualizará automáticamente al guardar</p>
            </div>
            <a href="{{ route('invoices.index') }}" class="bg-indigo-700 hover:bg-indigo-800 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
                Ver Facturas
            </a>
        </div>

        <div class="p-6">
            @if ($errors->any())
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded text-red-700 text-sm">
                    <p class="font-bold">Por favor corrige los siguientes errores:</p>
                    <ul class="list-disc pl-5 mt-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded text-red-700 text-sm">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('invoices.store') }}" method="POST" id="invoice-form">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div>
                        <label for="customer_name" class="block text-sm font-medium text-gray-700 mb-1">Nombre del Cliente</label>
                        <input type="text" name="customer_name" id="customer_name" required value="{{ old('customer_name', 'Cliente General') }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
                    </div>

                    <div>
                        <label for="payment_type" class="block text-sm font-medium text-gray-700 mb-1">Método de Pago</label>
                        <select name="payment_type" id="payment_type" required
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
                            <option value="Efectivo" {{ old('payment_type') == 'Efectivo' ? 'selected' : '' }}>Efectivo</option>
                            <option value="Transferencia" {{ old('payment_type') == 'Transferencia' ? 'selected' : '' }}>Transferencia</option>
                            <option value="Tarjeta" {{ old('payment_type') == 'Tarjeta' ? 'selected' : '' }}>Tarjeta de Crédito/Débito</option>
                        </select>
                    </div>
                </div>

                <hr class="my-6 border-gray-200">

                <div class="bg-gray-50 p-4 rounded-xl border border-gray-200 mb-8">
                    <h3 class="text-sm font-bold text-gray-700 mb-3">Agregar Productos al Detalle</h3>
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                        
                        <div class="md:col-span-7">
                            <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Producto disponible</label>
                            <select id="product_selector" class="w-full border border-gray-300 rounded-lg px-3 py-2 outline-none bg-white">
                                <option value="">-- Selecciona un producto --</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" 
                                            data-code="{{ $product->code }}"
                                            data-name="{{ $product->name }}" 
                                            data-price="{{ $product->selling_price }}" 
                                            data-stock="{{ $product->current_stock }}">
                                        [{{ $product->code }}] {{ $product->name }} - ${{ number_format($product->selling_price, 2) }} (Disponibles: {{ $product->current_stock }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="md:col-span-3">
                            <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Cantidad</label>
                            <input type="number" id="product_quantity" min="1" value="1"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 outline-none">
                        </div>

                        <div class="md:col-span-2">
                            <button type="button" id="btn_add_product"
                                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg transition duration-150">
                                Añadir
                            </button>
                        </div>

                    </div>
                </div>

                <div class="overflow-x-auto mb-8">
                    <table class="min-w-full divide-y divide-gray-200" id="items_table">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Código</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Producto</th>
                                <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase">P. Unitario</th>
                                <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase">Cantidad</th>
                                <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Subtotal</th>
                                <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase">Acción</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white" id="table_body">
                            <tr id="empty_row">
                                <td colspan="6" class="px-6 py-8 text-center text-sm text-gray-400">
                                    No has añadido ningún producto al detalle todavía.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="flex flex-col items-end border-t border-gray-200 pt-6">
                    <div class="w-full md:w-80">
                        <div class="flex justify-between items-center text-gray-600 py-1">
                            <span>Subtotal:</span>
                            <span id="label_subtotal" class="font-semibold">$0.00</span>
                        </div>
                        <div class="flex justify-between items-center text-gray-900 py-2 border-t border-gray-100 text-xl font-bold">
                            <span>Total a Cobrar:</span>
                            <span id="label_total" class="text-indigo-600">$0.00</span>
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex justify-end gap-4">
                    <a href="{{ route('invoices.index') }}" class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-lg transition">
                        Cancelar
                    </a>
                    <button type="submit" id="btn_submit_invoice" disabled
                            class="px-8 py-3 bg-gray-400 text-white font-bold rounded-lg cursor-not-allowed transition duration-150">
                        Procesar y Cobrar Venta
                    </button>
                </div>

            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const btnAdd = document.getElementById('btn_add_product');
            const selector = document.getElementById('product_selector');
            const quantityInput = document.getElementById('product_quantity');
            const tableBody = document.getElementById('table_body');
            const emptyRow = document.getElementById('empty_row');
            const labelSubtotal = document.getElementById('label_subtotal');
            const labelTotal = document.getElementById('label_total');
            const btnSubmit = document.getElementById('btn_submit_invoice');
            
            let itemIndex = 0; // Índice único para los campos del array de Laravel

            // Agregar producto al hacer clic
            btnAdd.addEventListener('click', function() {
                const selectedOption = selector.options[selector.selectedIndex];
                
                if (!selectedOption.value) {
                    alert('Por favor, selecciona un producto válido.');
                    return;
                }

                const productId = selectedOption.value;
                const productCode = selectedOption.getAttribute('data-code');
                const productName = selectedOption.getAttribute('data-name');
                const productPrice = parseFloat(selectedOption.getAttribute('data-price'));
                const productStock = parseInt(selectedOption.getAttribute('data-stock'));
                const reqQuantity = parseInt(quantityInput.value);

                // Validaciones básicas de front
                if (isNaN(reqQuantity) || reqQuantity <= 0) {
                    alert('La cantidad debe ser mayor a 0.');
                    return;
                }

                // Verificar si ya existe en la tabla para sumar o alertar
                const existingRow = document.querySelector(`tr[data-product-id="${productId}"]`);
                let totalQtyPlanned = reqQuantity;

                if (existingRow) {
                    const existingQtyInput = existingRow.querySelector('.row-quantity-input');
                    totalQtyPlanned += parseInt(existingQtyInput.value);
                }

                if (totalQtyPlanned > productStock) {
                    alert(`No puedes superar el stock disponible del producto. Existencias reales: ${productStock}`);
                    return;
                }

                // Eliminar fila de "Vacío" si es el primer item
                if (emptyRow) {
                    emptyRow.style.display = 'none';
                }

                if (existingRow) {
                    // Si ya existe, simplemente actualizamos la cantidad y subtotal en vez de crear otra fila
                    const qtyInput = existingRow.querySelector('.row-quantity-input');
                    const subtotalCell = existingRow.querySelector('.row-subtotal');
                    
                    qtyInput.value = totalQtyPlanned;
                    const newSubtotal = totalQtyPlanned * productPrice;
                    subtotalCell.textContent = `$${newSubtotal.toFixed(2)}`;
                    subtotalCell.setAttribute('data-subtotal-val', newSubtotal);
                } else {
                    // Crear nueva fila
                    const subtotal = reqQuantity * productPrice;
                    const row = document.createElement('tr');
                    row.setAttribute('data-product-id', productId);
                    row.className = 'hover:bg-gray-50 transition duration-75';

                    row.innerHTML = `
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-mono">${productCode}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">${productName}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-gray-600">$${productPrice.toFixed(2)}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <input type="hidden" name="items[${itemIndex}][product_id]" value="${productId}">
                            <input type="number" name="items[${itemIndex}][quantity]" value="${reqQuantity}" 
                                   class="row-quantity-input w-16 text-center border border-gray-300 rounded px-1 py-1 text-sm outline-none focus:ring-1 focus:ring-indigo-500" 
                                   min="1" max="${productStock}" data-price="${productPrice}">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-semibold text-gray-900 row-subtotal" data-subtotal-val="${subtotal}">
                            $${subtotal.toFixed(2)}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <button type="button" class="btn-remove-row text-red-600 hover:text-red-900 font-medium text-sm transition">
                                Eliminar
                            </button>
                        </td>
                    `;

                    tableBody.appendChild(row);
                    itemIndex++; // Incrementamos el índice para la siguiente fila
                    
                    // Escuchar cambios de cantidad directamente en la tabla
                    const qtyInput = row.querySelector('.row-quantity-input');
                    qtyInput.addEventListener('change', function() {
                        let currentVal = parseInt(this.value);
                        if (isNaN(currentVal) || currentVal < 1) {
                            currentVal = 1;
                            this.value = 1;
                        }
                        if (currentVal > productStock) {
                            alert(`Stock superado. Máximo disponible: ${productStock}`);
                            currentVal = productStock;
                            this.value = productStock;
                        }

                        const newSubtotal = currentVal * productPrice;
                        const subtotalCell = row.querySelector('.row-subtotal');
                        subtotalCell.textContent = `$${newSubtotal.toFixed(2)}`;
                        subtotalCell.setAttribute('data-subtotal-val', newSubtotal);
                        calculateTotals();
                    });
                }

                // Limpiar selector y reiniciar cantidad
                selector.value = '';
                quantityInput.value = 1;

                calculateTotals();
            });

            // Delegación de eventos para eliminar fila
            tableBody.addEventListener('click', function(e) {
                if (e.target.classList.contains('btn-remove-row')) {
                    const row = e.target.closest('tr');
                    row.remove();

                    // Si la tabla queda vacía, volvemos a mostrar la fila de vacío
                    const rows = tableBody.querySelectorAll('tr:not(#empty_row)');
                    if (rows.length === 0 && emptyRow) {
                        emptyRow.style.display = 'table-row';
                    }

                    calculateTotals();
                }
            });

            // Función para calcular los totales visibles
            function calculateTotals() {
                let grandTotal = 0;
                const subtotals = tableBody.querySelectorAll('.row-subtotal');

                subtotals.forEach(cell => {
                    grandTotal += parseFloat(cell.getAttribute('data-subtotal-val'));
                });

                labelSubtotal.textContent = `$${grandTotal.toFixed(2)}`;
                labelTotal.textContent = `$${grandTotal.toFixed(2)}`;

                // Habilitar o deshabilitar botón de guardado según haya productos o no
                if (grandTotal > 0) {
                    btnSubmit.disabled = false;
                    btnSubmit.className = "px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-lg shadow-md cursor-pointer transition duration-150";
                } else {
                    btnSubmit.disabled = true;
                    btnSubmit.className = "px-8 py-3 bg-gray-400 text-white font-bold rounded-lg cursor-not-allowed transition duration-150";
                }
            }
        });
    </script>
</body>
</html>