<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Report</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
            color: #333;
        }
        h1 {
            text-align: center;
            color: #1D4ED8;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #CCC;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #1D4ED8;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #F3F4F6;
        }
        .status-active {
            color: green;
            font-weight: bold;
        }
        .status-inactive {
            color: red;
            font-weight: bold;
        }
        .role-admin {
            color: purple;
            font-weight: bold;
        }
        .role-user {
            color: blue;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1>User Report</h1>
    <p><strong>Exported at:</strong> {{ now()->format('d M Y, H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Name / ID</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Role</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $index => $user)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $user->name }}<br><small>ID: {{ $user->id }}</small></td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->phone ?? '-' }}</td>
                <td>{{ $user->address ?? '-' }}</td>
                <td class="role-{{ $user->role }}">{{ ucfirst($user->role) }}</td>
                <td class="status-{{ $user->status }}">{{ ucfirst($user->status) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
