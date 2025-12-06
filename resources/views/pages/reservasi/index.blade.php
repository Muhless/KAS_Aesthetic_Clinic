@extends('layouts.app')

@section('content')
    <div class="p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-primary-400">Treatment</h1>

            <div x-data="{ open: false }">
                <button @click="open = true"
                    class="cursor-pointer text-sm w-52 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg shadow">
                    Tambah Reservasi
                </button>
                <x-reservasi.modal />
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-300 rounded-lg overflow-hidden">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 border-b">No</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 border-b">Nama Pasien</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 border-b">Dokter</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 border-b">Tanggal</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 border-b">Jam</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 border-b">Status</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 border-b">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($reservasis as $index => $reservation)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 border-b text-sm text-gray-700">{{ $index + 1 }}</td>

                            <td class="px-4 py-2 border-b text-sm text-gray-700">
                                {{ $reservation->pasien->name }}
                            </td>

                            <td class="px-4 py-2 border-b text-sm text-gray-700">
                                {{ $reservation->dokter->nama }}
                            </td>


                            <td class="px-4 py-2 border-b text-sm text-gray-700">
                                {{ \Carbon\Carbon::parse($reservation->tanggal)->format('d-m-Y') }}
                            </td>

                            <td class="px-4 py-2 border-b text-sm text-gray-700">
                                {{ $reservation->jam }}
                            </td>

                            <td class="px-4 py-2 border-b text-sm text-gray-700">
                                <span
                                    class="px-2 py-1 rounded text-xs
                            @if ($reservation->status == 'pending') bg-yellow-100 text-yellow-700
                            @elseif($reservation->status == 'confirmed')
                            @elseif($reservation->status == 'cancelled') @endif
                        ">
                                    {{ ucfirst($reservation->status) }}
                                </span>
                            </td>

                            <td class="px-4 py-2 border-b text-sm text-gray-700 flex gap-2">

                                <a href="{{ route('reservasis.show', $reservation->id) }}"
                                    class="text-blue-600 hover:underline">
                                    Detail
                                </a>

                                <a href="{{ route('reservasis.edit', $reservation->id) }}"
                                    class="text-yellow-600 hover:underline">
                                    Edit
                                </a>

                                <form action="{{ route('reservasis.destroy', $reservation->id) }}" method="POST"
                                    onsubmit="return confirm('Hapus reservasi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 hover:underline">Hapus</button>
                                </form>

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-6 text-center text-gray-500">
                                Belum ada data reservasi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
