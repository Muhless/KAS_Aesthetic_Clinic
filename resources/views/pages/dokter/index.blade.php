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
        <div class="flex items-center justify-between border-b border-slate-200 pb-3">
            <div>
                <h1 class="text-xl font-semibold text-slate-700">Dokter</h1>
                <p class="text-xs text-slate-400">
                    {{ $dokters->count() }} Dokter terdaftar
                </p>
            </div>
            <button @click="tambahDokter()"
                class="inline-flex items-center gap-1.5 cursor-pointer text-xs px-3 py-1.5 bg-blue-500 hover:bg-blue-600 text-white rounded transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Dokter
            </button>
        </div>

        {{-- Grid/List Dokter --}}
        @if ($dokters->isNotEmpty())
            <div
                class="grid grid-flow-col auto-cols-[290px] gap-4 overflow-x-auto pb-2 snap-x snap-mandatory scrollbar-hide">

                @foreach ($dokters as $dokter)
                    <div class="snap-start">
                        <x-dokter.card :dokter="$dokter" />
                    </div>
                @endforeach
            </div>

            {{-- Empty state --}}
        @else
            <div class="bg-white rounded-md border border-slate-200 flex flex-col items-center justify-center py-16 px-6">
                <div class="w-16 h-16 rounded-full bg-slate-100 flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-slate-400" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>

                <h3 class="text-sm font-semibold text-slate-600 mb-1">Belum ada dokter</h3>
                <p class="text-xs text-slate-400 text-center max-w-sm mb-4">
                    Data dokter masih kosong. Tambahkan dokter pertama untuk mulai mengelola tim klinik.
                </p>

                <button @click="tambahDokter()"
                    class="inline-flex items-center gap-1.5 cursor-pointer text-xs px-3 py-1.5 bg-blue-500 hover:bg-blue-600 text-white rounded transition">
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
