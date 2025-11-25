@extends('layouts.app')

@section('title', 'Daftar Treatment')

@section('content')
    <div class="p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-primary-400">Treatment</h1>

            <div x-data="{ open: false }">
                <button @click="open = true"
                    class="cursor-pointer text-sm w-52 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg shadow">
                    Tambah Treatment
                </button>
                <x-patient.modal />
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">

            <x-treatment.card title="Facial Glow Whitening"
                description="Perawatan untuk mencerahkan wajah dengan serum whitening premium." :price="250000" />

            <x-treatment.card title="Laser Acne Removal"
                description="Menghilangkan jerawat dan bekas jerawat menggunakan teknologi laser." :price="450000" />

            <x-treatment.card title="Anti Aging Premium"
                description="Perawatan untuk mengencangkan kulit dan mengurangi kerutan." :price="650000" />

            <x-treatment.card title="Laser Acne Removal"
                description="Menghilangkan jerawat dan bekas jerawat menggunakan teknologi laser." :price="450000" />

        </div>

    </div>

@endsection
