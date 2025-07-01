<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>User Report</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }
        h2 {
            margin-bottom: 0;
        }
        p {
            margin-top: 4px;
            margin-bottom: 15px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #333;
            padding: 6px;
            text-align: left;
        }
        th {
            background-color: #f0f0f0;
        }
    </style>
</head>
<body>
    <h2>User Report</h2>
    <p><strong>Exported at:</strong> {{ now()->format('d M Y, H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Role</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone ?? '-' }}</td>
                    <td>{{ $user->address ?? '-' }}</td>
                    <td>{{ ucfirst($user->role) }}</td>
                    <td>{{ ucfirst($user->status) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
