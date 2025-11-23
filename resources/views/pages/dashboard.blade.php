@extends('layouts.app')

@section('title')
    Dashboard
@endsection

@section('content')
    <h1 class="text-3xl font-bold mb-6 text-kas">Dashboard</h1>

    <!-- Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">

        <!-- Card 1 -->
        <div class="bg-white p-6 rounded-xl shadow">
            <h3 class="text-lg font-semibold text-gray-600">Total Pasien</h3>
            <p class="text-4xl font-bold text-kas mt-3">128</p>
        </div>

        <!-- Card 2 -->
        <div class="bg-white p-6 rounded-xl shadow">
            <h3 class="text-lg font-semibold text-gray-600">Booking Hari Ini</h3>
            <p class="text-4xl font-bold text-kas mt-3">14</p>
        </div>

        <!-- Card 3 -->
        <div class="bg-white p-6 rounded-xl shadow">
            <h3 class="text-lg font-semibold text-gray-600">Pendapatan Bulan Ini</h3>
            <p class="text-3xl font-bold text-kas mt-3">Rp 32.700.000</p>
        </div>
    </div>

    <!-- Table Appointment -->
    <div class="bg-white rounded-xl shadow p-6">
        <h3 class="text-xl font-bold mb-4">Janji Temu Hari Ini</h3>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b">
                        <th class="py-3">Nama Pasien</th>
                        <th class="py-3">Treatment</th>
                        <th class="py-3">Jam</th>
                        <th class="py-3">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y">

                    <tr>
                        <td class="py-3">Ayu Lestari</td>
                        <td>Chemical Peeling</td>
                        <td>10:00</td>
                        <td><span class="px-3 py-1 bg-green-100 text-green-600 rounded-full">Selesai</span></td>
                    </tr>

                    <tr>
                        <td class="py-3">Nanda Putri</td>
                        <td>Facial Glow</td>
                        <td>12:30</td>
                        <td><span class="px-3 py-1 bg-yellow-100 text-yellow-600 rounded-full">Menunggu</span></td>
                    </tr>

                    <tr>
                        <td class="py-3">Rika Amelia</td>
                        <td>Laser Acne</td>
                        <td>15:00</td>
                        <td><span class="px-3 py-1 bg-blue-100 text-blue-600 rounded-full">Proses</span></td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>
@endsection
