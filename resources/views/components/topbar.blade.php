<header class="bg-white shadow px-6 py-2 flex justify-between items-center sticky top-0 z-50">
    <div class="flex items-center gap-4">
        <h1 class="text-xl font-semibold text-gray-800">@yield('page-title', 'Dashboard')</h1>
    </div>
    <div class="flex items-center gap-4">
        <button class="relative p-2 rounded-full hover:bg-gray-100 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
            </svg>
            <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full animate-ping"></span>
        </button>

        <!-- User Avatar Dropdown -->
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open" class="flex items-center gap-2 p-2 rounded-full hover:bg-gray-100 transition">
                <img src="{{ asset('images/avatar.png') }}" alt="User Avatar" class="w-8 h-8 rounded-full object-cover">
                <span class="hidden md:block text-gray-700 font-medium">Admin</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <!-- Dropdown Menu -->
            <div x-show="open" @click.away="open = false" x-transition
                class="absolute right-0 mt-2 w-48 bg-white border rounded-md shadow-lg py-2 z-50">
                <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-pink-50 hover:text-pink-600">Profile</a>
                <a href="#"
                    class="block px-4 py-2 text-gray-700 hover:bg-pink-50 hover:text-pink-600">Settings</a>
                {{-- <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full text-left px-4 py-2 text-gray-700 hover:bg-pink-50 hover:text-pink-600">
                        Logout
                    </button>
                </form> --}}
            </div>
        </div>
    </div>
</header>
