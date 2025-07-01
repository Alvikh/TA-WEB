<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Device Report</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #333; padding: 6px; text-align: left; }
        th { background-color: #f0f0f0; }
    </style>
</head>
<body>
    <h2>Device Report</h2>
    <p><strong>Export Date:</strong> {{ now()->format('d M Y, H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Device ID</th>
                <th>Building</th>
                <th>Type</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($devices as $device)
                <tr>
                    <td>{{ $device->name }}</td>
                    <td>{{ $device->device_id }}</td>
                    <td>{{ $device->building }}</td>
                    <td>{{ $device->type }}</td>
                    <td>{{ ucfirst($device->status) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
