<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Data Treatment</title>
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

    .text-right {
        text-align: right;
    }

    .status-tersedia {
        color: #16a34a;
        font-weight: bold;
    }

    .status-tidak {
        color: #dc2626;
        font-weight: bold;
    }
    </style>
</head>

<body>

    <div class="header">
        <h2>Laporan Data Treatment</h2>
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
        Menampilkan seluruh data treatment
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th class="text-center" width="30">No</th>
                <th>Nama Treatment</th>
                <th>Deskripsi</th>
                <th class="text-right">Harga</th>
                <th class="text-center">Durasi (menit)</th>
                <th class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($treatments as $i => $treatment)
            <tr>
                <td class="text-center">{{ $i + 1 }}</td>
                <td>{{ $treatment->nama }}</td>
                <td>{{ \Illuminate\Support\Str::limit($treatment->deskripsi, 60) ?: '-' }}</td>
                <td class="text-right">Rp {{ number_format($treatment->harga, 0, ',', '.') }}</td>
                <td class="text-center">{{ $treatment->durasi ?? '-' }}</td>
                <td class="text-center {{ $treatment->status == 'tersedia' ? 'status-tersedia' : 'status-tidak' }}">
                    {{ $treatment->status == 'tersedia' ? 'Tersedia' : 'Tidak Tersedia' }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Tidak ada data treatment.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <p style="margin-top: 20px; font-size: 10px; text-align: right;">
        Dicetak pada: {{ \Carbon\Carbon::now()->translatedFormat('d F Y H:i') }}
    </p>

</body>

</html>
