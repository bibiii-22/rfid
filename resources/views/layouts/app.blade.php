<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Admin - Sistem Absensi RFID')</title>
    <meta name="description" content="@yield('description', 'Dashboard Admin untuk Sistem Absensi RFID')">
   <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen pt-32">
    <!-- Header -->
    @include('layouts.header')
    <!-- Navigation -->
    @include('layouts.navbar')
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-2">
        @yield('content')
    </main>
</body>
</html>
