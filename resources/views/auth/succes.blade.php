<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Password Reset Success</title>

  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen flex items-center justify-center bg-gray-100">
  <div class="bg-white shadow-lg rounded-2xl p-8 max-w-md w-full text-center">
    
    <!-- Ikon centang -->
    <div class="mx-auto mb-4 h-20 w-20 flex items-center justify-center rounded-full bg-green-100">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
      </svg>
    </div>

    <h1 class="text-2xl font-semibold text-green-600 mb-2">
      Password Berhasil Direset!
    </h1>

    <p class="text-gray-600 mb-6">
      Silakan buka aplikasi dan masuk menggunakan kata&nbsp;sandi baru&nbsp;Anda.
    </p>

    <!-- Tombol manual deep‑link -->
    <a
      href="myapp://reset-success"
      class="inline-block px-6 py-2 rounded-lg bg-green-600 hover:bg-green-700 text-white font-medium transition">
      Buka Aplikasi
    </a>
  </div>
</body>
</html>
