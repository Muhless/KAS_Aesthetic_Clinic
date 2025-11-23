<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', '- KAS Aesthetic Clinic')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo_kas.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 text-gray-900">

    <!-- Sidebar + Content -->
    <div class="flex min-h-screen">

        <!-- Sidebar -->
        @include('layouts.sidebar')

        <!-- Content -->
        <main class="flex-1 p-6">
            @yield('content')
        </main>

    </div>

</body>

</html>
