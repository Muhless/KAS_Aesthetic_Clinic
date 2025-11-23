@extends('layouts.app')

@section('title', 'Data Pasien')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-green-600">Data Pasien</h1>

        <h1 class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg shadow">
            + Tambah Pasien
        </h1>
    </div>

    <div class="bg-white shadow rounded-lg p-6">
        <table class="min-w-full border border-gray-200">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-4 py-2 border">No</th>
                    <th class="px-4 py-2 border">Nama Pasien</th>
                    <th class="px-4 py-2 border">Usia</th>
                    <th class="px-4 py-2 border">Alamat</th>
                    <th class="px-4 py-2 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                {{-- Dummy data, nanti diganti dengan @foreach --}}
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2 border text-center">1</td>
                    <td class="px-4 py-2 border">Ahmad Firmansyah</td>
                    <td class="px-4 py-2 border text-center">28</td>
                    <td class="px-4 py-2 border">Bandung</td>
                    <td class="px-4 py-2 border text-center">
                        <a href="#" class="text-blue-600 hover:underline">Detail</a> |
                        <a href="#" class="text-yellow-600 hover:underline">Edit</a> |
                        <a href="#" class="text-red-600 hover:underline">Hapus</a>
                    </td>
                </tr>

                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2 border text-center">2</td>
                    <td class="px-4 py-2 border">Siti Nurina</td>
                    <td class="px-4 py-2 border text-center">34</td>
                    <td class="px-4 py-2 border">Jakarta</td>
                    <td class="px-4 py-2 border text-center">
                        <a href="#" class="text-blue-600 hover:underline">Detail</a> |
                        <a href="#" class="text-yellow-600 hover:underline">Edit</a> |
                        <a href="#" class="text-red-600 hover:underline">Hapus</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
