   {{-- Daftar Pasien Hari Ini --}}
   <div class="lg:col-span-2 bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
       <div class="px-5 py-4 border-b border-gray-100">
           <h2 class="font-semibold text-gray-700 text-sm">Pasien Hari Ini</h2>
       </div>
       <div class="overflow-x-auto">
           <table class="w-full text-sm">
               <thead>
                   <tr class="bg-gray-50 text-xs text-gray-400 uppercase tracking-wider">
                       <th class="px-5 py-3 text-left font-medium w-12">No</th>
                       <th class="px-5 py-3 text-left font-medium">Pasien</th>
                       <th class="px-5 py-3 text-left font-medium">Keluhan</th>
                       <th class="px-5 py-3 text-left font-medium">Status</th>
                       <th class="px-5 py-3 text-center font-medium">Aksi</th>
                   </tr>
               </thead>
               <tbody class="divide-y divide-gray-50">
                   @forelse ($pelayanans as $pelayanan)
                       <tr class="hover:bg-gray-50 transition">
                           <td class="px-5 py-3.5">
                               <div
                                   class="w-7 h-7 rounded-full bg-primary-100 text-primary-700 flex items-center justify-center font-bold text-xs">
                                   {{ $pelayanan->nomor_antrian }}
                               </div>
                           </td>
                           <td class="px-5 py-3.5">
                               <div class="flex items-center gap-2.5">
                                   <div
                                       class="w-7 h-7 rounded-full bg-gray-100 text-gray-600 flex items-center justify-center font-semibold text-xs shrink-0">
                                       {{ strtoupper(substr($pelayanan->pasien->nama, 0, 1)) }}
                                   </div>
                                   <span class="font-medium text-gray-800">{{ $pelayanan->pasien->nama }}</span>
                               </div>
                           </td>
                           <td class="px-5 py-3.5 text-gray-500 max-w-xs truncate">
                               {{ $pelayanan->keluhan ?? '—' }}
                           </td>
                           <td class="px-5 py-3.5">
                               @if ($pelayanan->status == 'menunggu')
                                   <span
                                       class="text-xs px-2.5 py-1 rounded-full bg-yellow-50 text-yellow-600 font-medium">Menunggu</span>
                               @elseif ($pelayanan->status == 'dipanggil')
                                   <span
                                       class="text-xs px-2.5 py-1 rounded-full bg-blue-50 text-blue-600 font-medium">Dipanggil</span>
                               @else
                                   <span
                                       class="text-xs px-2.5 py-1 rounded-full bg-green-50 text-green-600 font-medium">Selesai</span>
                               @endif
                           </td>
                           <td class="px-5 py-3.5 text-center">
                               <a href="{{ route('pemeriksaan.edit', $pelayanan->pemeriksaan->id) }}"
                                   class="inline-flex
                                   items-center gap-1 text-xs px-3 py-1.5 bg-primary-50 hover:bg-primary-100
                                   text-primary-600 rounded-lg transition font-medium">
                                   <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none"
                                       viewBox="0 0 24 24" stroke="currentColor">
                                       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                           d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                   </svg>
                                   Periksa
                               </a>
                           </td>
                       </tr>
                   @empty
                       <tr>
                           <td colspan="5" class="py-12 text-center">
                               <div class="flex flex-col items-center gap-2 text-gray-400">
                                   <div class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center">
                                       <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-300"
                                           fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                               d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                                       </svg>
                                   </div>
                                   <p class="text-sm font-medium text-gray-500">Tidak ada pasien hari ini</p>
                               </div>
                           </td>
                       </tr>
                   @endforelse
               </tbody>
           </table>
       </div>
   </div>
