@extends('layouts.app')

@section('title', 'Halaman Perawat')

@section('content')
<div class="p-4 space-y-4" x-data="{
        open: false,
        perawat: {},
        tambahPerawat() {
            this.perawat = {};
            this.open = true;
        },
        editPerawat(id) {
            fetch(`/perawat/${id}/api`)
                .then(r => r.json())
                .then(res => {
                    this.perawat = res.data;
                    this.open = true;
                });
        }
    }">
    <x-notification />

    {{-- Header --}}
    <div class="flex items-center justify-between border-b border-black/10 pb-3">
        <div>
            <h1 class="text-xl font-semibold text-slate-700">Perawat</h1>
            <p class="text-xs text-slate-400">
                {{ $perawats->count() }} Perawat terdaftar
            </p>
        </div>
        <button @click="tambahPerawat()"
            class="inline-flex items-center gap-1.5 cursor-pointer text-xs px-3 py-1.5 bg-blue-500 hover:bg-blue-600 text-white rounded-sm transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Perawat
        </button>
    </div>

    {{-- Pencarian --}}
    <form method="GET" action="{{ route('perawat.index') }}" class="flex items-center gap-2">
        <div class="relative flex-1 max-w-sm">
            <svg xmlns="http://www.w3.org/2000/svg"
                class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-4.35-4.35M17 10a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <input type="text" name="cari" value="{{ request('cari') }}" placeholder="Cari nama atau jadwal perawat..."
                class="w-full text-xs border border-slate-300 rounded-sm pl-9 pr-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <button type="submit"
            class="text-xs px-3 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-sm font-medium transition">
            Cari
        </button>
        @if (request('cari'))
        <a href="{{ route('perawat.index') }}"
            class="text-xs px-3 py-2 bg-slate-200 hover:bg-slate-300 text-slate-600 rounded-sm font-medium transition">
            Reset
        </a>
        @endif
    </form>

    {{-- Data ada --}}
    @if ($perawats->isNotEmpty())
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
        @foreach ($perawats as $perawat)
        <x-perawat.card :perawat="$perawat" />
        @endforeach
    </div>

    {{-- Empty state --}}
    @else
    <div
        class="bg-white rounded-sm shadow-[0_0.5rem_1rem_rgba(0,0,0,0.1)] border border-black/10 flex flex-col items-center justify-center py-16 px-6">
        <div class="w-16 h-16 rounded-full bg-slate-100 flex items-center justify-center mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-slate-400" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
        </div>

        <h3 class="text-sm font-semibold text-slate-600 mb-1">Belum ada perawat</h3>
        <p class="text-xs text-slate-400 text-center max-w-sm mb-4">
            @if (request('cari'))
            Tidak ada perawat yang cocok dengan pencarian "{{ request('cari') }}".
            @else
            Data perawat masih kosong. Tambahkan perawat pertama untuk mulai mengelola tim klinik.
            @endif
        </p>

        <button @click="tambahPerawat()"
            class="inline-flex items-center gap-1.5 cursor-pointer text-xs px-3 py-1.5 bg-blue-500 hover:bg-blue-600 text-white rounded-sm transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Perawat
        </button>
    </div>
    @endif

    <x-perawat.modal />
</div>
@endsection
