<!DOCTYPE html>
<html>
<head>
    <title>Alert Notification</title>
    <style>
        .alert {
            border: 1px solid;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        .critical { background-color: #f8d7da; border-color: #f5c6cb; color: #721c24; }
        .high { background-color: #fff3cd; border-color: #ffeeba; color: #856404; }
        .medium { background-color: #e2e3e5; border-color: #d6d8db; color: #383d41; }
        .low { background-color: #d4edda; border-color: #c3e6cb; color: #155724; }
    </style>
</head>
<body>
    <h2>Alert Notification</h2>
    
    <div class="alert {{ $severity }}">
        <h3>{{ ucfirst($type) }} Alert</h3>
        <p><strong>Severity:</strong> {{ ucfirst($severity) }}</p>
        <p><strong>Message:</strong></p>
        <p>{{ $messageContent }}</p>
    </div>
    
    <p>This is an automated alert. Please do not reply to this email.</p>
</body>
</html>