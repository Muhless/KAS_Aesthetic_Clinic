<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', '- KAS Aesthetic Clinic')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo_kas.png') }}">

    {{--  --}}
    <script src="//unpkg.com/alpinejs" defer></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{--  --}}
</head>

<body class="bg-gray-100 text-gray-900 min-h-screen">
    <div class="flex min-h-screen overflow-hidden">
        @include('layouts.sidebar')
        <main class="flex-1 ml-64 flex flex-col">
            {{-- <x-topbar /> --}}
            <div class="flex-1overflow-y-auto bg-neutral-light">
                @yield('content')
            </div>
        </main>

    </div>

</body>

</html>
