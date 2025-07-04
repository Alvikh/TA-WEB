<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login - Smart Power Management</title>
  <link rel="icon" href="{{ asset('images/LOGO.png') }}" type="image/png" />
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap');
    body {
      font-family: 'Inter', sans-serif;
    }
  </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-blue-900 via-[#0A4E87] to-cyan-500 flex items-center justify-center px-4">

  <!-- Login Card -->
  <div class="bg-white/10 backdrop-blur-lg shadow-2xl rounded-3xl w-full max-w-4xl p-10 flex items-center gap-10">

    <!-- Login Form -->
    <form method="POST" action="{{ route('login') }}" class="w-full max-w-md text-white space-y-6 relative">
      @csrf

      <!-- Error Login Message -->
      @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
          <strong class="font-bold">Login gagal!</strong>
          <span class="block sm:inline">{{ session('error') }}</span>
        </div>
      @endif

      <!-- Email -->
      <div>
        <label for="email" class="block text-sm font-medium mb-1">
          Email <span class="text-yellow-400">*</span>
        </label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" required
               class="w-full px-4 py-3 rounded-lg bg-white text-gray-900 shadow focus:outline-none focus:ring-2 focus:ring-teal-400 transition" />
        @error('email')
          <p class="text-sm text-red-300 mt-1">{{ $message }}</p>
        @enderror
      </div>

      <!-- Password -->
      <div class="relative">
        <label for="password" class="block text-sm font-medium mb-1">
          Password <span class="text-yellow-400">*</span>
        </label>
        <input type="password" id="password" name="password" required
               class="w-full px-4 py-3 rounded-lg bg-white text-gray-900 shadow focus:outline-none focus:ring-2 focus:ring-teal-400 transition pr-12" />
        <button type="button" id="togglePassword" class="absolute top-[42px] right-4 text-gray-600 focus:outline-none">
          <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
               viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 
                  9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 
                  0-8.268-2.943-9.542-7z" />
          </svg>
        </button>
        @error('password')
          <p class="text-sm text-red-300 mt-1">{{ $message }}</p>
        @enderror
      </div>

      <!-- Submit -->
      <button type="submit"
              class="w-full bg-teal-500 hover:bg-teal-600 text-white font-semibold py-3 rounded-full shadow-md transition">
        Log In
      </button>
    </form>

    <!-- Logo Section -->
    <div class="hidden md:flex justify-center items-center w-1/2">
      <img src="{{ asset('images/LOGO.png') }}" alt="SPM Logo" class="h-40 w-40 object-contain drop-shadow-lg" />
    </div>
  </div>

  <!-- Toggle Password Script -->
  <script>
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');

    let isVisible = false;

    togglePassword.addEventListener('click', () => {
      isVisible = !isVisible;
      passwordInput.type = isVisible ? 'text' : 'password';

      eyeIcon.innerHTML = isVisible
        ? `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7
                a9.966 9.966 0 012.106-3.592m1.453-1.453C7.523 6.057 
                9.675 5 12 5c4.478 0 8.268 2.943 
                9.542 7a9.977 9.977 0 01-4.293 
                5.263M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 3l18 18" />`
        : `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 
                8.268 2.943 9.542 7-1.274 4.057-5.064 
                7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />`;
    });
  </script>

</body>
</html>
