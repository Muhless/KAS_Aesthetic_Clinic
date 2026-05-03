@extends('layouts.app')

@section('title', 'Halaman Pasien')

@section('content')
    <div class="p-6" x-data="{ open: false }">
        <x-notification />

        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-primary-400">Pasien</h1>
                <p class="text-sm text-gray-400 mt-1">{{ $pasiens->count() }} Pasien terdaftar</p>
            </div>
            <button @click="open = true"
                class="inline-flex items-center gap-2 cursor-pointer text-sm w-48 justify-center py-2.5 bg-primary-300 hover:bg-primary-700 active:bg-primary-800 text-white rounded-lg shadow transition-all duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Pasien
            </button>
        </div>

        <x-pasien.table :pasiens="$pasiens" />

        {{-- Modal satu scope dengan open --}}
        <x-pasien.modal />
    </div>
@endsection
