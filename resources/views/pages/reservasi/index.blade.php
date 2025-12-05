@extends('layouts.app')

@section('title', 'Halaman Reservasi')

@section('content')
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-primary-400">Reservasi</h1>

            <div x-data="{ open: false }">
                <button @click="open = true"
                    class="cursor-pointer text-sm w-52 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg shadow">
                    Tambah Reservasi
                </button>
                <x-reservasi.modal />
            </div>
        </div>
        <div>
            <x-dokter.table />
        </div>
    </div>

@endsection
