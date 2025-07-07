<!DOCTYPE html>
<html>
<head>
    <title>Alert Notification</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap');
        
        body {
            font-family: 'Poppins', sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .logo {
            max-width: 150px;
            height: auto;
            margin-bottom: 15px;
        }
        
        .greeting {
            font-size: 18px;
            margin-bottom: 20px;
            color: #2c3e50;
        }
        
        .alert-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            overflow: hidden;
            margin-bottom: 25px;
        }
        
        .alert-header {
            padding: 15px 20px;
            font-size: 18px;
            font-weight: 600;
            color: white;
            display: flex;
            align-items: center;
        }
        
        .alert-icon {
            margin-right: 10px;
            font-size: 24px;
        }
        
        .alert-body {
            padding: 20px;
        }
        
        .alert-title {
            font-size: 20px;
            margin-top: 0;
            margin-bottom: 15px;
            color: #2c3e50;
        }
        
        .alert-details {
            margin-bottom: 15px;
        }
        
        .detail-row {
            display: flex;
            margin-bottom: 8px;
        }
        
        .detail-label {
            font-weight: 500;
            color: #7f8c8d;
            width: 120px;
        }
        
        .detail-value {
            font-weight: 600;
            color: #2c3e50;
        }
        
        .alert-message {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-top: 15px;
        }
        
        .footer {
            text-align: center;
            font-size: 12px;
            color: #95a5a6;
            margin-top: 30px;
        }
        
        /* Severity-specific styles */
        .critical .alert-header { background: #e74c3c; }
        .high .alert-header { background: #f39c12; }
        .medium .alert-header { background: #3498db; }
        .low .alert-header { background: #2ecc71; }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ $message->embed(public_path('images/LOGO.png')) }}" class="logo" alt="Company Logo">
    </div>
    
    <div class="greeting">
        Dear <strong>{{ $userName }}</strong>,
    </div>
    
    <div class="alert-container {{ $severity }}">
        <div class="alert-header">
            <span class="alert-icon">
                @if($severity == 'critical') 🔥
                @elseif($severity == 'high') ⚠️
                @elseif($severity == 'medium') ℹ️
                @else ✅
                @endif
            </span>
            {{ ucfirst($type) }} Alert - {{ ucfirst($severity) }} Priority
        </div>
        
        <div class="alert-body">
            <div class="alert-details">
                <div class="detail-row">
                    <div class="detail-label">Device ID:</div>
                    <div class="detail-value">{{ $deviceId }}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Device Name:</div>
                    <div class="detail-value">{{ $deviceName }}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Location:</div>
                    <div class="detail-value">{{ $deviceLocation }}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Date/Time:</div>
                    <div class="detail-value">{{ $alertTime }}</div>
                </div>
            </div>
            
            <div class="alert-message">
                <h3 class="alert-title">Alert Message:</h3>
                <p>{{ $messageContent }}</p>
            </div>
        </div>
    </div>
    
    <div class="footer">
        <p>This is an automated alert. Please do not reply to this email.</p>
        <p>© {{ date('Y') }} Your Company Name. All rights reserved.</p>
        <p><small>Alert ID: {{ $alertId }}</small></p>
    </div>
</body>
</html>