@extends('layouts.app')

@section('title', 'Dokter')

@section('content')
    <h1 class="text-3xl font-bold mb-6 text-kas">Data Dokter</h1>

    <!-- Top Bar -->
    <div class="flex justify-between items-center mb-6">
        <p class="text-gray-600">Kelola data dokter yang tersedia di klinik.</p>

        <a href="/doctor/create"
            class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg shadow text-sm transition">
            + Tambah Dokter
        </a>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl shadow p-6">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b bg-gray-50">
                        <th class="py-3 px-2 font-semibold text-gray-600">Nama Dokter</th>
                        <th class="py-3 px-2 font-semibold text-gray-600">Spesialis</th>
                        <th class="py-3 px-2 font-semibold text-gray-600">No. HP</th>
                        <th class="py-3 px-2 font-semibold text-gray-600">Status</th>
                        <th class="py-3 px-2 font-semibold text-gray-600 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y">

                    <!-- Dummy row 1 -->
                    <tr>
                        <td class="py-3 px-2">dr. Rahmawati</td>
                        <td>Dokter Kecantikan</td>
                        <td>0812-4455-6677</td>
                        <td>
                            <span class="px-3 py-1 bg-green-100 text-green-600 rounded-full text-sm">Aktif</span>
                        </td>
                        <td class="py-3 text-center">
                            <a href="#" class="text-blue-600 hover:underline mx-1">Edit</a>
                            <a href="#" class="text-red-600 hover:underline mx-1">Hapus</a>
                        </td>
                    </tr>

                    <!-- Dummy row 2 -->
                    <tr>
                        <td class="py-3 px-2">dr. Andika Pratama</td>
                        <td>Spesialis Kulit</td>
                        <td>0895-7743-8811</td>
                        <td>
                            <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-sm">Cuti</span>
                        </td>
                        <td class="py-3 text-center">
                            <a href="#" class="text-blue-600 hover:underline mx-1">Edit</a>
                            <a href="#" class="text-red-600 hover:underline mx-1">Hapus</a>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>
@endsection
