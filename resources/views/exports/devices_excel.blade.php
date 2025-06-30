<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Device Report</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 14px;
        }
        h2 {
            margin-bottom: 5px;
        }
        p {
            margin-top: 0;
            margin-bottom: 15px;
        }
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
        th, td {
            padding: 6px 10px;
        }
        th {
            background-color: #f0f0f0;
        }
    </style>
</head>
<body>
    <h2>Device Report</h2>
    <p><strong>Exported at:</strong> {{ now()->format('d M Y, H:i') }}</p>

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
