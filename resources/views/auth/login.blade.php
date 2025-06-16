<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login - PowerSmartIQ</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap');
    body {
      font-family: 'Inter', sans-serif;
    }
  </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-blue-900 via-[#0A4E87] to-cyan-500 flex items-center justify-center px-4">

  <!-- Back button -->
<a href="/" class="absolute top-6 left-6 flex items-center gap-2 text-white bg-teal-500 hover:bg-teal-600 px-4 py-2 rounded-full shadow-lg transition">
  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"/>
  </svg>
  <span class="font-semibold">Back</span>
</a>

  <!-- Login Card -->
  <div class="bg-white/10 backdrop-blur-lg shadow-2xl rounded-3xl w-full max-w-4xl p-10 flex items-center gap-10">

    <!-- Login Form -->
    <form method="POST" action="{{ route('login') }}" class="w-full max-w-md text-white space-y-6">
      @csrf

      <div>
        <label for="email" class="block text-sm font-medium mb-1">Email <span class="text-yellow-400">*</span></label>
        <input type="email" id="email" name="email" required
               class="w-full px-4 py-3 rounded-lg bg-white text-gray-900 shadow focus:outline-none focus:ring-2 focus:ring-teal-400 transition" />
      </div>

      <div>
        <label for="password" class="block text-sm font-medium mb-1">Password <span class="text-yellow-400">*</span></label>
        <input type="password" id="password" name="password" required
               class="w-full px-4 py-3 rounded-lg bg-white text-gray-900 shadow focus:outline-none focus:ring-2 focus:ring-teal-400 transition" />
      </div>

      <button type="submit"
              class="w-full bg-teal-500 hover:bg-teal-600 text-white font-semibold py-3 rounded-full shadow-md transition">
        Log In
      </button>
    </form>

    <!-- Logo Section -->
    <div class="hidden md:flex justify-center items-center w-1/2">
      <img src="{{ asset('images/LOGO.png') }}" alt="PowerSmartIQ Logo" class="h-40 w-40 object-contain drop-shadow-lg" />
    </div>
  </div>

</body>
</html>
