<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Energy Report</title>
    <style>
        body { font-family: sans-serif; font-size: 14px; }
        h1 { color: #0d47a1; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        td, th { padding: 8px; border: 1px solid #ddd; }
    </style>
</head>
<body>
    <h1>Device Report: {{ $device->name }}</h1>
    <p><strong>Device ID:</strong> {{ $device->device_id }}</p>
    <p><strong>Latest Measurement:</strong> {{ $latestReading->measured_at }}</p>

    <table>
        <tr><th>Voltage</th><td>{{ $latestReading->voltage }} V</td></tr>
        <tr><th>Current</th><td>{{ $latestReading->current }} A</td></tr>
        <tr><th>Power</th><td>{{ $latestReading->power }} W</td></tr>
        <tr><th>Energy</th><td>{{ $latestReading->energy }} Wh</td></tr>
        <tr><th>Temperature</th><td>{{ $latestReading->temperature }} °C</td></tr>
        <tr><th>Humidity</th><td>{{ $latestReading->humidity }} %</td></tr>
    </table>

    <h2>Metrics Today</h2>
    <ul>
        <li>Average Power: {{ $avgDailyPower }} W</li>
        <li>Peak Power: {{ $peakPowerToday }} W</li>
        <li>Total Energy: {{ $energyToday }} Wh</li>
    </ul>
</body>
</html>
