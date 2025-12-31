@extends('layouts.app')

@section('title', 'Halaman Pembayaran - KAS Aesthetic Clinic')

@section('content')
    @php

        $summary = [
            'pendapatan_hari_ini' => 2450000,
            'pendapatan_bulan_ini' => 45670000,
            'total_transaksi' => 127,
            'pending_payment' => 3,
        ];

        $dataPembayaran = [
            [
                'antrian' => '0009',
                'nama' => 'Budi Santoso',
                'dokter' => 'Dr. Rina Rani',
                'harga_dokter' => 100000,
                'treatment' => 'Facial Acne',
                'harga_treatment' => 120000,
                'produk' => [
                    (object) ['nama' => 'Serum Acne Clear', 'qty' => 1, 'subtotal' => 30000],
                    (object) ['nama' => 'Serum Acne Clear', 'qty' => 1, 'subtotal' => 30000],
                    (object) ['nama' => 'Serum Acne Clear', 'qty' => 1, 'subtotal' => 30000],
                    (object) ['nama' => 'Serum Acne Clear', 'qty' => 1, 'subtotal' => 30000],
                    (object) ['nama' => 'Toner Acne', 'qty' => 2, 'subtotal' => 40000],
                ],
            ],
            [
                'antrian' => '0010',
                'nama' => 'Siti Aminah',
                'dokter' => 'Dr. Andi Wijaya',
                'harga_dokter' => 120000,
                'treatment' => 'Brightening Facial',
                'harga_treatment' => 150000,
                'produk' => [],
            ],
        ];
    @endphp

    <div class="p-6 space-y-6">
        <x-notification />

        <h1 class="text-3xl font-bold text-primary-400">Keuangan</h1>


        <div class="grid grid-cols-2 gap-6">
            <div class="space-y-6">
                <x-keuangan.transaksiHarian />
                <x-keuangan.hari />
                <x-keuangan.transaksiBulanan />
                <x-keuangan.bulan />
            </div>
            <div class="grid grid-cols-2 gap-6">
                @foreach ($dataPembayaran as $pembayaran)
                    <x-keuangan.card :pembayaran="$pembayaran" />
                @endforeach
            </div>

        </div>

    </div>
@endsection
