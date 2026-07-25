<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Data Pasien</title>
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
        <h2>Laporan Data Pasien</h2>
    </div>

    <div class="filter-info">
        @php
        $filterAktif = array_filter($filterInfo);
        @endphp
        @if (count($filterAktif) > 0)
        Filter:
        @foreach ($filterAktif as $key => $value)
        {{ ucfirst(str_replace('_', ' ', $key)) }}: <strong>{{ $value }}</strong>@if (!$loop->last), @endif
        @endforeach
        @else
        Menampilkan seluruh data pasien
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th class="text-center" width="30">No</th>
                <th>Nama</th>
                <th class="text-center">Jenis Kelamin</th>
                <th>Tanggal Lahir</th>
                <th>No. Telepon</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pasiens as $i => $pasien)
            <tr>
                <td class="text-center">{{ $i + 1 }}</td>
                <td>{{ $pasien->nama }}</td>
                <td class="text-center">{{ $pasien->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                <td>{{ $pasien->tanggal_lahir ? \Carbon\Carbon::parse($pasien->tanggal_lahir)->translatedFormat('d F Y') : '-' }}
                </td>
                <td>{{ $pasien->nomor_telepon ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Tidak ada data pasien.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <p style="margin-top: 20px; font-size: 10px; text-align: right;">
        Dicetak pada: {{ \Carbon\Carbon::now()->translatedFormat('d F Y H:i') }}
    </p>

</body>

</html>
