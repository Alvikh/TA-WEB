<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laporan Energi & Prediksi - {{ $device->name ?? 'Perangkat' }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }

        h1, h2, h3 {
            margin: 0;
            padding: 0;
        }

        .container {
            padding: 20px;
        }

        .section {
            margin-bottom: 25px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #aaa;
            padding: 6px;
            text-align: left;
        }

        th {
            background-color: #f0f0f0;
        }

        .chart {
            text-align: center;
            margin-top: 20px;
        }

        .footer {
            margin-top: 40px;
            font-size: 10px;
            text-align: center;
            color: #666;
            border-top: 1px solid #ccc;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Laporan Energi & Prediksi</h1>
        <p><strong>Tanggal:</strong> {{ now()->format('d-m-Y H:i:s') }}</p>

        <!-- Informasi Perangkat -->
        <div class="section">
            <h2>Informasi Perangkat</h2>
            <table>
                <tr>
                    <th>Nama Perangkat</th>
                    <td>{{ $device->name ?? '-' }}</td>
                </tr>
                <tr>
                    <th>ID Perangkat</th>
                    <td>{{ $device->device_id }}</td>
                </tr>
            </table>
        </div>

        <!-- Pembacaan Sensor Terbaru -->
        <div class="section">
            <h2>Pembacaan Sensor Terbaru</h2>
            <table>
                <tr>
                    <th>Tegangan (V)</th>
                    <th>Arus (A)</th>
                    <th>Daya (W)</th>
                    <th>Energi (kWh)</th>
                    <th>Frekuensi (Hz)</th>
                    <th>Faktor Daya</th>
                    <th>Suhu (°C)</th>
                    <th>Kelembapan (%)</th>
                </tr>
                <tr>
                    <td>{{ $latestReading->voltage }}</td>
                    <td>{{ $latestReading->current }}</td>
                    <td>{{ $latestReading->power }}</td>
                    <td>{{ $latestReading->energy }}</td>
                    <td>{{ $latestReading->frequency ?? '-' }}</td>
                    <td>{{ $latestReading->power_factor ?? '-' }}</td>
                    <td>{{ $latestReading->temperature ?? '-' }}</td>
                    <td>{{ $latestReading->humidity ?? '-' }}</td>
                </tr>
            </table>
        </div>

        <!-- Statistik Hari Ini -->
        <div class="section">
            <h2>Statistik Hari Ini</h2>
            <table>
                <tr>
                    <th>Daya Rata-rata (W)</th>
                    <th>Daya Puncak (W)</th>
                    <th>Total Energi (kWh)</th>
                </tr>
                <tr>
                    <td>{{ $avgDailyPower }}</td>
                    <td>{{ $peakPowerToday }}</td>
                    <td>{{ $energyToday }}</td>
                </tr>
            </table>
        </div>

        <!-- Prediksi Energi -->
        @if (!empty($predictionData))
        <div class="section">
            <h2>Prediksi Penggunaan Energi</h2>
            <table>
                <tr>
                    <th>Total Energi Prediksi (kWh)</th>
                    <th>Daya Rata-rata Prediksi (W)</th>
                    <th>Daya Puncak Prediksi (W)</th>
                    <th>Estimasi Biaya (Rp)</th>
                    <th>Potensi Penghematan (%)</th>
                </tr>
                <tr>
                    <td>{{ number_format($predictionData['aggregates']['total_energy'], 2) }}</td>
                    <td>{{ number_format($predictionData['aggregates']['average_power'], 2) }}</td>
                    <td>{{ number_format($predictionData['aggregates']['peak_power'], 2) }}</td>
                    <td>{{ number_format($predictionData['aggregates']['estimated_cost'], 0) }}</td>
                    <td>{{ number_format($predictionData['savingsPotential'], 2) }}</td>
                </tr>
            </table>
        </div>

        <!-- Data Prediksi Per Jam -->
        @if (!empty($predictionData['labels']))
        <div class="section">
            <h3>Data Prediksi per Jam (Sample)</h3>
            <table>
                <tr>
                    <th>Waktu</th>
                    <th>Daya (kWh)</th>
                </tr>
                @foreach($predictionData['labels'] as $i => $label)
                    <tr>
                        <td>{{ $label }}</td>
                        <td>{{ $predictionData['data'][$i] ?? '-' }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
        @endif

        <!-- Gambar Grafik -->
        @if (!empty($predictionData['plot_url']))
        <div class="chart">
            <p><strong>Grafik Prediksi Energi:</strong></p>
            <img src="{{ $predictionData['plot_url'] }}" alt="Grafik Prediksi" style="width: 100%; max-width: 600px;">
        </div>
        @endif
        @endif

        <div class="footer">
            &copy; {{ date('Y') }} Sistem Monitoring Energi IoT - Laporan dibuat otomatis.
        </div>
    </div>
</body>
</html>
