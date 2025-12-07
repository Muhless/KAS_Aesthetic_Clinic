<table class="min-w-full border border-gray-300 rounded-md overflow-hidden">
    <thead class="bg-gray-100">
        <tr>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 border-b">No</th>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 border-b">Nama</th>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 border-b">No. Telepon</th>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 border-b">Tanggal Lahir</th>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 border-b">Aksi</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($patients as $index => $patient)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-2 border-b text-sm text-gray-700">{{ $index + 1 }}</td>
                <td class="px-4 py-2 border-b text-sm text-gray-700">{{ $patient->name }}</td>
                <td class="px-4 py-2 border-b text-sm text-gray-700">{{ $patient->phone }}</td>
                <td class="px-4 py-2 border-b text-sm text-gray-700">
                    {{ $patient->birth_date ? $patient->birth_date->format('d-m-Y') : '-' }}
                </td>
                <td class="px-4 py-2 border-b text-sm text-gray-700">
                    <a href="/patients/{{ $patient->id }}" class="text-blue-600 hover:underline">Detail</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
