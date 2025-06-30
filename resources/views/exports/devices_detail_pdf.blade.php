<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Device Detail Report</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
        }
        .header {
            background-color: #4f46e5;
            color: white;
            padding: 10px 20px;
            text-align: center;
        }
        .section {
            margin-top: 20px;
        }
        .section-title {
            font-weight: bold;
            margin-bottom: 10px;
            color: #1e40af;
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
        }
        .info-table th, .info-table td {
            padding: 8px;
            text-align: left;
        }
        .info-table th {
            width: 30%;
            background-color: #f3f4f6;
        }
        .info-table td {
            background-color: #f9fafb;
        }
    </style>
</head>
<body>

    <div class="header">
        <h2>Device Detail Report</h2>
        <p>{{ $device->name }}</p>
    </div>

    <div class="section">
        <div class="section-title">Basic Information</div>
        <table class="info-table">
            <tr>
                <th>Name</th>
                <td>{{ $device->name }}</td>
            </tr>
            <tr>
                <th>Device ID</th>
                <td>{{ $device->device_id }}</td>
            </tr>
            <tr>
                <th>Type</th>
                <td>{{ ucfirst($device->type) }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>{{ ucfirst($device->status) }}</td>
            </tr>
            <tr>
                <th>Building</th>
                <td>{{ $device->building }}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Installation Information</div>
        <table class="info-table">
            <tr>
                <th>Installation Date</th>
                <td>{{ $device->installation_date ? $device->installation_date->format('M j, Y') : 'Not specified' }}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">System Information</div>
        <table class="info-table">
            <tr>
                <th>Created At</th>
                <td>{{ $device->created_at->format('M j, Y g:i A') }}</td>
            </tr>
            <tr>
                <th>Last Updated</th>
                <td>{{ $device->updated_at->format('M j, Y g:i A') }}</td>
            </tr>
        </table>
    </div>

</body>
</html>
