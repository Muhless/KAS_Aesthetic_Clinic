<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'KAS Aesthetic Clinic')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo_kas.png') }}">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Flatpickr CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    {{-- Flatpickr JS --}}
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    {{-- Locale Indonesia --}}
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>
</head>

<body class="bg-slate-50 text-gray-900 min-h-screen">
    <div class="flex min-h-screen">
        @include('layouts.sidebar')
        <main class="flex-1 ml-64 min-h-screen overflow-y-auto">
            @yield('content')
        </main>
    </div>
</body>

</html>
