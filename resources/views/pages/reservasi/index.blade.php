@extends('layouts.app')

@section('title', 'Halaman Reservasi')

@section('content')
    <div class="p-4" x-data="PerawatModal()">

        <x-notification />

        {{-- Header --}}
        <div class="flex items-center justify-between border-b border-slate-200 pb-3 mb-4">
            <div>
                <h1 class="text-xl font-semibold text-slate-700">Reservasi</h1>
                <p class="text-xs text-slate-400">Kelola data reservasi</p>
            </div>
            <div x-data="{ open: false }">
                <button @click="open = true"
                    class="inline-flex items-center gap-1.5 cursor-pointer text-xs px-3 py-1.5 bg-blue-500 hover:bg-blue-600 text-white rounded transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Reservasi
                </button>
                <x-reservasi.modal :pasiens="$pasiens" :dokters="$dokters" :treatments="$treatments" />
            </div>
        </div>

        {{-- Tabel --}}
        <x-reservasi.reservasitabel :reservasis="$reservasis" />

    </div>
@endsection
