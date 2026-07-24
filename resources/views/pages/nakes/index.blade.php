@extends('layouts.app')

@section('title', 'Dashboard Dokter')

@section('content')
<div class="p-6 space-y-6">

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">
                Selamat datang, {{ $dokter->nama ?? auth()->user()->username }} 👋
            </h1>
            <p class="text-sm text-gray-400 mt-1">{{ now()->translatedFormat('l, d F Y') }}</p>
        </div>
    </div>

    {{-- Stat Cards --}}
    <div class="grid grid-cols-3 gap-4">

        {{-- Menunggu --}}
        <div class="bg-amber-500 rounded-lg shadow-sm text-white relative overflow-hidden">
            <div class="px-5 py-4">
                <p class="text-3xl font-bold leading-tight">{{ $totalMenunggu }}</p>
                <p class="text-sm text-amber-50 mt-1">Menunggu</p>
                <p class="text-xs text-amber-100/80">Pasien hari ini</p>
            </div>
            <div class="absolute -right-2 -bottom-3 opacity-25">
                <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>

        {{-- Dipanggil --}}
        <div class="bg-blue-500 rounded-lg shadow-sm text-white relative overflow-hidden">
            <div class="px-5 py-4">
                <p class="text-3xl font-bold leading-tight">{{ $totalDipanggil }}</p>
                <p class="text-sm text-blue-50 mt-1">Dipanggil</p>
                <p class="text-xs text-blue-100/80">Sedang diperiksa</p>
            </div>
            <div class="absolute -right-2 -bottom-3 opacity-25">
                <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                </svg>
            </div>
        </div>

        {{-- Selesai --}}
        <div class="bg-emerald-500 rounded-lg shadow-sm text-white relative overflow-hidden">
            <div class="px-5 py-4">
                <p class="text-3xl font-bold leading-tight">{{ $totalSelesai }}</p>
                <p class="text-sm text-emerald-50 mt-1">Selesai</p>
                <p class="text-xs text-emerald-100/80">Hari ini</p>
            </div>
            <div class="absolute -right-2 -bottom-3 opacity-25">
                <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7" />
                </svg>
            </div>
        </div>

    </div>

    <div>
        <x-nakes.table :pelayanans="$pelayanans" />
    </div>
</div>
@endsection
