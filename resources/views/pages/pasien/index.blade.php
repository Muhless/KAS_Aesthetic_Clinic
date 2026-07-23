@extends('layouts.app')

@section('title', 'Halaman Pasien')

@section('content')
    <div class="p-4 space-y-4" x-data="{
        open: false,
        pasien: {},
        tambahPasien() {
            this.pasien = {};
            this.open = true;
        },
        editPasien(id) {
            fetch(`/pasiens/${id}/api`)
                .then(r => r.json())
                .then(res => {
                    this.pasien = res.data;
                    this.open = true;
                });
        }
    }">
        <x-notification />

        {{-- Header --}}
        <div class="flex items-center justify-between border-b border-slate-200 pb-3">
            <div>
                <h1 class="text-xl font-semibold text-slate-700">Pasien</h1>
                <p class="text-xs text-slate-400">{{ $pasiens->count() }} Pasien terdaftar</p>
            </div>
            <button @click="tambahPasien()"
                class="inline-flex items-center gap-1.5 cursor-pointer text-xs px-3 py-1.5 bg-blue-500 hover:bg-blue-600 text-white rounded transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Pasien
            </button>
        </div>

        <x-pasien.table :pasiens="$pasiens" />
        <x-pasien.modal />

    </div>
@endsection
