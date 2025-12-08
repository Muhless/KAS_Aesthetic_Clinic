@extends('layouts.app')

@section('title', 'Daftar Produk')

@section('content')
    <div class="p-6">
        <x-notification />

        <!-- Header -->
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

        <!-- Grid Produk -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse ($produks as $produk)
                <x-produk.card :produk="$produk" />
            @empty
                <div class="col-span-full">
                    <div class="text-center py-16 bg-white rounded-2xl border-2 border-dashed border-gray-300">
                        <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum ada produk</h3>
                        <p class="text-gray-600">Mulai tambahkan produk pertama Anda</p>
                    </div>
                </div>
            @endforelse
        </div>

    </div>
@endsection
