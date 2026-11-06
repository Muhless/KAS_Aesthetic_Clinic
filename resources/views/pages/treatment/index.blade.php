@extends('layouts.app')

@section('title', 'Daftar Treatment - KAS Aesthetic Clinic')

@section('content')
<div class="p-4 space-y-4" x-data="{
        open: false,
        treatment: {},
        tambahTreatment() {
            this.treatment = {};
            this.open = true;
        },
        editTreatment(id) {
            fetch(`/treatment/${id}/api`)
                .then(r => r.json())
                .then(res => {
                    this.treatment = res.data;
                    this.open = true;
                });
        }
    }">
    <x-notification />

    {{-- Header --}}
    <div class="flex items-center justify-between border-b border-black/10 pb-3">
        <div>
            <h1 class="text-xl font-semibold text-slate-700">Treatment</h1>
            <p class="text-xs text-slate-400">{{ $treatments->count() }} treatment terdaftar</p>
        </div>
        <button @click="tambahTreatment()" data-testid="add-treatment"
            class="inline-flex items-center gap-1.5 cursor-pointer text-xs px-3 py-1.5 bg-blue-500 hover:bg-blue-600 text-white rounded-sm transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Treatment
        </button>
    </div>

    {{-- Filter --}}
    <form method="GET" action="{{ route('treatment.index') }}"
        class="flex flex-wrap items-end gap-3 bg-white border border-black/10 rounded-sm p-3">

        <div class="flex flex-col">
            <label class="text-xs text-slate-500 mb-1">Nama</label>
            <input type="text" name="nama" value="{{ request('nama') }}" placeholder="Cari nama treatment..."
                class="text-xs border border-slate-300 rounded px-2 py-1.5 w-44">
        </div>

        <div class="flex flex-col">
            <label class="text-xs text-slate-500 mb-1">Status</label>
            <select name="status" class="text-xs border border-slate-300 rounded px-2 py-1.5 w-36">
                <option value="">Semua Status</option>
                <option value="tersedia" @selected(request('status')=='tersedia' )>Tersedia</option>
                <option value="tidak_tersedia" @selected(request('status')=='tidak_tersedia' )>Tidak Tersedia</option>
            </select>
        </div>

        <div class="flex flex-col">
            <label class="text-xs text-slate-500 mb-1">Harga Min</label>
            <input type="number" name="harga_min" value="{{ request('harga_min') }}" placeholder="0"
                class="text-xs border border-slate-300 rounded px-2 py-1.5 w-28">
        </div>

        <div class="flex flex-col">
            <label class="text-xs text-slate-500 mb-1">Harga Max</label>
            <input type="number" name="harga_max" value="{{ request('harga_max') }}" placeholder="∞"
                class="text-xs border border-slate-300 rounded px-2 py-1.5 w-28">
        </div>

        <div class="flex gap-2">
            <button type="submit"
                class="text-xs px-3 py-1.5 bg-slate-700 hover:bg-slate-800 text-white rounded transition">
                Terapkan
            </button>
            <a href="{{ route('treatment.index') }}"
                class="text-xs px-3 py-1.5 bg-slate-200 hover:bg-slate-300 text-slate-600 rounded transition">
                Reset
            </a>
            <a href="{{ route('treatment.laporan.cetak', request()->query()) }}" target="_blank"
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

    {{-- Grid --}}
    @if ($treatments->isNotEmpty())
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
        @foreach ($treatments as $treatment)
        <x-treatment.card :treatment="$treatment" />
        @endforeach
    </div>

    {{-- Empty State --}}
    @else
    <div
        class="bg-white rounded-sm shadow-[0_0.5rem_1rem_rgba(0,0,0,0.1)] border border-black/10 flex flex-col items-center justify-center py-16 px-6">
        <div class="w-16 h-16 rounded-full bg-slate-100 flex items-center justify-center mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-slate-400" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
        </div>
        <h3 class="text-sm font-semibold text-slate-600 mb-1">Belum ada treatment</h3>
        <p class="text-xs text-slate-400 text-center max-w-sm mb-4">
            @if (request()->hasAny(['nama', 'status', 'harga_min', 'harga_max']))
            Tidak ada treatment yang cocok dengan filter yang dipilih.
            @else
            Tambahkan treatment pertama untuk mulai melayani pasien.
            @endif
        </p>
        <button @click="tambahTreatment()"
            class="inline-flex items-center gap-1.5 cursor-pointer text-xs px-3 py-1.5 bg-blue-500 hover:bg-blue-600 text-white rounded-sm transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Treatment
        </button>
    </div>
    @endif

    {{-- Modal --}}
    <x-treatment.modal />
</div>
@endsection
