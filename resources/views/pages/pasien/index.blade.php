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
        <button @click="tambahPasien()" data-testid="add-patient"
            class="inline-flex items-center gap-1.5 cursor-pointer text-xs px-3 py-1.5 bg-blue-500 hover:bg-blue-600 text-white rounded transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Pasien
        </button>
    </div>

    {{-- Filter --}}
    <form method="GET" action="{{ route('pasien.index') }}"
        class="flex flex-wrap items-end gap-3 bg-white border border-slate-200 rounded-md p-3">

        <div class="flex flex-col">
            <label class="text-xs text-slate-500 mb-1">Nama</label>
            <input type="text" name="nama" value="{{ request('nama') }}" placeholder="Cari nama..."
                class="text-xs border border-slate-300 rounded px-2 py-1.5 w-40">
        </div>

        <div class="flex flex-col">
            <label class="text-xs text-slate-500 mb-1">Jenis Kelamin</label>
            <select name="jenis_kelamin" class="text-xs border border-slate-300 rounded px-2 py-1.5 w-32">
                <option value="">Semua</option>
                <option value="L" @selected(request('jenis_kelamin')=='L' )>Laki-laki</option>
                <option value="P" @selected(request('jenis_kelamin')=='P' )>Perempuan</option>
            </select>
        </div>

        <div class="flex flex-col">
            <label class="text-xs text-slate-500 mb-1">Tgl Lahir Dari</label>
            <input type="date" name="tanggal_dari" value="{{ request('tanggal_dari') }}"
                class="text-xs border border-slate-300 rounded px-2 py-1.5 w-36">
        </div>

        <div class="flex flex-col">
            <label class="text-xs text-slate-500 mb-1">Tgl Lahir Sampai</label>
            <input type="date" name="tanggal_sampai" value="{{ request('tanggal_sampai') }}"
                class="text-xs border border-slate-300 rounded px-2 py-1.5 w-36">
        </div>

        <div class="flex gap-2">
            <button type="submit"
                class="text-xs px-3 py-1.5 bg-slate-700 hover:bg-slate-800 text-white rounded transition">
                Terapkan
            </button>
            <a href="{{ route('pasien.index') }}"
                class="text-xs px-3 py-1.5 bg-slate-200 hover:bg-slate-300 text-slate-600 rounded transition">
                Reset
            </a>
            <a href="{{ route('pasien.laporan.cetak', request()->query()) }}" target="_blank"
                class="text-xs px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white rounded transition inline-flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.32 0H6.34m6.85-6.65V4.5A2.25 2.25 0 0011 2.25h-2A2.25 2.25 0 006.75 4.5v6.85m10.5 0h-10.5" />
                </svg>
                Cetak PDF
            </a>
        </div>
    </form>

    <x-pasien.table :pasiens="$pasiens" />
    <x-pasien.modal />

</div>
@endsection
