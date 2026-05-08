@extends('layouts.app')

@section('title', 'Halaman Dokter')

@section('content')
    <div class="p-6 space-y-6" x-data="{
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

        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-primary-400">Dokter</h1>
                <p class="text-sm text-gray-400 mt-1">
                    {{ $dokters->count() }} Dokter terdaftar
                </p>
            </div>
            {{-- Dokter --}}
             <button @click="tambahDokter()"
                class="inline-flex items-center gap-2 cursor-pointer text-sm w-48 justify-center py-2.5 bg-primary-600 hover:bg-primary-700 active:bg-primary-800 text-white rounded-lg shadow transition-all duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Dokter
            </button>
        </div>

        {{-- Di halaman dokter --}}
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
            <div class="flex flex-col items-center justify-center py-24 px-6">
                {{-- Ilustrasi --}}
                <div class="relative mb-6">
                    <div class="w-28 h-28 rounded-full bg-primary-50 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-14 h-14 text-primary-300" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    {{-- Badge plus kecil --}}
                    <div
                        class="absolute -bottom-1 -right-1 w-8 h-8 rounded-full bg-primary-600 flex items-center justify-center shadow-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                        </svg>
                    </div>
                </div>

                <h3 class="text-lg font-semibold text-gray-700 mb-1">Belum ada dokter</h3>
                <p class="text-sm text-gray-400 text-center max-w-sm mb-6">
                    Data dokter masih kosong. Tambahkan dokter pertama untuk mulai mengelola tim klinik.
                </p>

            </div>
        @endif
        <x-dokter.modal />
    </div>
@endsection
