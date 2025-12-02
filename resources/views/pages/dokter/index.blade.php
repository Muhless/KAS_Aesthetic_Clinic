@extends('layouts.app')

@section('title', 'Dokter')

@section('content')
    <div class="p-6 ">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-primary-400">Dokter</h1>

            <div x-data="{ open: false }">
                <button @click="open = true"
                    class="cursor-pointer text-sm w-52 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg shadow">
                    Tambah Dokter
                </button>
                <x-patient.modal />
            </div>
        </div>
        <div class="grid grid-cols-4 gap-4">
            @foreach ($dokters as $dokter)
                <x-dokter.card :dokter="$dokter" />
            @endforeach
        </div>

    </div>

@endsection
