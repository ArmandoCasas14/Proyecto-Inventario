<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Productos</title>
    <style>
        body { 
            font-family: 'DejaVu Sans', sans-serif; 
            font-size: 11px; 
            color: #333;
        }
        .header { 
            text-align: center; 
            font-size: 18px; 
            font-weight: bold; 
            margin-bottom: 5px;
            text-transform: uppercase;
        }
        .date {
            text-align: right;
            font-size: 10px;
            color: #555;
            margin-bottom: 15px;
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
        }
        th { 
            background-color: #4f46e5; /* Color del diseño de tu app (Indigo) */
            color: white; 
            padding: 8px 6px; 
            text-align: left; 
            font-size: 10px;
            text-transform: uppercase;
        }
        td { 
            border-bottom: 1px solid #e5e7eb; 
            padding: 6px; 
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .badge-active {
            color: #15803d;
            font-weight: bold;
        }
        .badge-inactive {
            color: #b91c1c;
            font-weight: bold;
        }
        .footer { 
            text-align: center; 
            margin-top: 30px; 
            font-size: 9px; 
            color: #6b7280; 
            border-top: 1px solid #e5e7eb;
            padding-top: 8px;
        }
    </style>
</head>
<body>

    <div class="header">Listado de Productos</div>
    <div class="date">Fecha de generación: {{ now()->format('d/m/Y H:i A') }}</div>

    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Producto</th>
                <th>Categoría</th>
                <th>Proveedor</th>
                <th class="text-right">Precio Venta</th>
                <th class="text-center">Stock</th>
                <th class="text-center">Estado</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
                <tr>
                    <td><strong>{{ $product->code }}</strong></td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->category->name ?? 'Sin Categoría' }}</td>
                    <td>{{ $product->supplier->name ?? 'Sin Proveedor' }}</td>
                    <td class="text-right">${{ number_format($product->selling_price, 2) }}</td>
                    <td class="text-center">{{ $product->current_stock }}</td>
                    <td class="text-center">
                        @if($product->status)
                            <span class="badge-active">Activo</span>
                        @else
                            <span class="badge-inactive">Inactivo</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center" style="padding: 15px;">
                        No hay productos registrados o que coincidan con los filtros.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Sistema de Gestión de Inventario - Reporte Generado Automáticamente
    </div>

</body>
</html>