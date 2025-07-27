<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Report (Excel)</title>
    <meta http-equiv="Content-Type" content="application/vnd.ms-excel; charset=UTF-8" />
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        h2 {
            margin-bottom: 5px;
        }
        p {
            margin-top: 0;
            margin-bottom: 20px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        table, th, td {
            border: 1px solid #000;
        }
        th {
            background-color: #f2f2f2;
            text-align: left;
        }
        th, td {
            padding: 6px 8px;
        }
        .text {
            mso-number-format: "\@"; /* Force Excel to treat as text */
        }
    </style>
</head>
<body>
    <h2>User Report</h2>
    <p><strong>Exported at:</strong> {{ now()->format('d M Y, H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th style="width: 20%;">Name</th>
                <th style="width: 25%;">Email</th>
                <th style="width: 15%;">Phone</th>
                <th style="width: 20%;">Address</th>
                <th style="width: 10%;">Role</th>
                <th style="width: 10%;">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td class="text">{{ $user->phone ?? '-' }}</td>
                    <td>{{ $user->address ?? '-' }}</td>
                    <td>{{ ucfirst($user->role) }}</td>
                    <td>{{ ucfirst($user->status) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
