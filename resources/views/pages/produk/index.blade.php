@extends('layouts.app')

@section('title', 'Halaman Produk - KAS Aesthetic Clinic')

@section('content')
    <div class="p-6 space-y-6" x-data="{
        open: false,
        produk: {},
        tambahProduk() {
            this.produk = {};
            this.open = true;
        },
        editProduk(id) {
            fetch(`/produk/${id}/api`)
                .then(r => r.json())
                .then(res => {
                    this.produk = res.data;
                    this.open = true;
                });
        }
    }">
        <x-notification />

        {{-- Header --}}
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-primary-400">Produk</h1>
                <p class="text-sm text-gray-400 mt-1">{{ $produks->count() }} produk terdaftar</p>
            </div>
              <button @click="tambahProduk()"
                class="inline-flex items-center gap-2 cursor-pointer text-sm w-48 justify-center py-2.5 bg-primary-600 hover:bg-primary-700 active:bg-primary-800 text-white rounded-lg shadow transition-all duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Produk
            </button>
        </div>

        {{-- Grid --}}
        @if ($produks->isNotEmpty())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                @foreach ($produks as $produk)
                    <x-produk.card :produk="$produk" />
                @endforeach
            </div>

            {{-- Empty State --}}
        @else
            <div class="flex flex-col items-center justify-center py-24 px-6">
                <div class="relative mb-6">
                    <div class="w-28 h-28 rounded-full bg-primary-50 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-14 h-14 text-primary-300" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                    <div
                        class="absolute -bottom-1 -right-1 w-8 h-8 rounded-full bg-primary-600 flex items-center justify-center shadow-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                        </svg>
                    </div>
                </div>
                <h3 class="text-lg font-semibold text-gray-700 mb-1">Belum ada produk</h3>
                <p class="text-sm text-gray-400 text-center max-w-sm mb-6">
                    Tambahkan produk pertama untuk mulai mengelola inventori klinik.
                </p>
                <button @click="open = true"
                    class="inline-flex items-center gap-2 text-sm px-6 py-2.5 bg-primary-600 hover:bg-primary-700 text-white rounded-lg shadow transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Produk Pertama
                </button>
            </div>
        @endif

        {{-- Modal --}}
        <x-produk.modal />
    </div>
@endsection
