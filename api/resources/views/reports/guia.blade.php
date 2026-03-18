<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura de Paquetería - {{ $data->track_number }}</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 10px;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            width: 100%;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 1px solid #eee;
            padding-bottom: 20px;
        }
        .header img {
            max-width: 150px;
            margin-bottom: 10px;
        }
        .header h1 {
            font-size: 24px;
            margin: 0;
            color: #0056b3;
        }
        .invoice-details {
            width: 100%;
            margin-bottom: 30px;
            border-collapse: collapse;
        }
        .invoice-details td {
            padding: 5px 0;
            vertical-align: top;
        }
        .invoice-details .label {
            font-weight: bold;
            width: 120px;
        }
        .address-box {
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 20px;
            min-height: 80px;
        }
        .section-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #0056b3;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .total {
            text-align: right;
            font-size: 14px;
            font-weight: bold;
            margin-top: 20px;
        }
        .barcode-section {
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }
        .barcode-section p {
            margin-bottom: 5px;
            font-size: 12px;
        }
        .footer {
            text-align: center;
            margin-top: 50px;
            font-size: 9px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            @if(isset($base64))
                <img src="{{ $base64 }}" alt="Membrete de la Empresa">
            @endif
            <h1>Factura de Paquetería</h1>
            <p>Fecha: {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</p>
        </div>

        <table class="invoice-details">
            <tr>
                <td class="label">Número de Rastreo:</td>
                <td><strong>{{ $data->track_number }}</strong></td>
                <td class="label">Tipo de Paquete:</td>
                <td>{{ $data->type->description ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="label">Estado Actual:</td>
                <td>{{ $data->status->status ?? 'N/A' }}</td>
                <td class="label">Peso:</td>
                <td>{{ $data->weight->description  ?? 'N/A' }} kg</td>
            </tr>
            <tr>
                <td class="label">Tamaño:</td>
                <td>{{ $data->size->description  ?? 'N/A' }}</td>
                <td class="label">Origen (Región):</td>
                <td>{{ $data->region->name ?? 'N/A' }}</td>
            </tr>
        </table>

        <div style="width: 100%; display: flex; justify-content: space-between;">
            <div style="width: 48%; float: left;">
                <div class="section-title">Remitente</div>
                <div class="address-box">
                    <p><strong>Nombre:</strong> {{ $data->client->user->name ?? 'N/A' }}</p>
                    <p><strong>Email:</strong> {{ $data->client->user->email ?? 'N/A' }}</p>
                    <p><strong>Teléfono:</strong> {{ $data->client->phone ?? 'N/A' }}</p>
                    <p><strong>Dirección:</strong> {{ $data->address_from->street ?? 'N/A' }}, {{ $data->address_from->number ?? 'N/A' }}</p>
                    <p>{{ $data->address_from->city ?? 'N/A' }}, {{ $data->address_from->state ?? 'N/A' }}</p>
                    <p>C.P. {{ $data->address_from->zip_code ?? 'N/A' }}</p>
                </div>
            </div>
            <div style="width: 48%; float: right;">
                <div class="section-title">Destinatario</div>
                <div class="address-box">
                    <p><strong>Nombre:</strong> {{ $data->address_to->name ?? 'N/A' }}</p>
                    <p><strong>Email:</strong> {{ $data->address_to->contact_email ?? 'N/A' }}</p>
                    <p><strong>Teléfono:</strong> {{ $data->address_to->contact_phone ?? 'N/A' }}</p>
                    <p><strong>Dirección:</strong> {{ $data->address_to->street ?? 'N/A' }}, {{ $data->address_to->number ?? 'N/A' }}</p>
                    <p>{{ $data->address_to->city ?? 'N/A' }}, {{ $data->address_to->state ?? 'N/A' }}</p>
                    <p>C.P. {{ $data->address_to->zip_code ?? 'N/A' }}</p>
                </div>
            </div>
        </div>
        <div style="clear: both;"></div> {{-- Clear float --}}

        <div class="section-title">Detalles del Servicio</div>
        <table>
            <thead>
                <tr>
                    <th>Descripción</th>
                    <th>Valor</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Costo de Envío</td>
                    <td>$ {{ number_format($data->price ?? 0, 2) }}</td>
                </tr>
                <tr>
                    <td>Costo Adicional (si aplica)</td>
                    <td>$ {{ number_format($data->additional_cost ?? 0, 2) }}</td>
                </tr>
                {{-- Agrega más filas para otros detalles de costos o servicios --}}
            </tbody>
        </table>

        <div class="total">
            Total a Pagar: $ {{ number_format(($data->price ?? 0) + ($data->additional_cost ?? 0), 2) }}
        </div>

        <div class="barcode-section">
            <p><strong>Número de Rastreo:</strong> {{ $data->track_number }}</p>
        
            
            <?php echo '<img src="data:image/jpeg;base64,' . DNS1D::getBarcodeJPG($data->track_number, 'C128') . '" alt="barcode"   />'; ?>
            <p style="font-size: 9px; margin-top: 5px;">Escanee para rastrear su paquete</p>
        </div>

        <div class="footer">
            <p>Gracias por usar nuestros servicios de paquetería.</p>
            <p>Para cualquier consulta, contáctenos en EMAIL o TELÉFONO .</p>
        </div>
    </div>
</body>
</html>