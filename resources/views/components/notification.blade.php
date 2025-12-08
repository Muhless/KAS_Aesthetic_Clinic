<!-- Success Notification Popup -->
@if (session('success'))
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show"
        x-transition:enter="transform transition ease-out duration-300"
        x-transition:enter-start="translate-y-[-100%] opacity-0" x-transition:enter-end="translate-y-0 opacity-100"
        x-transition:leave="transform transition ease-in duration-200"
        x-transition:leave-start="translate-y-0 opacity-100" x-transition:leave-end="translate-y-[-100%] opacity-0"
        class="fixed top-4 left-1/2 transform -translate-x-1/2 z-50 max-w-md w-full mx-4">

        <div class="bg-white rounded-xl shadow-2xl border border-green-200 overflow-hidden">
            <div class="p-4">
                <div class="flex items-start gap-3">
                    <!-- Icon -->
                    <div class="shrink-0">
                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="flex-1 pt-0.5">
                        <h3 class="text-sm font-semibold text-gray-900 mb-1">Berhasil!</h3>
                        <p class="text-sm text-gray-600">{{ session('success') }}</p>
                    </div>

                    <!-- Close Button -->
                    <button @click="show = false" class="shrink-0 text-gray-400 hover:text-gray-600 transition">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Progress Bar -->
            <div class="h-1 bg-green-100">
                <div class="h-full bg-green-500 animate-progress"></div>
            </div>
        </div>
    </div>
@endif

<!-- Error Notification Popup -->
@if ($errors->any())
    <div x-data="{ show: true }" x-show="show" x-transition:enter="transform transition ease-out duration-300"
        x-transition:enter-start="translate-y-[-100%] opacity-0" x-transition:enter-end="translate-y-0 opacity-100"
        x-transition:leave="transform transition ease-in duration-200"
        x-transition:leave-start="translate-y-0 opacity-100" x-transition:leave-end="translate-y-[-100%] opacity-0"
        class="fixed top-4 left-1/2 transform -translate-x-1/2 z-50 max-w-md w-full mx-4">

        <div class="bg-white rounded-xl shadow-2xl border border-red-200 overflow-hidden">
            <div class="p-4">
                <div class="flex items-start gap-3">
                    <!-- Icon -->
                    <div class="shrink-0">
                        <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="flex-1 pt-0.5">
                        <h3 class="text-sm font-semibold text-gray-900 mb-2">Terjadi Kesalahan</h3>
                        <ul class="space-y-1">
                            @foreach ($errors->all() as $error)
                                <li class="text-sm text-gray-600 flex items-start gap-1.5">
                                    <span class="text-red-500 mt-0.5">•</span>
                                    <span>{{ $error }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Close Button -->
                    <button @click="show = false" class="shrink-0 text-gray-400 hover:text-gray-600 transition">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endif

<!-- Add this to your CSS (in app.css or style tag) -->
<style>
    @keyframes progress {
        from {
            width: 100%;
        }

        to {
            width: 0%;
        }
    }

    .animate-progress {
        animation: progress 5s linear forwards;
    }
</style>
