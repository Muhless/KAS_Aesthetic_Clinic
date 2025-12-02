@extends('layouts.app')

@section('title', 'Halaman Produk')

@section('content')
    <div class="p-6">
        <h1 class="text-2xl font-semibold mb-4">Daftar Admin</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach ($admins as $admin)
                <div class="bg-white shadow-md rounded-lg p-4 border">
                    <h2 class="text-lg font-semibold mb-1">
                        {{ $admin->nama }}
                    </h2>

                    <p class="text-gray-600 text-sm mb-2">
                        {{ $admin->email }}
                    </p>

                    <span class="inline-block text-xs bg-blue-100 text-blue-600 px-2 py-1 rounded">
                        Role: {{ $admin->role }}
                    </span>
                </div>
            @endforeach
        </div>
    </div>
@endsection
