<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Detail PDF</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
        }
        .header {
            background-color: #2563eb;
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
            color: #2563eb;
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
        <h2>User Detail Report</h2>
        <p>{{ $user->name }}</p>
    </div>

    <div class="section">
        <div class="section-title">Account Information</div>
        <table class="info-table">
            <tr>
                <th>Name</th>
                <td>{{ $user->name }}</td>
            </tr>
            <tr>
                <th>Username</th>
                <td>{{ $user->username ?? 'Not set' }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $user->email }}</td>
            </tr>
            <tr>
                <th>Email Verified</th>
                <td>{{ $user->email_verified_at ? $user->email_verified_at->format('M j, Y g:i A') : 'Not verified' }}</td>
            </tr>
            <tr>
                <th>Phone</th>
                <td>{{ $user->phone ?? 'Not set' }}</td>
            </tr>
            <tr>
                <th>Role</th>
                <td>{{ ucfirst($user->role) }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>{{ ucfirst($user->status) }}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Contact Information</div>
        <table class="info-table">
            <tr>
                <th>Address</th>
                <td>{{ $user->address ?? 'Not set' }}</td>
            </tr>
            <tr>
                <th>Last Login</th>
                <td>{{ $user->last_login_at ? $user->last_login_at->format('M j, Y g:i A') : 'Never logged in' }}</td>
            </tr>
            <tr>
                <th>Last Login IP</th>
                <td>{{ $user->last_login_ip ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Created At</th>
                <td>{{ $user->created_at->format('M j, Y g:i A') }}</td>
            </tr>
            <tr>
                <th>Updated At</th>
                <td>{{ $user->updated_at->format('M j, Y g:i A') }}</td>
            </tr>
        </table>
    </div>

</body>
</html>
