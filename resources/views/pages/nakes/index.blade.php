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
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm px-5 py-4">
                <p class="text-xs font-medium text-gray-400 uppercase tracking-wider mb-2">Menunggu</p>
                <p class="text-3xl font-bold text-yellow-500">{{ $totalMenunggu }}</p>
                <p class="text-xs text-gray-400 mt-1">Pasien hari ini</p>
            </div>
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm px-5 py-4">
                <p class="text-xs font-medium text-gray-400 uppercase tracking-wider mb-2">Dipanggil</p>
                <p class="text-3xl font-bold text-blue-500">{{ $totalDipanggil }}</p>
                <p class="text-xs text-gray-400 mt-1">Sedang diperiksa</p>
            </div>
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm px-5 py-4">
                <p class="text-xs font-medium text-gray-400 uppercase tracking-wider mb-2">Selesai</p>
                <p class="text-3xl font-bold text-green-500">{{ $totalSelesai }}</p>
                <p class="text-xs text-gray-400 mt-1">Hari ini</p>
            </div>
        </div>

        <div>
            <x-nakes.table :pelayanans="$pelayanans" />
        </div>
    </div>
@endsection
