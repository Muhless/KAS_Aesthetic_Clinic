@extends('layouts.app')

@section('title', 'Reservasi - KAS Aesthetic Clinic')

@section('content')
    <div class="p-6" x-data="PerawatModal()">

        <x-notification />

        {{-- Header --}}
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-xl font-semibold text-slate-800">Reservasi</h1>
                <p class="text-sm text-slate-400 mt-0.5">Kelola data reservasi pasien</p>
            </div>
            <div x-data="{ open: false }">
                <button @click="open = true"
                    class="cursor-pointer flex items-center gap-2 text-sm px-4 py-2.5 bg-primary-500 hover:bg-primary-600 text-white rounded-xl transition shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Reservasi
                </button>
                <x-reservasi.modal :pasiens="$pasiens" :dokters="$dokters" :treatments="$treatments" />
            </div>
        </div>

        {{-- Tabel --}}
        <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden">
            <x-reservasi.tabel />
        </div>

    </div>
@endsection
