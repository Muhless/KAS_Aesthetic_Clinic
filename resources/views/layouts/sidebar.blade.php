<aside class="w-64 bg-white shadow-xl hidden md:flex flex-col border-r border-primary-100">
    <div class="p-3 flex justify-center">
        <div class="w-15">
            <img src="{{ asset('images/logo_kas.png') }}" class="w-full object-contain" />
        </div>
    </div>

    {{-- Navigation --}}
    <nav class="p-4 flex-1 space-y-1">
        <a href="/"
            class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition-all">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001 1h4a1 1 0 001-1v-4a1 1 0 00-1-1h-4a1 1 0 00-1 1v4z" />
            </svg>
            Halaman Awal
        </a>

        <a href="/patient"
            class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition-all">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M5.121 17.804A8 8 0 1118.48 4.465" />
            </svg>
            Pasien
        </a>

        {{-- Treatment (with submenu) --}}
        <div x-data="{ open: false }" class="space-y-1">

            <button @click="open = !open"
                class="w-full flex items-center justify-between gap-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition-all">
                <div class="flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 17l-4-4m0 0l4-4m-4 4h14" />
                    </svg>

                    <span>Treatment</span>
                </div>

                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 transition-transform"
                    :class="open ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            {{-- Submenu --}}
            <div x-show="open" x-collapse class="pl-10 space-y-1 text-sm">

                <a href="/treatment"
                    class="block px-3 py-2 rounded-lg text-gray-600 hover:bg-primary-50 hover:text-primary-600 transition">
                    List Treatment
                </a>

                <a href="/treatment/categories"
                    class="block px-3 py-2 rounded-lg text-gray-600 hover:bg-primary-50 hover:text-primary-600 transition">
                    Kategori Treatment
                </a>

                <a href="/treatment/create"
                    class="block px-3 py-2 rounded-lg text-gray-600 hover:bg-primary-50 hover:text-primary-600 transition">
                    Tambah Treatment
                </a>

                <a href="/treatment/packages"
                    class="block px-3 py-2 rounded-lg text-gray-600 hover:bg-primary-50 hover:text-primary-600 transition">
                    Paket Treatment
                </a>

            </div>

        </div>


        <a href="/doctor"
            class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition-all">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2-1.343-2-3-2zm-9 8s1-4 9-4 9 4 9 4H3z" />
            </svg>
            Dokter
        </a>

        <a href="#"
            class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition-all">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 17v-2m6 2v-2M3 13h18M5 10h14M7 7h10" />
            </svg>
            Laporan
        </a>
    </nav>

</aside>
