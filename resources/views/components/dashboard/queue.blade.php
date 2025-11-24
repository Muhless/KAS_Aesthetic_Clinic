@php
    $name = 'Rina Rani';
    $gender = 'female';
@endphp

<div class="bg-white shadow-md rounded-xl p-5 border border-gray-100">
    <h1 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
        Pasien Selanjutnya
    </h1>

    <div class="flex flex-col items-center text-center space-y-1">
        <h1 class="text-3xl font-semibold text-gray-900">
            <span class="text-primary-600">
                {{ $gender === 'female' ? 'Ny.' : 'Tn.' }}
            </span>
            <span class="font-bold">{{ $name }}</span>
        </h1>

        <p class="text-gray-500 text-sm tracking-wide">
            Facial Treatment • <span class="font-medium text-gray-700">Dr. Muhta Nuryadi</span>
        </p>
    </div>
</div>
