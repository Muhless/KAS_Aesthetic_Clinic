<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Laporan Transaksi</title>
    <style>
    body {
        font-family: sans-serif;
        font-size: 12px;
        color: #1f2937;
    }

    .header {
        text-align: center;
        border-bottom: 2px solid #1f2937;
        padding-bottom: 10px;
        margin-bottom: 16px;
    }

    .header h1 {
        margin: 0;
        font-size: 18px;
    }

    .header p {
        margin: 2px 0 0;
        font-size: 11px;
        color: #6b7280;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        padding: 6px 8px;
        border-bottom: 1px solid #e5e7eb;
        text-align: left;
    }

    th {
        background: #f9fafb;
        font-size: 10px;
        text-transform: uppercase;
        color: #6b7280;
    }

    td.right,
    th.right {
        text-align: right;
    }

    tfoot td {
        font-weight: bold;
        border-top: 2px solid #1f2937;
        border-bottom: none;
    }
    </style>
</head>

<body>

    <div class="header">
        <h1>KAS Aesthetic Clinic</h1>
        <p>Laporan Transaksi — {{ $labelPeriode }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Pasien</th>
                <th>Tanggal</th>
                <th>Metode</th>
                <th class="right">Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($transaksis as $i => $transaksi)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $transaksi->pelayanan->pasien->nama ?? '—' }}</td>
                <td>{{ \Carbon\Carbon::parse($transaksi->dibayar_pada)->translatedFormat('d M Y, H:i') }}</td>
                <td>{{ ucfirst($transaksi->metode_bayar ?? '—') }}</td>
                <td class="right">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align:center; color:#9ca3af;">Tidak ada transaksi pada periode ini.</td>
            </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4">Total Pemasukan</td>
                <td class="right">Rp {{ number_format($transaksis->sum('total_harga'), 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <p style="margin-top: 24px; font-size: 10px; color: #9ca3af;">
        Dicetak pada {{ now()->translatedFormat('d F Y, H:i') }}
    </p>

</body>

</html>
