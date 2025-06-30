<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Server Monitoring Report</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; line-height: 1.4; }
        h1, h2 { background: #f0f0f0; padding: 5px; }
        table { width: 100%; border-collapse: collapse; margin-top: 5px; }
        th, td { border: 1px solid #ccc; padding: 6px; }
        .section { margin-bottom: 20px; }
    </style>
</head>
<body>
    <h1>Server Monitoring Report</h1>
    <p>Generated at: {{ $data['timestamp'] }}</p>

    <div class="section">
        <h2>System Info</h2>
        <table>
            <tr><th>OS</th><td>{{ $data['system']['os'] ?? '-' }}</td></tr>
            <tr><th>Uptime</th><td>{{ $data['system']['uptime'] ?? '-' }}</td></tr>
            <tr><th>PHP Version</th><td>{{ $data['system']['php_version'] ?? '-' }}</td></tr>
        </table>
    </div>

    <div class="section">
        <h2>CPU</h2>
        <table>
            <tr><th>Usage</th><td>{{ $data['system']['cpu']['usage_percent'] ?? 0 }}%</td></tr>
            <tr><th>Load (1m)</th><td>{{ $data['system']['cpu']['load_1m'] ?? 0 }}</td></tr>
            <tr><th>Load (5m)</th><td>{{ $data['system']['cpu']['load_5m'] ?? 0 }}</td></tr>
            <tr><th>Load (15m)</th><td>{{ $data['system']['cpu']['load_15m'] ?? 0 }}</td></tr>
            <tr><th>Cores</th><td>{{ $data['system']['cpu']['cores'] ?? '-' }}</td></tr>
        </table>
    </div>

    <div class="section">
        <h2>Memory</h2>
        <table>
            <tr><th>Total</th><td>{{ $data['system']['memory']['total_mb'] ?? 0 }} MB</td></tr>
            <tr><th>Used</th><td>{{ $data['system']['memory']['used_mb'] ?? 0 }} MB</td></tr>
            <tr><th>Free</th><td>{{ $data['system']['memory']['free_mb'] ?? 0 }} MB</td></tr>
        </table>
    </div>

    <div class="section">
        <h2>Disk</h2>
        <table>
            <thead>
                <tr>
                    <th>Filesystem</th>
                    <th>Size</th>
                    <th>Used</th>
                    <th>Available</th>
                    <th>Usage %</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['system']['disk'] as $disk)
                <tr>
                    <td>{{ $disk['filesystem'] }}</td>
                    <td>{{ $disk['size'] }}</td>
                    <td>{{ $disk['used'] }}</td>
                    <td>{{ $disk['available'] }}</td>
                    <td>{{ $disk['use_percent'] }}%</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="section">
        <h2>Database</h2>
        <table>
            <tr><th>Driver</th><td>{{ $data['database']['driver'] ?? '-' }}</td></tr>
            <tr><th>Status</th><td>{{ $data['database']['status'] }}</td></tr>
            @if(isset($data['database']['error']))
            <tr><th>Error</th><td>{{ $data['database']['error'] }}</td></tr>
            @endif
        </table>
    </div>

    <div class="section">
        <h2>Application</h2>
        <table>
            <tr><th>Total Users</th><td>{{ $data['application']['business']['users'] ?? 0 }}</td></tr>
            <tr><th>Active Users (24h)</th><td>{{ $data['application']['business']['active_users'] ?? 0 }}</td></tr>
            <tr><th>Memory Usage</th><td>{{ \App\Http\Controllers\Admin\ServerMonitoringControllers::formatBytes($data['application']['performance']['memory_usage']) }}</td></tr>
        </table>
    </div>

    <div class="section">
        <h2>Errors & Security</h2>
        <table>
            <tr><th>Total Errors</th><td>{{ $data['errors']['errors']['total'] ?? 0 }}</td></tr>
            <tr><th>Errors in Last 24h</th><td>{{ $data['errors']['errors']['last_24h'] ?? 0 }}</td></tr>
            <tr><th>Failed Logins (24h)</th><td>{{ $data['errors']['security']['failed_logins'] ?? 0 }}</td></tr>
        </table>
    </div>
</body>
</html>
