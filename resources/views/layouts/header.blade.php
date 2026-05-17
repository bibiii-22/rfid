<header class="bg-white border-b border-gray-200 fixed top-0 left-0 right-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-wrap justify-between items-center h-16">
            <!-- Logo + Teks -->
          <div class="flex items-center gap-3 flex-shrink-0">
    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-10 h-10">
    <h1 class="text-xl font-bold bg-gradient-to-r from-[#B71C1C] via-[#F57C00] to-[#FFC107] text-transparent bg-clip-text whitespace-nowrap">
        Dashboard Admin
    </h1>
</div>


            <!-- User Info + Dropdown -->
            <div class="relative mt-2 sm:mt-0" x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none cursor-pointer">
                    <!-- Nama hanya tampil di desktop/tablet -->
                    <span class="hidden sm:inline text-sm text-gray-500 truncate max-w-xs">
                        {{ auth()->user()->name }}
                    </span>

                    <div class="flex items-center ml-2">
                        <!-- Avatar User (ubah biru -> merah sesuai logo) -->
                        <div class="h-8 w-8 bg-red-600 rounded-full flex items-center justify-center mr-1 flex-shrink-0">
                            <span class="text-white text-sm font-medium">
                                @php
                                    $nameParts = explode(' ', auth()->user()->name);
                                    $initials = strtoupper(substr($nameParts[0], 0, 1));
                                    if (isset($nameParts[1])) {
                                        $initials .= strtoupper(substr($nameParts[1], 0, 1));
                                    }
                                    echo $initials;
                                @endphp
                            </span>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="h-4 w-4 text-gray-500 transition-transform duration-200"
                             :class="{ 'transform rotate-180': open }"
                             fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </button>

                <!-- Dropdown menu -->
                <div x-show="open" @click.away="open = false" x-transition
                     class="absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-gray-200 focus:outline-none z-50">
                    <div class="py-1" role="none">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 cursor-pointer">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
