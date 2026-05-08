@extends('layouts.app')

@section('title', 'Halaman Reservasi')

@section('content')
    <div class="p-6" x-data="PerawatModal()">

        <x-notification />

        {{-- Header --}}
        <div class="flex items-center justify-between mb-8">
             <div>
                <h1 class="text-3xl font-bold text-primary-400">Reservasi</h1>
                <p class="text-sm text-gray-400 mt-1">Kelola data reservasi</p>
            </div>
            <div x-data="{ open: false }">
               <button @click="open = true"
                class="inline-flex items-center gap-2 cursor-pointer text-sm w-48 justify-center py-2.5 bg-primary-600 hover:bg-primary-700 active:bg-primary-800 text-white rounded-lg shadow transition-all duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Reservasi
            </button>
                <x-reservasi.modal :pasiens="$pasiens" :dokters="$dokters" :treatments="$treatments" />
            </div>
        </div>

        {{-- Tabel --}}
        <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden">
      <x-reservasi.reservasitabel :reservasis="$reservasis" />
        </div>

    </div>
@endsection
