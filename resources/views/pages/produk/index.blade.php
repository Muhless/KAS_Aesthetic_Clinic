@extends('layouts.app')

@section('title', 'Halaman Produk')

@section('content')
    <div class="p-6">
          @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 relative"
                x-data="{ show: true }" x-show="show" x-transition>
                <span class="block sm:inline">{{ session('success') }}</span>
                <button @click="show = false" class="absolute top-0 right-0 px-4 py-3">
                    <span class="text-2xl">&times;</span>
                </button>
            </div>
        @endif

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-primary-400">Produk</h1>

            <div x-data="{ open: false }">
                <button @click="open = true"
                    class="cursor-pointer text-sm w-52 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-md shadow">
                    Tambah Produk
                </button>
                <x-produk.modal />
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            <x-produk.card title="Serum Whitening" category="Skin Care" price="185000" stock="12"
                image="images/serum.jpg" />

            <x-produk.card title="Krim Anti-Aging" category="Perawatan Wajah" price="225000" stock="5" />
            <x-produk.card title="Serum Whitening" category="Skin Care" price="185000" stock="12"
                image="images/serum.jpg" />

            <x-produk.card title="Krim Anti-Aging" category="Perawatan Wajah" price="225000" stock="5" />
        </div>
    </div>
@endsection
