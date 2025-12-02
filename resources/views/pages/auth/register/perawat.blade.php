<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('images/logo_kas.png') }}">

    <title>Register - KAS Aesthetic Clinic</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 h-screen flex items-center justify-center">

    <div class="w-full max-w-sm bg-white p-6 rounded-xl shadow-lg">
        <h2 class="text-2xl font-semibold text-center mb-6 text-black">
            Register Akun
        </h2>

        <form action="/register" method="POST">
            @csrf

            <!-- Nama Lengkap -->
            <div class="mb-4">
                <label class="block text-gray-600 mb-1 font-medium">Nama Lengkap</label>
                <input type="text" name="nama" value="{{ old('nama') }}"
                    class="text-black w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-400 focus:outline-none"
                    required>
                @error('nama')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label class="block text-gray-600 mb-1 font-medium">Email (opsional)</label>
                <input type="email" name="email" value="{{ old('email') }}"
                    class="text-black w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-400 focus:outline-none">
                @error('email')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Nomor HP -->
            <div class="mb-4">
                <label class="block text-gray-600 mb-1 font-medium">No HP (opsional)</label>
                <input type="text" name="no_telepon" value="{{ old('no_telepon') }}"
                    class="text-black w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-400 focus:outline-none">
                @error('no_telepon')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Tanggal Lahir -->
            <div class="mb-4">
                <label class="block text-gray-600 mb-1 font-medium">Tanggal Lahir (opsional)</label>
                <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                    class="text-black w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-400 focus:outline-none">
                @error('tanggal_lahir')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- role -->


            <!-- Button -->
            <button type="submit"
                class="w-full bg-primary-600 cursor-pointer hover:bg-primary-700 text-white py-2 rounded-lg shadow transition">
                Selanjutnya
            </button>

            <p class="text-center text-gray-600 text-sm mt-4">
                Sudah punya akun?
                <a href="/login" class="text-primary-600 hover:underline">Masuk</a>
            </p>

        </form>
    </div>

</body>

</html>
