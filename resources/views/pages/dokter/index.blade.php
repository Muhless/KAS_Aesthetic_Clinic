@extends('layouts.app')

@section('title', 'Halaman Dokter')

@section('content')
    <div class="p-6" x-data="dokterModal()">
        <x-notification />

        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-3xl font-bold text-primary-400">Dokter</h1>
                <p class="text-sm text-gray-400 mt-1">
                    {{ $dokters->count() }} Dokter terdaftar
                </p>
            </div>
            <div x-data="{ open: false }">
                <button @click="open = true"
                    class="cursor-pointer text-sm w-52 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-md shadow">
                    Tambah Dokter
                </button>
                <x-dokter.modal />
            </div>
        </div>

        {{-- Di halaman dokter --}}
        <div
            class="grid grid-flow-col auto-cols-[290px] gap-4 overflow-x-auto mt-6 pb-2 snap-x snap-mandatory scrollbar-hide items-start">
            @foreach ($dokters as $dokter)
                <div class="snap-start">
                    <x-dokter.card :dokter="$dokter" />
                </div>
            @endforeach
        </div>
    </div>
@endsection
