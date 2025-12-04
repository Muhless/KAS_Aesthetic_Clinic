@extends('layouts.app')

@section('title', 'Halaman Dokter - KAS Aesthetic Clinic')


@section('content')

    <div class="p-6" x-data="dokterModal()">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-primary-400">Dokter</h1>

            {{-- <button @click="open = true"
                class="cursor-pointer text-sm w-52 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg shadow">
                Tambah Dokter
            </button> --}}
        </div>

        <div class="grid grid-cols-4 gap-4">
            @foreach ($dokters as $dokter)
                <x-dokter.card :dokter="$dokter" />
            @endforeach
        </div>

        <!-- Modal Component -->
        <x-dokter.modal />

        <!-- Alpine.js Script -->
        <script>
            function dokterModal() {
                return {
                    open: false,
                    form: {
                        id: '',
                        nama: '',
                        no_telepon: '',
                        email: '',
                        tanggal_lahir: '',
                    },

                    async editDokter(id) {
                        this.open = true;

                        const res = await fetch(`/api/dokter/${id}`);
                        const json = await res.json();

                        this.form = json.data;
                    }
                }
            }
        </script>
    </div>

@endsection
