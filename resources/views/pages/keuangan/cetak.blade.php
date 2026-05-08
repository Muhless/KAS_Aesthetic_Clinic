<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pembayaran #{{ $pembayaran->id }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Courier New', monospace;
            font-size: 11px;
            width: 80mm;
            margin: 0 auto;
            padding: 8px;
            color: #000;
        }

        .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }

        .bold {
            font-weight: bold;
        }

        .divider {
            border-top: 1px dashed #000;
            margin: 6px 0;
        }

        .row {
            display: flex;
            justify-content: space-between;
            margin: 2px 0;
        }

        .row-label {
            flex: 1;
        }

        .row-value {
            text-align: right;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            font-weight: bold;
            font-size: 13px;
            margin: 4px 0;
        }

        @media print {
            body {
                width: 80mm;
                margin: 0;
                padding: 4px;
            }

            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>

    {{-- Header Klinik --}}
    <div class="center">
        <div class="bold" style="font-size: 14px;">KAS AESTHETIC</div>
        <div>Clinic Management</div>
        <div>Telaga Bestari, Tangerang</div>
    </div>

    <div class="divider"></div>

    {{-- Info Struk --}}
    <div class="row">
        <span class="row-label">No.</span>
        <span class="row-value">#{{ str_pad($pembayaran->id, 4, '0', STR_PAD_LEFT) }}</span>
    </div>
    <div class="row">
        <span class="row-label">Tanggal</span>
        <span class="row-value">{{ \Carbon\Carbon::parse($pembayaran->dibayar_pada)->format('d/m/Y H:i') }}</span>
    </div>
    <div class="row">
        <span class="row-label">Kasir</span>
        <span class="row-value">Admin</span>
    </div>

    <div class="divider"></div>

    {{-- Info Pasien --}}
    <div class="row">
        <span class="row-label">Pasien</span>
        <span class="row-value">{{ $pembayaran->pelayanan->pasien->nama ?? '—' }}</span>
    </div>
    <div class="row">
        <span class="row-label">Dokter</span>
        <span class="row-value">{{ $pembayaran->pelayanan->dokter->nama ?? '—' }}</span>
    </div>

    <div class="divider"></div>

    {{-- Item --}}
    <div class="bold" style="margin-bottom: 4px;">Rincian</div>

    {{-- Biaya Konsultasi --}}
    @if ($pembayaran->pelayanan->dokter && $pembayaran->pelayanan->dokter->biaya_konsultasi > 0)
        <div class="row">
            <span class="row-label">Konsultasi</span>
            <span class="row-value">Rp
                {{ number_format($pembayaran->pelayanan->dokter->biaya_konsultasi, 0, ',', '.') }}</span>
        </div>
    @endif

    {{-- Treatment --}}
    @if ($pembayaran->pelayanan->pemeriksaan && $pembayaran->pelayanan->pemeriksaan->treatment)
        <div class="row">
            <span class="row-label">{{ $pembayaran->pelayanan->pemeriksaan->treatment->nama }}</span>
            <span class="row-value">Rp
                {{ number_format($pembayaran->pelayanan->pemeriksaan->treatment->harga, 0, ',', '.') }}</span>
        </div>
    @endif

    {{-- Produk --}}
    @if ($pembayaran->pelayanan->pemeriksaan)
        @foreach ($pembayaran->pelayanan->pemeriksaan->produks as $produk)
            <div class="row">
                <span class="row-label">{{ $produk->nama }}</span>
                <span class="row-value">Rp {{ number_format($produk->harga, 0, ',', '.') }}</span>
            </div>
        @endforeach
    @endif

    <div class="divider"></div>

    {{-- Total --}}
    <div class="total-row">
        <span>TOTAL</span>
        <span>Rp {{ number_format($pembayaran->total_harga, 0, ',', '.') }}</span>
    </div>

    <div class="row">
        <span class="row-label">Metode</span>
        <span class="row-value">{{ strtoupper($pembayaran->metode_bayar ?? '—') }}</span>
    </div>
    <div class="row">
        <span class="row-label">Status</span>
        <span class="row-value">{{ strtoupper($pembayaran->status) }}</span>
    </div>

    <div class="divider"></div>

    {{-- Footer --}}
    <div class="center" style="margin-top: 6px;">
        <div>Terima kasih atas kunjungan Anda</div>
        <div>Semoga lekas sembuh 🌸</div>
    </div>

    {{-- Tombol Print --}}
    <div class="no-print" style="margin-top: 16px; text-align: center;">
        <button onclick="window.print()"
            style="padding: 8px 20px; background: #000; color: #fff; border: none; border-radius: 6px; cursor: pointer; font-size: 12px;">
            🖨️ Cetak Struk
        </button>
    </div>

</body>

</html>
