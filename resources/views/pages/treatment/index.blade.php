@extends('layouts.app')

@section('title', 'Daftar Treatment - KAS Aesthetic Clinic')

@section('content')
    <div class="p-6" x-data="{ open: false }">
        <x-notification />

        {{-- Header --}}
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-primary-400">Treatment</h1>
                <p class="text-sm text-gray-400 mt-1">{{ $treatments->count() }} treatment terdaftar</p>
            </div>
            <button @click="open = true"
                class="inline-flex items-center gap-2 cursor-pointer text-sm px-5 py-2.5 bg-primary-600 hover:bg-primary-700 active:bg-primary-800 text-white rounded-lg shadow transition-all duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Treatment
            </button>
        </div>

        {{-- Grid --}}
        @if ($treatments->isNotEmpty())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                @foreach ($treatments as $treatment)
                    <x-treatment.card :treatment="$treatment" />
                @endforeach
            </div>

        {{-- Empty State --}}
        @else
            <div class="flex flex-col items-center justify-center py-24 px-6">
                <div class="relative mb-6">
                    <div class="w-28 h-28 rounded-full bg-primary-50 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-14 h-14 text-primary-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <div class="absolute -bottom-1 -right-1 w-8 h-8 rounded-full bg-primary-600 flex items-center justify-center shadow-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                        </svg>
                    </div>
                </div>
                <h3 class="text-lg font-semibold text-gray-700 mb-1">Belum ada treatment</h3>
                <p class="text-sm text-gray-400 text-center max-w-sm mb-6">
                    Tambahkan treatment pertama untuk mulai melayani pasien.
                </p>
                <button @click="open = true"
                    class="inline-flex items-center gap-2 text-sm px-6 py-2.5 bg-primary-600 hover:bg-primary-700 text-white rounded-lg shadow transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Treatment Pertama
                </button>
            </div>
        @endif

        {{-- Modal --}}
        <x-treatment.modal />
    </div>
@endsection
