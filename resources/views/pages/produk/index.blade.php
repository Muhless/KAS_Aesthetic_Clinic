@extends('layouts.app')

@section('title', 'Halaman Produk - KAS Aesthetic Clinic')

@section('content')
<div class="p-4 space-y-4" x-data="{
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
    <div class="flex items-center justify-between border-b border-black/10 pb-3">
        <div>
            <h1 class="text-xl font-semibold text-slate-700">Produk</h1>
            <p class="text-xs text-slate-400">{{ $produks->count() }} produk terdaftar</p>
        </div>
        <button @click="tambahProduk()"
            class="inline-flex items-center gap-1.5 cursor-pointer text-xs px-3 py-1.5 bg-blue-500 hover:bg-blue-600 text-white rounded-sm transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
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
    <div
        class="bg-white rounded-sm shadow-[0_0.5rem_1rem_rgba(0,0,0,0.1)] border border-black/10 flex flex-col items-center justify-center py-16 px-6">
        <div class="w-16 h-16 rounded-full bg-slate-100 flex items-center justify-center mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-slate-400" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
            </svg>
        </div>
        <h3 class="text-sm font-semibold text-slate-600 mb-1">Belum ada produk</h3>
        <p class="text-xs text-slate-400 text-center max-w-sm mb-4">
            Tambahkan produk pertama untuk mulai mengelola inventori klinik.
        </p>
        <button @click="tambahProduk()"
            class="inline-flex items-center gap-1.5 cursor-pointer text-xs px-3 py-1.5 bg-blue-500 hover:bg-blue-600 text-white rounded-sm transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Produk
        </button>
    </div>
    @endif

    {{-- Modal --}}
    <x-produk.modal />
</div>
@endsection
