@extends('layouts.app')

@section('title', 'Halaman Produk')

@section('content')
    <div class="p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-primary-400">Produk</h1>

            <div x-data="{ open: false }">
                <button @click="open = true"
                    class="cursor-pointer text-sm w-52 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg shadow">
                    Tambah Produk
                </button>
                <x-patient.modal />
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            <x-product.card title="Serum Whitening" category="Skin Care" price="185000" stock="12"
                image="images/serum.jpg" />

            <x-product.card title="Krim Anti-Aging" category="Perawatan Wajah" price="225000" stock="5" />
            <x-product.card title="Serum Whitening" category="Skin Care" price="185000" stock="12"
                image="images/serum.jpg" />

            <x-product.card title="Krim Anti-Aging" category="Perawatan Wajah" price="225000" stock="5" />
        </div>
    </div>
@endsection
