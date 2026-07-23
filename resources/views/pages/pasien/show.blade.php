@extends('layouts.app')

@section('title', 'Detail Pasien - ' . $pasien->nama)

@section('content')
    <div class="p-4 space-y-4" x-data="{
        open: false,
        pasien: {},
        editPasien(id) {
            fetch(`/pasiens/${id}/api`)
                .then(r => r.json())
                .then(res => {
                    this.pasien = res.data;
                    this.open = true;
                });
        }
    }">

        {{-- Breadcrumb --}}
        <div class="flex items-center gap-2 text-sm text-slate-400">
            <a href="{{ route('pasien.index') }}" class="hover:text-blue-500 transition">Pasien</a>
            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <span class="text-slate-600 font-medium">{{ $pasien->nama }}</span>
        </div>

        {{-- Profil Pasien --}}
        <div class="bg-white rounded-md border border-slate-200 overflow-hidden">
            <div class="bg-blue-500 px-4 py-3">
                <div class="flex items-center gap-3">
                    {{-- Avatar --}}
                    <div class="w-12 h-12 rounded-full flex items-center justify-center text-white text-lg font-bold shrink-0 bg-white/20">
                        {{ strtoupper(substr($pasien->nama, 0, 1)) }}
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center gap-2">
                            <h1 class="text-base font-semibold text-white">{{ $pasien->nama }}</h1>
                            @if ($pasien->jenis_kelamin == 'L')
                                <span class="text-xs px-2 py-0.5 rounded bg-white/20 text-white">Laki-laki</span>
                            @elseif ($pasien->jenis_kelamin == 'P')
                                <span class="text-xs px-2 py-0.5 rounded bg-white/20 text-white">Perempuan</span>
                            @endif
                        </div>
                        <p class="text-blue-100 text-xs mt-0.5">
                            {{ $pasien->pelayanans->count() }} riwayat kunjungan
                        </p>
                    </div>

                    <button type="button" @click="editPasien({{ $pasien->id }})"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white/20 hover:bg-white/30 text-white text-xs rounded transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m2.695 14.762-1.262 3.155a.5.5 0 0 0 .65.65l3.155-1.262a4 4 0 0 0 1.343-.886L17.5 5.501a2.121 2.121 0 0 0-3-3L3.58 13.419a4 4 0 0 0-.885 1.343Z" />
                        </svg>
                        Edit
                    </button>

                    <button type="button" onclick="confirmDelete({{ $pasien->id }}, '{{ $pasien->nama }}')"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white/20 hover:bg-red-500 text-white text-xs rounded transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Hapus
                    </button>

                    {{-- Form delete hidden --}}
                    <form id="delete-form-{{ $pasien->id }}" action="{{ route('pasien.destroy', $pasien->id) }}"
                        method="POST" class="hidden">
                        @csrf
                        @method('DELETE')
                    </form>

                    <script>
                        function confirmDelete(id, nama) {
                            Swal.fire({
                                title: 'Hapus Pasien?',
                                text: `Yakin ingin menghapus pasien "${nama}"?`,
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#ef4444',
                                cancelButtonColor: '#6b7280',
                                confirmButtonText: 'Ya, Hapus!',
                                cancelButtonText: 'Batal'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    document.getElementById('delete-form-' + id).submit();
                                }
                            });
                        }
                    </script>
                </div>
            </div>

            {{-- Info Grid --}}
            <div class="grid grid-cols-2 sm:grid-cols-4 divide-x divide-y sm:divide-y-0 divide-slate-100">
                <div class="px-4 py-3">
                    <p class="text-xs text-slate-400 uppercase mb-1">Tanggal Lahir</p>
                    <p class="text-sm font-medium text-slate-700">
                        {{ $pasien->tanggal_lahir ? \Carbon\Carbon::parse($pasien->tanggal_lahir)->translatedFormat('d F Y') : '—' }}
                    </p>
                </div>
                <div class="px-4 py-3">
                    <p class="text-xs text-slate-400 uppercase mb-1">Umur</p>
                    <p class="text-sm font-medium text-slate-700">
                        {{ $pasien->tanggal_lahir ? \Carbon\Carbon::parse($pasien->tanggal_lahir)->age . ' tahun' : '—' }}
                    </p>
                </div>
                <div class="px-4 py-3">
                    <p class="text-xs text-slate-400 uppercase mb-1">Nomor Telepon</p>
                    <p class="text-sm font-medium text-slate-700 font-mono">
                        {{ $pasien->nomor_telepon ?? '—' }}
                    </p>
                </div>
                <div class="px-4 py-3">
                    <p class="text-xs text-slate-400 uppercase mb-1">Terdaftar</p>
                    <p class="text-sm font-medium text-slate-700">
                        {{ $pasien->created_at->translatedFormat('d F Y') }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Riwayat Pelayanan --}}
        <div>
            <h2 class="text-sm font-semibold text-slate-700 mb-3">Riwayat Kunjungan</h2>

            @if ($pasien->pelayanans->isNotEmpty())
                <div class="space-y-3">
                    @foreach ($pasien->pelayanans as $pelayanan)
                        <div class="bg-white rounded-md border border-slate-200 overflow-hidden">

                            {{-- Header Kunjungan --}}
                            <div class="flex items-center justify-between px-4 py-2.5 bg-slate-100 border-b border-slate-200">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-7 h-7 rounded-full bg-slate-200 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-slate-500"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-slate-700">
                                            {{ \Carbon\Carbon::parse($pelayanan->tanggal)->translatedFormat('d F Y') }}
                                        </p>
                                        <p class="text-xs text-slate-400">
                                            No. Antrian {{ $pelayanan->nomor_antrian }} &bull;
                                            {{ $pelayanan->dokter->nama ?? 'Dokter tidak tersedia' }}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    @if ($pelayanan->reservasi_id)
                                        <span class="text-xs px-2 py-1 rounded bg-violet-500 text-white font-medium">Reservasi</span>
                                    @else
                                        <span class="text-xs px-2 py-1 rounded bg-slate-400 text-white font-medium">Walk-in</span>
                                    @endif
                                    @if ($pelayanan->status == 'selesai')
                                        <span class="text-xs px-2 py-1 rounded bg-green-500 text-white font-medium">Selesai</span>
                                    @elseif ($pelayanan->status == 'dipanggil')
                                        <span class="text-xs px-2 py-1 rounded bg-blue-500 text-white font-medium">Dipanggil</span>
                                    @else
                                        <span class="text-xs px-2 py-1 rounded bg-yellow-500 text-white font-medium">Menunggu</span>
                                    @endif
                                    <a href="{{ route('pelayanan.show', $pelayanan->id) }}"
                                        class="text-xs px-2.5 py-1 rounded bg-blue-500 text-white hover:bg-blue-600 font-medium transition">
                                        Detail →
                                    </a>
                                </div>
                            </div>

                            {{-- Isi Kunjungan --}}
                            <div class="px-4 py-3">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">

                                    {{-- Keluhan --}}
                                    <div>
                                        <p class="text-xs font-medium text-slate-400 uppercase mb-1">Keluhan</p>
                                        <p class="text-sm text-slate-700">{{ $pelayanan->keluhan ?? '—' }}</p>
                                    </div>

                                    {{-- Pemeriksaan --}}
                                    @if ($pelayanan->pemeriksaan)
                                        <div>
                                            <p class="text-xs font-medium text-slate-400 uppercase mb-1">Treatment</p>
                                            <p class="text-sm text-slate-700">
                                                {{ $pelayanan->pemeriksaan->treatment->nama ?? '—' }}</p>
                                        </div>

                                        <div>
                                            <p class="text-xs font-medium text-slate-400 uppercase mb-1">Diagnosa</p>
                                            <p class="text-sm text-slate-700">{{ $pelayanan->pemeriksaan->diagnosa ?? '—' }}</p>
                                        </div>

                                        <div>
                                            <p class="text-xs font-medium text-slate-400 uppercase mb-1">Tindakan</p>
                                            <p class="text-sm text-slate-700">{{ $pelayanan->pemeriksaan->tindakan ?? '—' }}</p>
                                        </div>

                                        @if ($pelayanan->pemeriksaan->resep)
                                            <div>
                                                <p class="text-xs font-medium text-slate-400 uppercase mb-1">Resep</p>
                                                <p class="text-sm text-slate-700">{{ $pelayanan->pemeriksaan->resep }}</p>
                                            </div>
                                        @endif

                                        @if ($pelayanan->pemeriksaan->catatan)
                                            <div>
                                                <p class="text-xs font-medium text-slate-400 uppercase mb-1">Catatan</p>
                                                <p class="text-sm text-slate-700">{{ $pelayanan->pemeriksaan->catatan }}</p>
                                            </div>
                                        @endif
                                    @else
                                        <div class="sm:col-span-1">
                                            <p class="text-xs text-slate-400 italic">Belum ada hasil pemeriksaan</p>
                                        </div>
                                    @endif
                                </div>

                                {{-- Pembayaran --}}
                                @if ($pelayanan->pembayaran)
                                    <div class="mt-3 pt-3 border-t border-slate-100 flex items-center justify-between">
                                        <div class="flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-400"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                            <span class="text-sm font-semibold text-slate-700">
                                                Rp {{ number_format($pelayanan->pembayaran->total_harga, 0, ',', '.') }}
                                            </span>
                                            @if ($pelayanan->pembayaran->metode_bayar)
                                                <span class="text-xs text-slate-400">via
                                                    {{ ucfirst($pelayanan->pembayaran->metode_bayar) }}</span>
                                            @endif
                                        </div>
                                        @if ($pelayanan->pembayaran->status == 'lunas')
                                            <span class="text-xs px-2 py-1 rounded bg-green-500 text-white font-medium">Lunas</span>
                                        @else
                                            <span class="text-xs px-2 py-1 rounded bg-red-500 text-white font-medium">Belum Bayar</span>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Empty State --}}
            @else
                <div class="bg-white rounded-md border border-slate-200 flex flex-col items-center justify-center py-14 px-6">
                    <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-slate-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <p class="text-sm font-medium text-slate-600">Belum ada riwayat kunjungan</p>
                    <p class="text-xs text-slate-400 mt-1">Pasien belum pernah melakukan kunjungan</p>
                </div>
            @endif
        </div>
        <x-pasien.modal />
    </div>
@endsection
