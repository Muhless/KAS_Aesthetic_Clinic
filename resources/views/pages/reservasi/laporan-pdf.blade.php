<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Reservasi</title>
    <style>
    body {
        font-family: sans-serif;
        font-size: 12px;
        color: #333;
    }

    .header {
        text-align: center;
        margin-bottom: 10px;
    }

    .header h2 {
        margin: 0;
    }

    .filter-info {
        font-size: 10px;
        color: #555;
        margin-bottom: 15px;
        text-align: center;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    th,
    td {
        border: 1px solid #999;
        padding: 6px 8px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }

    .text-center {
        text-align: center;
    }
    </style>
</head>

<body>

    <div class="header">
        <h2>Laporan Reservasi</h2>
    </div>

    <div class="filter-info">
        @php
        $filterAktif = array_filter($filterInfo);
        @endphp
        @if (count($filterAktif) > 0)
        Filter:
        @foreach ($filterAktif as $key => $value)
        {{ ucfirst($key) }}: <strong>{{ $value }}</strong>@if (!$loop->last), @endif
        @endforeach
        @else
        Menampilkan seluruh data reservasi
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th class="text-center" width="30">No</th>
                <th>Pasien</th>
                <th>Dokter</th>
                <th>Tanggal</th>
                <th class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($reservasis as $i => $reservasi)
            <tr>
                <td class="text-center">{{ $i + 1 }}</td>
                <td>{{ $reservasi->pasien->nama ?? '-' }}</td>
                <td>{{ $reservasi->dokter->nama ?? '-' }}</td>
                <td>{{ \Carbon\Carbon::parse($reservasi->tanggal)->translatedFormat('d F Y') }}</td>
                <td class="text-center">{{ ucfirst($reservasi->status) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">Tidak ada data reservasi.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <p style="margin-top: 20px; font-size: 10px; text-align: right;">
        Dicetak pada: {{ \Carbon\Carbon::now()->translatedFormat('d F Y H:i') }}
    </p>

</body>

</html>
