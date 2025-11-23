@extends('layouts.app')

@section('title', 'Daftar Treatment')

@section('content')

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Daftar Treatment</h1>
        <a href="/treatments/create" class="bg-pink-600 text-white px-4 py-2 rounded-lg hover:bg-pink-700">
            + Tambah Treatment
        </a>
    </div>

    {{-- Tabel Treatment --}}
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full text-left border-collapse">
            <thead class="bg-pink-100 text-gray-700">
                <tr>
                    <th class="px-6 py-3 font-semibold">#</th>
                    <th class="px-6 py-3 font-semibold">Nama Treatment</th>
                    <th class="px-6 py-3 font-semibold">Kategori</th>
                    <th class="px-6 py-3 font-semibold">Harga</th>
                    <th class="px-6 py-3 font-semibold">Durasi</th>
                    <th class="px-6 py-3 font-semibold text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>
                {{-- Contoh data dummy, nanti diganti dari controller --}}
                <tr class="border-t">
                    <td class="px-6 py-3">1</td>
                    <td class="px-6 py-3">Facial Premium</td>
                    <td class="px-6 py-3">Skincare</td>
                    <td class="px-6 py-3">Rp 250.000</td>
                    <td class="px-6 py-3">45 Menit</td>
                    <td class="px-6 py-3 text-center space-x-2">
                        <a href="#" class="text-blue-600 hover:underline">Edit</a>
                        <a href="#" class="text-red-600 hover:underline">Hapus</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

@endsection
