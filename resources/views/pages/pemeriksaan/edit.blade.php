{{-- resources/views/pages/pemeriksaan/edit.blade.php --}}

@extends('layouts.app')

@section('title', 'Pemeriksaan - KAS Aesthetic Clinic')

@section('content')
    <div class="p-6 space-y-6">

        {{-- Header --}}
        <div class="flex items-center gap-4">
            <a href="{{ route('pelayanan.index') }}"
                class="p-2 rounded-xl text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                    <path fill-rule="evenodd"
                        d="M17 10a.75.75 0 0 1-.75.75H5.612l4.158 3.96a.75.75 0 1 1-1.04 1.08l-5.5-5.25a.75.75 0 0 1 0-1.08l5.5-5.25a.75.75 0 1 1 1.04 1.08L5.612 9.25H16.25A.75.75 0 0 1 17 10Z"
                        clip-rule="evenodd" />
                </svg>
            </a>
            <div>
                <h1 class="text-lg font-semibold text-slate-800">Form Pemeriksaan</h1>
                <p class="text-sm text-slate-400 mt-0.5">
                    {{ $pemeriksaan->pelayanan->pasien->nama }} —
                    Antrian #{{ $pemeriksaan->pelayanan->nomor_antrian }}
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Kolom Kiri: Form --}}
            <div class="lg:col-span-2">
                <form method="POST" action="{{ route('pemeriksaan.update', $pemeriksaan->id) }}">
                    @csrf
                    @method('PATCH')

                    <div class="space-y-4">

                        {{-- Treatment --}}
                        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
                            <h2 class="font-semibold text-slate-700 text-sm mb-4">Treatment</h2>
                            <select name="treatment_id"
                                class="w-full text-sm border border-slate-200 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-primary-500 text-slate-700">
                                <option value="">— Pilih Treatment —</option>
                                @foreach ($treatments as $treatment)
                                    <option value="{{ $treatment->id }}"
                                        {{ $pemeriksaan->treatment_id == $treatment->id ? 'selected' : '' }}>
                                        {{ $treatment->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Diagnosa & Tindakan --}}
                        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 space-y-4">
                            <h2 class="font-semibold text-slate-700 text-sm">Hasil Pemeriksaan</h2>

                            <div>
                                <label class="text-xs text-slate-500 mb-1.5 block">Diagnosa</label>
                                <textarea name="diagnosa" rows="3"
                                    class="w-full text-sm border border-slate-200 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-primary-500 resize-none"
                                    placeholder="Tuliskan diagnosa...">{{ old('diagnosa', $pemeriksaan->diagnosa) }}</textarea>
                            </div>

                            <div>
                                <label class="text-xs text-slate-500 mb-1.5 block">Tindakan</label>
                                <textarea name="tindakan" rows="3"
                                    class="w-full text-sm border border-slate-200 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-primary-500 resize-none"
                                    placeholder="Tuliskan tindakan yang dilakukan...">{{ old('tindakan', $pemeriksaan->tindakan) }}</textarea>
                            </div>
                        </div>

                        {{-- Resep & Catatan --}}
                        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 space-y-4">
                            <h2 class="font-semibold text-slate-700 text-sm">Produk & Catatan</h2>

                            {{-- Produk --}}
                            <div>
                                <label class="text-xs text-slate-500 mb-2 block">Produk / Resep</label>
                                <div class="space-y-2 max-h-48 overflow-y-auto pr-1">
                                    @foreach ($produks as $produk)
                                        <label
                                            class="flex items-center gap-3 p-2.5 rounded-xl border border-slate-100 hover:bg-slate-50 cursor-pointer transition">
                                            <input type="checkbox" name="produk_ids[]" value="{{ $produk->id }}"
                                                {{ $pemeriksaan->produks->contains($produk->id) ? 'checked' : '' }}
                                                class="rounded border-slate-300 text-primary-600 focus:ring-primary-500">
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-slate-700">{{ $produk->nama }}</p>
                                            </div>
                                            <span class="text-xs text-slate-400 shrink-0">
                                                Rp {{ number_format($produk->harga, 0, ',', '.') }}
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Catatan --}}
                            <div>
                                <label class="text-xs text-slate-500 mb-1.5 block">Catatan Tambahan</label>
                                <textarea name="catatan" rows="2"
                                    class="w-full text-sm border border-slate-200 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-primary-500 resize-none"
                                    placeholder="Catatan tambahan...">{{ old('catatan', $pemeriksaan->catatan) }}</textarea>
                            </div>
                        </div>

                        {{-- Submit --}}
                        <div class="flex items-center justify-end gap-3">
                            <a href="{{ route('pelayanan.index') }}"
                                class="px-5 py-2.5 text-sm text-slate-600 hover:text-slate-800 border border-slate-200 hover:bg-slate-50 rounded-xl transition-all">
                                Batal
                            </a>
                            <button type="submit"
                                class="px-5 py-2.5 text-sm font-medium bg-primary-600 hover:bg-primary-700 text-white rounded-xl transition-all">
                                Simpan Pemeriksaan
                            </button>
                        </div>

                    </div>
                </form>
            </div>

            {{-- Kolom Kanan: Info Pasien --}}
            <div class="space-y-4">

                {{-- Info Pasien --}}
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
                    <h3 class="font-semibold text-slate-700 text-sm mb-4">Pasien</h3>
                    <div class="flex items-center gap-3 mb-4">
                        <div
                            class="w-10 h-10 rounded-full bg-primary-100 text-primary-700 flex items-center justify-center font-bold text-sm shrink-0">
                            {{ strtoupper(substr($pemeriksaan->pelayanan->pasien->nama ?? '?', 0, 1)) }}
                        </div>
                        <div>
                            <p class="font-semibold text-slate-800 text-sm">
                                {{ $pemeriksaan->pelayanan->pasien->nama ?? '—' }}</p>
                            <p class="text-xs text-slate-400">{{ $pemeriksaan->pelayanan->pasien->no_rm ?? '' }}</p>
                        </div>
                    </div>
                    <div class="space-y-2.5">
                        <div class="flex justify-between">
                            <span class="text-xs text-slate-400">No. HP</span>
                            <span class="text-xs text-slate-700">{{ $pemeriksaan->pelayanan->pasien->no_hp ?? '—' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-xs text-slate-400">Jenis Kelamin</span>
                            <span
                                class="text-xs text-slate-700">{{ $pemeriksaan->pelayanan->pasien->jenis_kelamin ?? '—' }}</span>
                        </div>
                    </div>
                </div>

                {{-- Info Pelayanan --}}
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
                    <h3 class="font-semibold text-slate-700 text-sm mb-4">Pelayanan</h3>
                    <div class="space-y-2.5">
                        <div class="flex justify-between">
                            <span class="text-xs text-slate-400">Tanggal</span>
                            <span class="text-xs text-slate-700">
                                {{ \Carbon\Carbon::parse($pemeriksaan->pelayanan->tanggal)->translatedFormat('d F Y') }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-xs text-slate-400">Antrian</span>
                            <span
                                class="text-xs font-medium text-slate-700">#{{ $pemeriksaan->pelayanan->nomor_antrian }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-xs text-slate-400">Keluhan</span>
                            <span class="text-xs text-slate-700">{{ $pemeriksaan->pelayanan->keluhan ?? '—' }}</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
