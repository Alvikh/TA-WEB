<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laporan Prediksi Energi - {{ $device->name ?? 'Device' }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; line-height: 1.6; }
        h1, h2, h3 { margin: 0; padding: 0; }
        .container { padding: 20px; }
        .section { margin-bottom: 30px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background-color: #f0f0f0; }
        .chart {
            text-align: center;
            margin-top: 20px;
        }
        .footer {
            font-size: 10px;
            text-align: center;
            margin-top: 40px;
            border-top: 1px solid #ccc;
            padding-top: 10px;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Laporan Prediksi Energi</h1>
    <p><strong>Nama Perangkat:</strong> {{ $device->name ?? '-' }}</p>
    <p><strong>ID Perangkat:</strong> {{ $device->device_id }}</p>
    <p><strong>Tanggal:</strong> {{ now()->format('d-m-Y H:i:s') }}</p>

    <div class="section">
        <h2>Data Agregat</h2>
        <table>
            <tr>
                <th>Total Energi (kWh)</th>
                <th>Daya Rata-rata (W)</th>
                <th>Daya Puncak (W)</th>
                <th>Estimasi Biaya (Rp)</th>
            </tr>
            <tr>
                <td>{{ number_format($predictionData['aggregates']['total_energy'], 2) }}</td>
                <td>{{ number_format($predictionData['aggregates']['average_power'], 2) }}</td>
                <td>{{ number_format($predictionData['aggregates']['peak_power'], 2) }}</td>
                <td>{{ number_format($predictionData['aggregates']['estimated_cost'], 2) }}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <h2>Prediksi Penggunaan Energi</h2>
        <p><strong>Prediksi Energi:</strong> {{ number_format($predictionData['predictedUsage'], 2) }} kWh</p>
        <p><strong>Potensi Penghematan:</strong> {{ number_format($predictionData['savingsPotential'], 2) }}%</p>
    </div>

    @if (!empty($predictionData['labels']) && !empty($predictionData['data']))
    <div class="section">
        <h2>Grafik Prediksi</h2>
        <table>
            <tr>
                <th>Waktu</th>
                <th>Energi (kWh)</th>
            </tr>
            @foreach($predictionData['labels'] as $index => $label)
                <tr>
                    <td>{{ $label }}</td>
                    <td>{{ number_format($predictionData['data'][$index], 2) }}</td>
                </tr>
            @endforeach
        </table>
    </div>
    @endif

    @if (!empty($predictionData['plot_url']))
    <div class="chart">
        <img src="{{ $predictionData['plot_url'] }}" alt="Grafik Prediksi Energi" style="width: 100%; max-width: 600px;">
    </div>
    @endif

    <div class="footer">
        &copy; {{ date('Y') }} Sistem Monitoring Energi IoT. Generated on {{ now()->format('d-m-Y H:i') }}.
    </div>
</div>
</body>
</html>
