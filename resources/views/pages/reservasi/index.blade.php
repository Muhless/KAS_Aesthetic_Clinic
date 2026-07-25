@extends('layouts.app')

@section('title', 'Halaman Reservasi')

@section('content')
<div class="p-4" x-data="PerawatModal()">

    <x-notification />

    {{-- Header --}}
    <div class="flex items-center justify-between border-b border-slate-200 pb-3 mb-4">
        <div>
            <h1 class="text-xl font-semibold text-slate-700">Reservasi</h1>
            <p class="text-xs text-slate-400">Kelola data reservasi</p>
        </div>
        <div x-data="{ open: false }">
            <button @click="open = true"
                class="inline-flex items-center gap-1.5 cursor-pointer text-xs px-3 py-1.5 bg-blue-500 hover:bg-blue-600 text-white rounded transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Reservasi
            </button>
            <x-reservasi.modal :pasiens="$pasiens" :dokters="$dokters" :treatments="$treatments" />
        </div>
    </div>

    {{-- Filter --}}
    <form method="GET" action="{{ route('reservasi.index') }}"
        class="flex flex-wrap items-end gap-3 bg-white border border-slate-200 rounded-md p-3 mb-4">

        <div class="flex flex-col">
            <label class="text-xs text-slate-500 mb-1">Status</label>
            <select name="status" class="text-xs border border-slate-300 rounded px-2 py-1.5 w-36">
                <option value="">Semua Status</option>
                <option value="tertunda" @selected(request('status')=='tertunda' )>Tertunda</option>
                <option value="dikonfirmasi" @selected(request('status')=='dikonfirmasi' )>Dikonfirmasi</option>
                <option value="selesai" @selected(request('status')=='selesai' )>Selesai</option>
                <option value="dibatalkan" @selected(request('status')=='dibatalkan' )>Dibatalkan</option>
            </select>
        </div>

        <div class="flex flex-col">
            <label class="text-xs text-slate-500 mb-1">Tanggal</label>
            <input type="date" name="tanggal" value="{{ request('tanggal') }}"
                class="text-xs border border-slate-300 rounded px-2 py-1.5 w-36">
        </div>

        <div class="flex flex-col">
            <label class="text-xs text-slate-500 mb-1">Dokter</label>
            <select name="dokter_id" class="text-xs border border-slate-300 rounded px-2 py-1.5 w-40">
                <option value="">Semua Dokter</option>
                @foreach ($dokters as $dokter)
                <option value="{{ $dokter->id }}" @selected(request('dokter_id')==$dokter->id)>
                    {{ $dokter->nama }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="flex flex-col">
            <label class="text-xs text-slate-500 mb-1">Pasien</label>
            <select name="pasien_id" class="text-xs border border-slate-300 rounded px-2 py-1.5 w-40">
                <option value="">Semua Pasien</option>
                @foreach ($pasiens as $pasien)
                <option value="{{ $pasien->id }}" @selected(request('pasien_id')==$pasien->id)>
                    {{ $pasien->nama }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="flex gap-2">
            <button type="submit"
                class="text-xs px-3 py-1.5 bg-slate-700 hover:bg-slate-800 text-white rounded transition">
                Terapkan
            </button>
            <a href="{{ route('reservasi.index') }}"
                class="text-xs px-3 py-1.5 bg-slate-200 hover:bg-slate-300 text-slate-600 rounded transition">
                Reset
            </a>
            <a href="{{ route('reservasi.laporan.cetak', request()->query()) }}" target="_blank"
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

    {{-- Tabel --}}
    <x-reservasi.reservasitabel :reservasis="$reservasis" />

</div>
@endsection
