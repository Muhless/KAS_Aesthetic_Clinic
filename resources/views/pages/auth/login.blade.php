<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('images/logo_kas.png') }}">
    <title>Login - KAS Aesthetic Clinic</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen flex items-center justify-center bg-primary-50">

    <div class="w-full max-w-sm bg-white rounded-2xl shadow-md p-8 border border-primary-100">

        {{-- Header --}}
        <div class="text-center mb-8">
            <img src="{{ asset('images/logo_kas.png') }}" alt="Logo" class="w-12 h-12 object-contain mx-auto mb-3">
            <h1 class="text-xl font-semibold text-primary-900">KAS Aesthetic Clinic</h1>
            <p class="text-sm text-primary-400 mt-1">Management Portal</p>
        </div>

        <form action="/login" method="POST" class="space-y-4">
            @csrf

            {{-- Username --}}
            <div>
                <label class="block text-sm font-medium text-primary-700 mb-1">Username</label>
                <input type="text" name="username" value="{{ old('username') }}"
                    class="w-full px-4 py-2.5 rounded-lg border border-primary-200 bg-primary-50 text-primary-900 text-sm focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-transparent transition"
                    required>
                @error('username')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div>
                <label class="block text-sm font-medium text-primary-700 mb-1">Password</label>
                <input type="password" name="password"
                    class="w-full px-4 py-2.5 rounded-lg border border-primary-200 bg-primary-50 text-primary-900 text-sm focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-transparent transition"
                    required>
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Button --}}
            <button type="submit"
                class="w-full mt-2 py-2.5 bg-primary-500 hover:bg-primary-600 text-white text-sm font-medium rounded-lg transition cursor-pointer">
                Masuk
            </button>

        </form>

        {{-- <div class="text-center mt-2">

            <p>Belum punya akun ?
                <span>
                    <a href="/register" class="hover:underline hover:text-primary-500">Buat disini!</a>
                </span>
            </p>
        </div> --}}

    </div>

</body>

</html>
