@extends('layouts.app')

@section('title', 'Halaman Pembayaran - KAS Aesthetic Clinic')

@section('content')
    @php
        $dataPembayaran = [
            [
                'antrian' => '0009',
                'nama' => 'Budi Santoso',
                'dokter' => 'Dr. Rina Rani',
                'harga_dokter' => 100000,
                'treatment' => 'Facial Acne',
                'harga_treatment' => 120000,
                'produk' => [
                    (object)['nama' => 'Serum Acne Clear', 'qty' => 1, 'subtotal' => 30000],
                    (object)['nama' => 'Serum Acne Clear', 'qty' => 1, 'subtotal' => 30000],
                    (object)['nama' => 'Serum Acne Clear', 'qty' => 1, 'subtotal' => 30000],
                    (object)['nama' => 'Serum Acne Clear', 'qty' => 1, 'subtotal' => 30000],
                    (object)['nama' => 'Toner Acne', 'qty' => 2, 'subtotal' => 40000],
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
            [
                'antrian' => '0011',
                'nama' => 'Ahmad Fauzi',
                'dokter' => 'Dr. Rina Rani',
                'harga_dokter' => 100000,
                'treatment' => 'Acne Injection',
                'harga_treatment' => 200000,
                'produk' => [
                    (object)['nama' => 'Acne Spot Gel', 'qty' => 1, 'subtotal' => 50000],
                ],
            ],
            [
                'antrian' => '0012',
                'nama' => 'Dewi Lestari',
                'dokter' => 'Dr. Maya Putri',
                'harga_dokter' => 130000,
                'treatment' => 'Anti Aging Facial',
                'harga_treatment' => 180000,
                'produk' => [
                    (object)['nama' => 'Serum Anti Aging', 'qty' => 1, 'subtotal' => 75000],
                    (object)['nama' => 'Night Cream', 'qty' => 1, 'subtotal' => 65000],
                ],
            ],
        ];
    @endphp

    <div class="p-6">
        <x-notification />

        <h1 class="text-3xl font-bold text-primary-400">Pembayaran</h1>

        <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($dataPembayaran as $pembayaran)
                <x-pembayaran.card :pembayaran="$pembayaran" />
            @endforeach
        </div>

    </div>
@endsection
