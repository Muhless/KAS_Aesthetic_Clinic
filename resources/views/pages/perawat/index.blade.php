@extends('layouts.app')

@section('title', 'Halaman Perawat')

@section('content')
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-primary-400">Perawat</h1>
            <div x-data="{ open: false }">
                <button @click="open = true"
                    class="cursor-pointer text-sm w-52 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg shadow">
                    Tambah Perawat
                </button>
                <x-perawat.modal />
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach ($perawats as $perawat)
                <div class="bg-white shadow-md rounded-lg p-4 border">

                    <h2 class="text-lg font-semibold mb-1">
                        {{ $perawat['nama'] ?? '-' }}
                    </h2>

                    <p class="text-gray-600 text-sm mb-2">
                        {{ $perawat['email'] ?? '-' }}
                    </p>

                    <p class="text-gray-600 text-sm mb-2">
                        {{ $perawat['nomor_telepon'] ?? '-' }}
                    </p>

                    <span class="inline-block text-xs bg-green-100 text-green-600 px-2 py-1 rounded">
                        Perawat
                    </span>
                </div>
            @endforeach
        </div>
    </div>
@endsection
