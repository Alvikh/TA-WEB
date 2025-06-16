<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome - PowerSmartIQ</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            background: radial-gradient(circle at center, #0077cc 0%, #004080 100%);
        }
    </style>
</head>
<body class="flex items-center justify-center h-screen text-white">

    <div class="text-center space-y-6">
        <img src="{{ asset('images/LOGO.png') }}" alt="PowerSmartIQ Logo">
        <h1 class="text-2xl font-bold tracking-wide">Welcome Admin!</h1>
    <a href="/login" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-6 rounded-full transition duration-300 inline-block">
            Log in
        </a>
    </div>

</body>
</html>
