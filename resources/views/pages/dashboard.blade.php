@extends('layouts.app')

@section('title', 'Halaman Awal')

@section('content')
    <div class="p-6 space-y-6">

        {{-- Header --}}
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-xl font-semibold text-slate-800">Halaman Awal</h1>
                <p class="text-sm text-slate-400 mt-0.5">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
            </div>
            <div class="flex items-center gap-3">
                <div class="text-right">
                    <p class="text-sm font-medium text-slate-800">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-slate-400">{{ ucfirst(auth()->user()->role) }}</p>
                </div>
                <div
                    class="w-9 h-9 bg-primary-100 rounded-xl flex items-center justify-center text-primary-600 font-semibold text-sm">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
            </div>
        </div>

        {{-- Stat Cards --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <x-card.reservasiCard :totalReservasi="$reservasisHariIni->count()" />
            <x-card.antrianCard :totalAntrian="$totalAntrian" />
            <x-card.dokterStatCard :totalDokter="$totalDokter" />
            <x-card.perawatStatCard :totalPerawat="$totalPerawat" />
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Kiri --}}
            <div class="lg:col-span-2 space-y-5">

                <x-card.pasienSelanjutnyaCard :pasienSelanjutnya="$pasienSelanjutnya"/>

                <x-table.antrianTable :antriansHariIni="$antriansHariIni" />
                <x-table.pasienTable :antriansHariIni="$antriansHariIni" />
                <x-table.reservasiTable :reservasisHariIni="$reservasisHariIni" />
            </div>

            {{-- Kanan --}}
            <div class="space-y-5">

                {{-- Dokter Hari Ini --}}
                <x-card.dokterCard />
                <x-card.perawatCard />




            </div>
        </div>
    </div>
@endsection
