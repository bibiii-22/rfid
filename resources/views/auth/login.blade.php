<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Absensi Konferensi IPNU & IPPNU</title>
    <!-- SEO Meta Tags -->
    <meta name="description" content="Masuk ke dashboard admin Sistem Absensi RFID untuk Konferensi IPNU-XVIII & IPPNU-XVII Kabupaten Magetan guna mengelola data kehadiran dengan teknologi RFID.">
    <meta name="keywords" content="sistem absensi, RFID, IPNU, IPPNU, konferensi Magetan, absensi konferensi, login admin">
    <meta name="author" content="Sistem Absensi Konferensi IPNU & IPPNU">
    <meta name="robots" content="index, follow">
    <!-- Open Graph Tags for Social Media -->
    <meta property="og:title" content="Login - Sistem Absensi Konferensi IPNU & IPPNU">
    <meta property="og:description" content="Akses dashboard admin untuk mengelola absensi Konferensi IPNU-XVIII & IPPNU-XVII Kabupaten Magetan menggunakan teknologi RFID.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ route('login') }}">
    <meta property="og:image" content="{{ asset('images/logo.png') }}">
    <meta property="og:site_name" content="Sistem Absensi Konferensi IPNU & IPPNU">
    <!-- Twitter Card Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Login - Sistem Absensi Konferensi IPNU & IPPNU">
    <meta name="twitter:description" content="Masuk ke dashboard admin untuk mengelola absensi Konferensi IPNU-XVIII & IPPNU-XVII Kabupaten Magetan.">
    <meta name="twitter:image" content="{{ asset('images/logo.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">
</head>
<body class="bg-gradient-to-br from-red-50 to-orange-100 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full space-y-6" x-data="loginForm()">
        <!-- Logo/Header -->
        <div class="text-center">
            <div class="mx-auto h-16 w-16 bg-gradient-to-r from-red-600 to-orange-500 rounded-xl flex items-center justify-center mb-4 shadow-lg transform hover:scale-105 transition-transform duration-300">
                <i class="ri-scan-2-line ri-2x text-white"></i>
            </div>
            <h2 class="text-3xl font-bold text-gray-900 mb-2">Sistem Absensi RFID</h2>
            <p class="text-gray-600">Masuk ke dashboard admin</p>
        </div>

        <!-- Login Form -->
        <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-white/50 p-8">
            @if($errors->any())
                <div class="mb-4 p-4 rounded-lg bg-red-50 border border-red-200">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="ri-error-warning-line text-red-500"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">Terdapat kesalahan pada input Anda:</h3>
                            <div class="mt-2 text-sm text-red-700">
                                <ul class="list-disc pl-5 space-y-1">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}"
                  class="space-y-5"
                  x-ref="loginForm"
                  @submit.prevent="loading = true; $refs.loginForm.submit()">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Email
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="ri-mail-line text-gray-400"></i>
                        </div>
                        <input type="email" id="email" name="email" required
                               class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-colors"
                               placeholder="Masukkan email"
                               value="{{ old('email') }}"
                               :disabled="loading">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        Password
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="ri-lock-line text-gray-400"></i>
                        </div>
                        <input :type="showPassword ? 'text' : 'password'"
                               id="password"
                               name="password"
                               required
                               class="w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-colors"
                               placeholder="Masukkan password"
                               :disabled="loading">
                        <button type="button"
                                @click="showPassword = !showPassword"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center"
                                :disabled="loading">
                            <i :class="showPassword ? 'ri-eye-off-line' : 'ri-eye-line'"
                               class="text-gray-400 hover:text-gray-600"></i>
                        </button>
                    </div>
                </div>
                <div>
                    <button type="submit"
                            :disabled="loading"
                            class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-lg shadow-md text-sm font-medium text-white bg-gradient-to-r from-red-600 to-orange-500 hover:from-red-700 hover:to-orange-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-300 disabled:opacity-70 disabled:cursor-not-allowed">

                        <template x-if="!loading">
                            <span class="flex items-center">
                                <i class="ri-login-box-line mr-2"></i>
                                Masuk
                            </span>
                        </template>

                        <template x-if="loading">
                            <span class="flex items-center">
                                <!-- Spinner pakai Tailwind animate-spin -->
                                <svg class="animate-spin h-5 w-5 text-white mr-2" xmlns="http://www.w3.org/2000/svg" fill="none"
                                     viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                            stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                          d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                                </svg>
                                Memproses...
                            </span>
                        </template>
                    </button>
                </div>

                <div class="text-center pt-2">
                    <span class="text-sm text-gray-600">Belum punya akun? </span>
                    <a href="{{ route('register') }}" class="text-sm font-medium text-red-600 hover:text-red-500 transition-colors">
                        Daftar sekarang
                    </a>
                </div>
            </form>
        </div>

        <!-- Footer -->
        <div class="text-center text-sm text-gray-500">
            <p>&copy; {{ date('Y') }} Sistem Absensi RFID. All rights reserved.</p>
        </div>
    </div>

    <script>
    function loginForm() {
        return {
            showPassword: false,
            loading: false
        }
    }
    </script>
</body>
</html>
