@extends('layouts.app')

@section('title', 'Halaman Pasien - KAS Aesthetic Clinic')

@section('content')
    <div class="p-6">
        <x-notification />

        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-primary-400">Pasien</h1>

            <div x-data="{ open: false }">
                <button @click="open = true"
                    class="cursor-pointer text-sm w-52 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-md shadow">
                    Tambah Pasien
                </button>
                <x-pasien.modal />
            </div>

        </div>

        <div class="bg-white p-2 rounded-md">
            <x-pasien.table :pasiens="$pasiens" />
        </div>

    </div>
@endsection
