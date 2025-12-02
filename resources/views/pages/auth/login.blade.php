<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('images/logo_kas.png') }}">

    <title>Login - KAS Aesthetic Clinic</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 h-screen flex items-center justify-center">

    <div class="w-full max-w-sm bg-white p-6 rounded-xl shadow-lg">
        <h2 class="text-2xl font-semibold text-center mb-6 text-black">Login</h2>

        <form action="/login" method="POST">
            @csrf

            <!-- username -->
            <div class="mb-4">
                <label class="block text-gray-600 mb-1 font-medium">Username</label>
                <input type="text" name="username" value="{{ old('username') }}"
                    class="text-black w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-400 focus:outline-none"
                    required>
                @error('username')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label class="block mb-1 font-medium text-gray-600">Password</label>
                <input type="password" name="password"
                    class="w-full px-4 py-2 text-black border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-400 focus:outline-none"
                    required>
                @error('password')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>



            <!-- Button -->
            <button type="submit"
                class="w-full bg-primary-600 cursor-pointer hover:bg-primary-700 text-white py-2 rounded-lg shadow transition">
                Masuk
            </button>

        </form>
        <div class="text-center mt-2">

            <p>Belum punya akun ?
                <span>
                    <a href="/register" class="text-sm hover:underline hover:text-primary-500">Buat disini!</a>
                </span>
            </p>
        </div>
    </div>

</body>

</html>
