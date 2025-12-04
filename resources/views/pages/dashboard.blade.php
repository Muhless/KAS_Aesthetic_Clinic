@extends('layouts.app')

@section('title', 'Halaman Awal')

@section('content')
    <div class="h-screen grid grid-cols-4">
        {{-- kiri --}}
        <div class="col-span-3 space-y-10 p-6 h-screen overflow-y-auto">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
                <x-dashboard.card title="Reservasi" value="128" />
                <x-dashboard.card title="Antrian" value="128" />
                <x-dashboard.card title="Dokter" value="128" />
                <x-dashboard.card title="Pendapatan" value="128" />

            </div>
            <x-dashboard.nextQueue />
            <x-dashboard.table />
        </div>
        {{-- kanan --}}
        <div class="bg-primary-50 p-6 h-screen space-y-3">
            <div class="flex flex-col justify-between h-full">
                <div class="space-y-14">
                    <x-dashboard.user />
                    {{-- <x-dashboard.greeting /> --}}
                    <x-dashboard.doctor />
                </div>

                <div class="space-y-3">
                    <x-dashboard.promo />
                </div>
            </div>
        </div>
    </div>
@endsection
