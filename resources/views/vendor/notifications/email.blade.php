<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap');
        
        body {
            font-family: 'Poppins', sans-serif;
            line-height: 1.6;
            color: #333333;
            background-color: #f7f9fc;
            margin: 0;
            padding: 0;
        }
        
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .card {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            padding: 30px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 25px;
        }
        
        .logo {
            width: 120px;
            margin-bottom: 20px;
        }
        
        h1 {
            color: #2d3748;
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 20px;
        }
        
        p {
            margin-bottom: 20px;
            font-size: 15px;
            color: #4a5568;
        }
        
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background-color: #4f46e5;
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 500;
            margin: 20px 0;
            text-align: center;
            transition: all 0.3s ease;
        }
        
        .btn:hover {
            background-color: #4338ca;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.2);
        }
        
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 14px;
            color: #718096;
        }
        
        .divider {
            height: 1px;
            background-color: #e2e8f0;
            margin: 25px 0;
        }
        
        .small-text {
            font-size: 13px;
            color: #718096;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="header">
                <img src="https://pey.my.id/images/LOGO3.png" alt="Logo" class="logo">
                <h1>Reset Password Akun Anda</h1>
            </div>
            
            <p>Halo,</p>
            
            <p>Kami menerima permintaan untuk mereset password Anda. Klik tombol di bawah ini untuk melanjutkan proses pengubahan password Anda:</p>
            
            <div style="text-align: center;">
                <a href="{{ $actionUrl }}" class="btn">Reset Password</a>
            </div>
            
            <p class="small-text">Jika tombol di atas tidak bekerja, salin dan tempel URL berikut di browser Anda:<br>
            <span style="word-break: break-all;">{{ $actionUrl }}</span></p>
            
            <div class="divider"></div>
            
            <p class="small-text">Jika Anda tidak pernah meminta reset password, abaikan saja email ini. Password Anda tetap aman.</p>
            
            <div class="footer">
                <p>Terima kasih,<br>Tim Power Smart Management</p>
            </div>
        </div>
    </div>
</body>
</html>