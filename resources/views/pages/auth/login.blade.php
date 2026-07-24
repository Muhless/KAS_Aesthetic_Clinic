<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('images/logo_kas.png') }}">
    <title>Login - KAS Aesthetic Clinic</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="min-h-screen flex items-center justify-center bg-blue-500">

    <div class="w-full max-w-sm">

        {{-- Brand di atas card --}}
        <div class="text-center mb-4">
            <a href="/" class="inline-flex items-center gap-2">
                <img src="{{ asset('images/logo_kas.png') }}" alt="Logo" class="w-8 h-8 object-contain">
                <span class="text-xl font-semibold text-white">KAS Aesthetic Clinic</span>
            </a>
        </div>

        {{-- Card --}}
        <div class="bg-white rounded-sm shadow-[0_0.5rem_1rem_rgba(0,0,0,0.15)] p-4">

            <p class="text-center text-slate-600 text-sm mb-3">Masuk untuk memulai sesi Anda</p>

            <form action="/login" method="POST" class="space-y-3">
                @csrf

                {{-- Username --}}
                <div>
                    <input type="text" name="username" value="{{ old('username') }}" placeholder="Username"
                        class="w-full px-2.5 py-2 rounded-sm border border-slate-400 bg-white text-slate-700 text-sm focus:outline-none focus:border-blue-500 focus:shadow-[0_0_0_0.2rem_rgba(59,130,246,0.25)] transition"
                        required>
                    @error('username')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <input type="password" name="password" placeholder="Password"
                        class="w-full px-2.5 py-2 rounded-sm border border-slate-400 bg-white text-slate-700 text-sm focus:outline-none focus:border-blue-500 focus:shadow-[0_0_0_0.2rem_rgba(59,130,246,0.25)] transition"
                        required>
                    @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Button --}}
                <button type="submit"
                    class="w-full py-2 bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium rounded-sm transition cursor-pointer">
                    Masuk
                </button>
            </form>
        </div>

    </div>

    @if (session('success'))
    <script>
    Swal.fire({
        title: 'Berhasil!',
        text: "{{ session('success') }}",
        icon: 'success',
        confirmButtonColor: '#3b82f6',
        confirmButtonText: 'OK'
    });
    </script>
    @endif

</body>

</html>
