<nav class="bg-white border-b border-gray-200 fixed top-16 left-0 right-0 z-40">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex space-x-8">
            <a href="{{ route('dashboard') }}"
                class="border-b-2 {{ request()->routeIs('dashboard')
                    ? 'border-[#D32F2F] text-[#B71C1C]'
                    : 'border-transparent text-gray-500 hover:text-[#FB8C00] hover:border-[#FFC107]' }}
                py-4 px-1 text-sm font-medium">
                Dashboard
            </a>

            <a href="{{ route('peserta.index') }}"
                class="border-b-2 {{ request()->routeIs('peserta.*')
                    ? 'border-[#D32F2F] text-[#B71C1C]'
                    : 'border-transparent text-gray-500 hover:text-[#FB8C00] hover:border-[#FFC107]' }}
                py-4 px-1 text-sm font-medium">
                Peserta
            </a>

            <a href="{{ route('materi.index') }}"
                class="border-b-2 {{ request()->routeIs('materi.*')
                    ? 'border-[#D32F2F] text-[#B71C1C]'
                    : 'border-transparent text-gray-500 hover:text-[#FB8C00] hover:border-[#FFC107]' }}
                py-4 px-1 text-sm font-medium">
                Materi
            </a>

            <a href="{{ route('absensi.index') }}"
                class="border-b-2 {{ request()->routeIs('absensi.*')
                    ? 'border-[#D32F2F] text-[#B71C1C]'
                    : 'border-transparent text-gray-500 hover:text-[#FB8C00] hover:border-[#FFC107]' }}
                py-4 px-1 text-sm font-medium">
                Absensi
            </a>
        </div>
    </div>
</nav>
