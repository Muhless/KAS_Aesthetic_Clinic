@extends('layouts.app')

@section('title', 'Detail Pembayaran - KAS Aesthetic Clinic')

@section('content')
    <div class="p-6 space-y-6">

        {{-- Header --}}
        <div class="flex items-center gap-4">
            <a href="{{ route('keuangan.index') }}"
                class="p-2 rounded-xl text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                    <path fill-rule="evenodd"
                        d="M17 10a.75.75 0 0 1-.75.75H5.612l4.158 3.96a.75.75 0 1 1-1.04 1.08l-5.5-5.25a.75.75 0 0 1 0-1.08l5.5-5.25a.75.75 0 1 1 1.04 1.08L5.612 9.25H16.25A.75.75 0 0 1 17 10Z"
                        clip-rule="evenodd" />
                </svg>
            </a>
            <div>
                <h1 class="text-lg font-semibold text-slate-800">Detail Pembayaran</h1>
                <p class="text-sm text-slate-400 mt-0.5">Pembayaran #{{ $pembayaran->id }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Kolom Kiri: Info Pembayaran + Pemeriksaan --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Info Pembayaran --}}
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                    <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
                        <h2 class="font-semibold text-slate-700 text-sm">Informasi Pembayaran</h2>
                        @if ($pembayaran->status === 'lunas')
                            <span
                                class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-600">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 inline-block"></span>
                                Lunas
                            </span>
                        @else
                            <span
                                class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-rose-50 text-rose-600">
                                <span class="w-1.5 h-1.5 rounded-full bg-rose-400 inline-block"></span>
                                Belum Bayar
                            </span>
                        @endif
                    </div>
                    <div class="p-5 grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs text-slate-400 mb-1">Total Harga</p>
                            <p class="text-xl font-bold text-slate-800">Rp
                                {{ number_format($pembayaran->total_harga, 0, ',', '.') }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 mb-1">Metode Bayar</p>
                            <p class="text-sm font-medium text-slate-700">{{ $pembayaran->metode_bayar ?? '—' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 mb-1">Dibayar Pada</p>
                            <p class="text-sm text-slate-700">
                                {{ $pembayaran->dibayar_pada
                                    ? \Carbon\Carbon::parse($pembayaran->dibayar_pada)->translatedFormat('d F Y, H:i')
                                    : '—' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 mb-1">Tanggal Dibuat</p>
                            <p class="text-sm text-slate-700">
                                {{ \Carbon\Carbon::parse($pembayaran->created_at)->translatedFormat('d F Y, H:i') }}
                            </p>
                        </div>
                        @if ($pembayaran->catatan)
                            <div class="col-span-2">
                                <p class="text-xs text-slate-400 mb-1">Catatan</p>
                                <p class="text-sm text-slate-700">{{ $pembayaran->catatan }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Info Pelayanan --}}
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                    <div class="px-5 py-4 border-b border-slate-100">
                        <h2 class="font-semibold text-slate-700 text-sm">Informasi Pelayanan</h2>
                    </div>
                    <div class="p-5 grid grid-cols-2 gap-4">
                        @if ($pembayaran->pelayanan)
                            <div>
                                <p class="text-xs text-slate-400 mb-1">Tanggal Pelayanan</p>
                                <p class="text-sm text-slate-700">
                                    {{ \Carbon\Carbon::parse($pembayaran->pelayanan->tanggal)->translatedFormat('d F Y') }}
                                </p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400 mb-1">Nomor Antrian</p>
                                <p class="text-sm font-medium text-slate-700">#{{ $pembayaran->pelayanan->nomor_antrian }}
                                </p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400 mb-1">Keluhan</p>
                                <p class="text-sm text-slate-700">{{ $pembayaran->pelayanan->keluhan ?? '—' }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400 mb-1">Status Pelayanan</p>
                                @php $statusPelayanan = $pembayaran->pelayanan->status @endphp
                                @if ($statusPelayanan === 'selesai')
                                    <span
                                        class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-600">Selesai</span>
                                @elseif($statusPelayanan === 'dipanggil')
                                    <span
                                        class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-600">Dipanggil</span>
                                @else
                                    <span
                                        class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-amber-50 text-amber-600">Menunggu</span>
                                @endif
                            </div>
                        @else
                            <div class="col-span-2 text-sm text-slate-400">Data pelayanan tidak ditemukan.</div>
                        @endif
                    </div>
                </div>

                {{-- Pemeriksaan --}}
                @if ($pembayaran->pelayanan)
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                        <div class="px-5 py-4 border-b border-slate-100">
                            <h2 class="font-semibold text-slate-700 text-sm">Hasil Pemeriksaan</h2>
                        </div>
                        <div class="p-5 space-y-4">
                            @if ($pembayaran->pelayanan->pemeriksaan->treatment_id)
                                <div>
                                    <p class="text-xs text-slate-400 mb-1">Treatment</p>
                                    <p class="text-sm text-slate-700">
                                        {{ $pembayaran->pelayanan->pemeriksaan->treatment->nama ?? '—' }}</p>
                                </div>
                            @endif
                            @if ($pembayaran->pelayanan->pemeriksaan->diagnosa)
                                <div>
                                    <p class="text-xs text-slate-400 mb-1">Diagnosa</p>
                                    <p class="text-sm text-slate-700">{{ $pembayaran->pelayanan->pemeriksaan->diagnosa }}
                                    </p>
                                </div>
                            @endif
                            @if ($pembayaran->pelayanan->pemeriksaan->tindakan)
                                <div>
                                    <p class="text-xs text-slate-400 mb-1">Tindakan</p>
                                    <p class="text-sm text-slate-700">{{ $pembayaran->pelayanan->pemeriksaan->tindakan }}
                                    </p>
                                </div>
                            @endif
                            @if ($pembayaran->pelayanan->pemeriksaan->resep)
                                <div>
                                    <p class="text-xs text-slate-400 mb-1">Resep</p>
                                    <p class="text-sm text-slate-700">{{ $pembayaran->pelayanan->pemeriksaan->resep }}</p>
                                </div>
                            @endif
                            @if ($pembayaran->pelayanan->pemeriksaan->catatan)
                                <div>
                                    <p class="text-xs text-slate-400 mb-1">Catatan</p>
                                    <p class="text-sm text-slate-700">{{ $pembayaran->pelayanan->pemeriksaan->catatan }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

            </div>

            {{-- Kolom Kanan: Info Pasien + Dokter + Aksi --}}
            <div class="space-y-4">
                <a href="{{ route('keuangan.cetak', $pembayaran->id) }}" target="_blank"
                    class="w-full py-2.5 bg-slate-700 hover:bg-slate-800 text-white text-sm font-medium rounded-xl transition-all text-center block">
                    🖨️ Cetak Struk
                </a>
                {{-- Info Pasien --}}
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
                    <h3 class="font-semibold text-slate-700 text-sm mb-4">Pasien</h3>
                    <div class="flex items-center gap-3 mb-4">
                        <div
                            class="w-10 h-10 rounded-full bg-primary-100 text-primary-700 flex items-center justify-center font-bold text-sm shrink-0">
                            {{ strtoupper(substr($pembayaran->pelayanan->pasien->nama ?? '?', 0, 1)) }}
                        </div>
                        <div>
                            <p class="font-semibold text-slate-800 text-sm">
                                {{ $pembayaran->pelayanan->pasien->nama ?? '—' }}</p>
                            <p class="text-xs text-slate-400">{{ $pembayaran->pelayanan->pasien->no_rm ?? '' }}</p>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-xs text-slate-400">No. HP</span>
                            <span class="text-xs text-slate-700">{{ $pembayaran->pelayanan->pasien->no_hp ?? '—' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-xs text-slate-400">Jenis Kelamin</span>
                            <span
                                class="text-xs text-slate-700">{{ $pembayaran->pelayanan->pasien->jenis_kelamin ?? '—' }}</span>
                        </div>
                    </div>
                </div>

                {{-- Info Dokter --}}
                @if ($pembayaran->pelayanan)
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
                        <h3 class="font-semibold text-slate-700 text-sm mb-4">Dokter</h3>
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-sm shrink-0">
                                {{ strtoupper(substr($pembayaran->pelayanan->dokter->nama ?? '?', 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-semibold text-slate-800 text-sm">
                                    {{ $pembayaran->pelayanan->dokter->nama ?? '—' }}</p>
                                <p class="text-xs text-slate-400">{{ $pembayaran->pelayanan->dokter->spesialis ?? '' }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Aksi: Tandai Lunas --}}
                @if ($pembayaran->status !== 'lunas')
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
                        <h3 class="font-semibold text-slate-700 text-sm mb-3">Aksi</h3>
                        <form method="POST" action="{{ route('keuangan.bayar', $pembayaran->id) }}">
                            @csrf
                            @method('PATCH')
                            <div class="space-y-3">
                                <input type="hidden" name="metode_bayar" value="cash">
                                <div>
                                    <label class="text-xs text-slate-500 mb-1 block">Catatan (opsional)</label>
                                    <textarea name="catatan" rows="2"
                                        class="w-full text-sm border border-slate-200 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500 resize-none"
                                        placeholder="Tambahkan catatan..."></textarea>
                                </div>
                                <button type="submit"
                                    class="w-full py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-medium rounded-xl transition-all"
                                    onclick="return confirm('Tandai pembayaran ini sebagai lunas?')">
                                    Tandai Lunas
                                </button>
                            </div>
                        </form>
                    </div>
                @endif

            </div>
        </div>
    </div>
@endsection
