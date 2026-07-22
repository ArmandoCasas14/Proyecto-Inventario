<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Movimientos de Inventario</title>
    <style>
        @page {
            margin: 0cm 0cm;
        }
        
        body { 
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; 
            font-size: 11px; 
            color: #334155; 
            background-color: #ffffff;
            margin: 1.5cm;
        }

        /* BANNER ENCABEZADO */
        .header-banner {
            background: linear-gradient(135deg, #1e1b4b 0%, #312e81 100%);
            background-color: #1e1b4b; /* Fallback para DomPDF */
            color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .header-banner h1 {
            margin: 0;
            font-size: 20px;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .header-banner p {
            margin: 4px 0 0 0;
            font-size: 12px;
            color: #c7d2fe;
            font-weight: 500;
        }

        /* METADATOS Y FILTROS */
        .info-container {
            width: 100%;
            margin-bottom: 20px;
        }

        .info-card {
            background-color: #f8fafc;
            border-left: 4px solid #4f46e5;
            padding: 12px 15px;
            border-radius: 4px;
        }

        .info-card table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-card td {
            border: none;
            padding: 3px 0;
            font-size: 11px;
        }

        .label {
            font-weight: bold;
            color: #64748b;
            text-transform: uppercase;
            font-size: 9px;
            letter-spacing: 0.5px;
        }

        .value {
            color: #0f172a;
            font-weight: 600;
        }

        /* TABLA PRINCIPAL */
        .data-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-top: 10px;
            border-radius: 6px;
            overflow: hidden;
            border: 1px solid #e2e8f0;
        }

        .data-table th {
            background-color: #4f46e5;
            color: #ffffff;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 9.5px;
            letter-spacing: 0.6px;
            padding: 10px 12px;
            text-align: left;
            border: none;
        }

        .data-table td {
            padding: 9px 12px;
            border-bottom: 1px solid #e2e8f0;
            color: #334155;
            font-size: 10.5px;
        }

        .data-table tr:nth-child(even) {
            background-color: #f8fafc;
        }

        .data-table tr:last-child td {
            border-bottom: none;
        }

        /* ALINEACIÓN Y FORMATOS */
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .font-mono { font-family: monospace; font-size: 11px; }

        /* BADGES / ETIQUETAS */
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }

        .badge-compra { background-color: #dcfce7; color: #15803d; }     /* Verde */
        .badge-venta { background-color: #e0e7ff; color: #4338ca; }      /* Azul */
        .badge-desecho { background-color: #ffe4e6; color: #be123c; }    /* Rojo */
        .badge-devolucion { background-color: #fef3c7; color: #b45309; } /* Naranja */
        .badge-default { background-color: #f1f5f9; color: #475569; }    /* Gris */

        /* FOOTER */
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 9px;
            color: #94a3b8;
            border-top: 1px dashed #e2e8f0;
            padding-top: 10px;
        }
    </style>
</head>
<body>

    <!-- ENCABEZADO PRINCIPAL -->
    <div class="header-banner">
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="border: none; padding: 0;">
                    <h1>Reporte de Movimientos</h1>
                    <p>Carnes Frías Alberth — Control de Inventarios</p>
                </td>
                <td style="border: none; padding: 0; text-align: right; vertical-align: middle;">
                    <span style="background-color: rgba(255,255,255,0.2); padding: 6px 12px; border-radius: 20px; font-size: 11px; font-weight: bold;">
                        {{ count($movements) }} Registros
                    </span>
                </td>
            </tr>
        </table>
    </div>

    <!-- TARJETA DE INFORMACIÓN / FILTROS -->
    <div class="info-container">
        <div class="info-card">
            <table>
                <tr>
                    <td style="width: 33%;">
                        <span class="label">Filtro de Tipo</span><br>
                        <span class="value">{{ strtoupper($typeName) }}</span>
                    </td>
                    <td style="width: 33%;">
                        <span class="label">Rango de Fechas</span><br>
                        <span class="value">
                            {{ \Carbon\Carbon::parse($dateFrom)->format('d/m/Y') }} — {{ \Carbon\Carbon::parse($dateTo)->format('d/m/Y') }}
                        </span>
                    </td>
                    <td style="width: 33%; text-align: right;">
                        <span class="label">Fecha de Emisión</span><br>
                        <span class="value">{{ date('d/m/Y h:i A') }}</span>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <!-- TABLA DE RESULTADOS -->
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 15%;">Fecha / Hora</th>
                <th style="width: 15%;">Tipo</th>
                <th style="width: 12%;">Código</th>
                <th style="width: 30%;">Producto</th>
                <th style="width: 10%; text-align: right;">Cantidad</th>
                <th style="width: 18%;">Responsable</th>
            </tr>
        </thead>
        <tbody>
            @forelse($movements as $movement)
                @php
                    // Asignación de estilos dinamicos para las etiquetas
                    $typeNameLower = strtolower($movement->movementType->name ?? '');
                    $badgeClass = 'badge-default';
                    
                    if (str_contains($typeNameLower, 'compra')) $badgeClass = 'badge-compra';
                    elseif (str_contains($typeNameLower, 'venta')) $badgeClass = 'badge-venta';
                    elseif (str_contains($typeNameLower, 'desecho')) $badgeClass = 'badge-desecho';
                    elseif (str_contains($typeNameLower, 'devoluci')) $badgeClass = 'badge-devolucion';
                @endphp
                <tr>
                    <td class="font-mono">{{ $movement->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <span class="badge {{ $badgeClass }}">
                            {{ $movement->movementType->name ?? 'N/A' }}
                        </span>
                    </td>
                    <td class="font-mono" style="font-weight: bold; color: #4f46e5;">
                        {{ $movement->product->code ?? 'N/A' }}
                    </td>
                    <td style="font-weight: 600;">
                        {{ $movement->product->name ?? 'Producto no disponible' }}
                    </td>
                    <td class="text-right font-mono" style="font-weight: bold; font-size: 11px;">
                        {{ number_format($movement->quantity) }}
                    </td>
                    <td>{{ $movement->user->name ?? 'Sistema' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center" style="padding: 30px; color: #94a3b8; font-style: italic;">
                        No se encontraron movimientos registrados para este criterio de búsqueda.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- PIE DE PÁGINA -->
    <div class="footer">
        Documento generado automáticamente por el Sistema de Gestión Carnes Frías Alberth
    </div>

</body>
</html>