@extends('layouts.app')

@section('title', 'Halaman Awal')

@section('content')
    <div class="h-full space-y-3">
        <h1 class="text-3xl font-bold mb-8 tracking-wide">
            Halaman Awal
        </h1>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
            <x-dashboard.card title="Total pasien" value="128" />
            <x-dashboard.card title="Total pasien" value="128" />
            <x-dashboard.card title="Total pasien" value="128" />
            <x-dashboard.card title="Total pasien" value="128" />
        </div>
        <x-dashboard.table />
    </div>
@endsection
