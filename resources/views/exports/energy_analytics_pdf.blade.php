<!DOCTYPE html>
<html>
<head>
    <title>Energy Analytics Report</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        h1, h2, h3 { margin: 0; padding: 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 4px; text-align: left; }
    </style>
</head>
<body>
    <h2>Energy Report for Device: {{ $device->device_id }}</h2>
    <p><strong>Latest Reading:</strong> {{ $latestReading->measured_at }}</p>

    <h3>Consumption Data (Hourly)</h3>
    <table>
        <thead>
            <tr><th>Hour</th><th>Power (kW)</th></tr>
        </thead>
        <tbody>
            @foreach($consumptionLabels as $index => $label)
                <tr>
                    <td>{{ $label }}</td>
                    <td>{{ $consumptionData[$index] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Energy History</h3>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Power (kW)</th>
                <th>Energy (kWh)</th>
                <th>Duration</th>
            </tr>
        </thead>
        <tbody>
            @foreach($energyHistory as $record)
                <tr>
                    <td>{{ $record['date'] ?? $record['timestamp'] }}</td>
                    <td>{{ $record['avg_power'] ?? $record['power'] }}</td>
                    <td>{{ $record['energy'] }}</td>
                    <td>{{ $record['duration'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Metrics</h3>
    <ul>
        <li>Average Daily Power: {{ $avgDailyPower }} kW</li>
        <li>Peak Power Today: {{ $peakPowerToday }} kW</li>
        <li>Energy Today: {{ $energyToday }} kWh</li>
    </ul>

    <h3>Prediction Summary</h3>
    <ul>
        <li>Total Energy: {{ $predictionData['aggregates']['total_energy'] ?? '-' }} kWh</li>
        <li>Average Power: {{ $predictionData['aggregates']['average_power'] ?? '-' }} kW</li>
        <li>Peak Power: {{ $predictionData['aggregates']['peak_power'] ?? '-' }} kW</li>
        <li>Estimated Cost: Rp {{ number_format($predictionData['aggregates']['estimated_cost'] ?? 0) }}</li>
    </ul>

    @if($plotUrl)
        <h3>Prediction Chart</h3>
        <img src="{{ $plotUrl }}" alt="Prediction Plot" style="width: 100%;">
    @endif
</body>
</html>
