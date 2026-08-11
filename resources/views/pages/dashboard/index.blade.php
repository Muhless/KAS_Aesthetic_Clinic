@extends('layouts.app')

@section('title', 'Halaman Awal')

@section('content')
    <div class="p-4 space-y-4">

        {{-- Header --}}
        <div class="flex items-center justify-between border-b border-slate-200 pb-3">
            <div>
                <h1 class="text-xl font-semibold text-slate-700">Halaman Awal</h1>
                <p class="text-xs text-slate-400">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
            </div>
            <div class="flex items-center gap-2">
                <div class="text-right">
                    <p class="text-sm font-medium text-slate-700">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-slate-400">{{ ucfirst(auth()->user()->role) }}</p>
                </div>
                <div class="w-8 h-8 bg-slate-200 rounded-full flex items-center justify-center text-slate-600 font-semibold text-xs">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
            </div>
        </div>

        {{-- Stat Cards (small-box AdminLTE style) --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
            <x-dashboard.reservasi :totalReservasi="$reservasisHariIni->count()" />
            <x-dashboard.pelayanan :totalPelayanan="$totalPelayanan" />
            <x-dashboard.dokter :totalDokter="$totalDokter" />
            <x-dashboard.perawat :totalPerawat="$totalPerawat" />
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

            {{-- Kiri --}}
            <div class="lg:col-span-2 space-y-4">
                <x-dashboard.antriantable :pelayanansHariIni="$pelayanansHariIni" />
                <x-dashboard.pasienhariinitable :pelayanansHariIni="$pelayanansHariIni" />
            </div>

            {{-- Kanan --}}
            <div class="space-y-4">
                <x-reservasi.table :reservasisHariIni="$reservasisHariIni" />
            </div>
        </div>
    </div>
@endsection
