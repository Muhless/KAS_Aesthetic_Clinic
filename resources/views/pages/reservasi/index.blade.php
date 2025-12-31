@extends('layouts.app')

@section('title', 'Halaman Reservasi - KAS Aesthetic Clinic')

@section('content')
    <div class="p-6" x-data="PerawatModal()">
        <x-notification />

        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-primary-400">Reservasi</h1>
            <div x-data="{ open: false }">
                <button @click="open = true"
                    class="cursor-pointer text-sm w-52 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-md shadow">
                    Tambah Reservasi
                </button>
                <x-reservasi.modal />
            </div>
        </div>

        <div class="bg-white p-2 rounded-md">
            <x-reservasi.tabel />
        </div>

    </div>
@endsection
