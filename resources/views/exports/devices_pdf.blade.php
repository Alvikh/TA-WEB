<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Device Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 13px;
            color: #333;
            background-color: #fff;
            margin: 40px;
        }
        h2 {
            color: #2c3e50;
            margin-bottom: 5px;
        }
        p {
            margin-top: 0;
            margin-bottom: 20px;
            color: #555;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px 10px;
            text-align: left;
        }
        th {
            background-color: #f9fafb;
            color: #111;
        }
        tbody tr:hover {
            background-color: #f1f5f9;
        }
        .status-active {
            background-color: #d1fae5;
            color: #065f46;
            font-weight: bold;
        }
        .status-inactive {
            background-color: #fee2e2;
            color: #991b1b;
            font-weight: bold;
        }
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
                    <td class="{{ $device->status == 'active' ? 'status-active' : 'status-inactive' }}">
                        {{ ucfirst($device->status) }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
