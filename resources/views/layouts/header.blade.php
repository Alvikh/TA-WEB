<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Power Management</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            background: radial-gradient(circle at center, #0077cc 0%, #004080 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .feature-card {
            backdrop-filter: blur(10px);
            background-color: rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            background-color: rgba(255, 255, 255, 0.15);
        }

        .btn-download {
            background: linear-gradient(135deg, #00b4db, #0083b0);
            border: none;
        }

        .btn-download:hover {
            background: linear-gradient(135deg, #0083b0, #00b4db);
        }

        .service-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }

        .service-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .team-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(5px);
            transition: all 0.3s ease;
        }

        .team-card:hover {
            transform: translateY(-5px);
            background: rgba(255, 255, 255, 0.1);
        }

    </style>
</head>
<body>
