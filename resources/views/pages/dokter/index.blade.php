@extends('layouts.app')

@section('title', 'Halaman Dokter')

@section('content')
<div class="p-4 space-y-4" x-data="{
        open: false,
        dokter: {},
        tambahDokter() {
            this.dokter = {};
            this.open = true;
        },
        editDokter(id) {
            fetch(`/dokter/${id}/api`)
                .then(r => r.json())
                .then(res => {
                    this.dokter = res.data;
                    this.open = true;
                });
        }
    }">
    <x-notification />

    {{-- Header --}}
    <div class="flex items-center justify-between border-b border-gray-200 pb-3">
        <div>
            <h1 class="text-xl font-semibold text-gray-800">Dokter</h1>
            <p class="text-xs text-gray-400">
                {{ $dokters->count() }} Dokter terdaftar
            </p>
        </div>
        <button @click="tambahDokter()" data-testid="add-doctor"
            class="inline-flex items-center gap-1.5 cursor-pointer text-xs px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md font-medium transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Dokter
        </button>
    </div>

    {{-- Pencarian --}}
    <form method="GET" action="{{ route('dokter.index') }}" class="flex items-center gap-2">
        <div class="relative flex-1 max-w-sm">
            <svg xmlns="http://www.w3.org/2000/svg"
                class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-4.35-4.35M17 10a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <input type="text" name="cari" value="{{ request('cari') }}"
                placeholder="Cari nama atau spesialis dokter..."
                class="w-full text-xs border border-gray-300 rounded-md pl-9 pr-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>
        <button type="submit"
            class="text-xs px-3 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md font-medium transition">
            Cari
        </button>
        @if (request('cari'))
        <a href="{{ route('dokter.index') }}"
            class="text-xs px-3 py-2 bg-gray-200 hover:bg-gray-300 text-gray-600 rounded-md font-medium transition">
            Reset
        </a>
        @endif
    </form>

    {{-- Grid/List Dokter --}}
    @if ($dokters->isNotEmpty())
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
        @foreach ($dokters as $dokter)
        <x-dokter.card :dokter="$dokter" />
        @endforeach
    </div>

    {{-- Empty state --}}
    @else
    <div
        class="bg-white rounded-lg shadow-sm border border-gray-200 flex flex-col items-center justify-center py-16 px-6">
        <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
        </div>

        <h3 class="text-sm font-semibold text-gray-700 mb-1">Belum ada dokter</h3>
        <p class="text-xs text-gray-400 text-center max-w-sm mb-4">
            @if (request('cari'))
            Tidak ada dokter yang cocok dengan pencarian "{{ request('cari') }}".
            @else
            Data dokter masih kosong. Tambahkan dokter pertama untuk mulai mengelola tim klinik.
            @endif
        </p>

        <button @click="tambahDokter()"
            class="inline-flex items-center gap-1.5 cursor-pointer text-xs px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md font-medium transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Dokter
        </button>
    </div>
    @endif

    <x-dokter.modal />
</div>
@endsection
