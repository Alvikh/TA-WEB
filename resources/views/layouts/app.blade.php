<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>
    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
        <link rel="icon" href="{{ asset('images.LOGO') }}" type="image/png"/>

    <!-- Flowbite CDN -->
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css"
      rel="stylesheet"
    />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />


    @vite('resources/css/app.css') {{-- Pastikan Tailwind sudah di-compile --}}
</head>
<body class="bg-gray-100 text-gray-900 flex">

    {{-- Include Sidebar --}}
    @include('layouts.sidebar')

    {{-- Main Content Area --}}
    <div class="flex-1 ml-0 h-screen flex flex-col overflow-hidden">

        {{-- Content --}}
        <main class="flex-1 p-6 overflow-y-auto">
            @yield('content')
        </main>

        {{-- Footer --}}
        <footer class="bg-white shadow px-6 py-4 text-sm text-gray-600 text-center">
            &copy; {{ date('Y') }} Your Company. All rights reserved.
        </footer>
    </div>

</body>
</html>
