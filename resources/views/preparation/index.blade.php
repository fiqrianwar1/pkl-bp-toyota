<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 flex items-center gap-2">
            {{-- Ganti Icon ke Preparation (misal: spray-can) --}}
            <i class="fa-solid fa-spray-can-sparkles text-blue-600"></i>
            {{ ('Daftar Preparation') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-2xl p-6 border border-gray-100">
                
                <div class="flex justify-between items-center mb-5">
                    {{-- Ganti Route ke preparation.create --}}
                    <a href="{{ route('preparation.create') }}" 
                        class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow transition duration-200">
                        <i class="fa-solid fa-plus mr-2"></i> Tambah Data Preparation
                    </a>

                    {{-- Ganti Route ke preparation.index --}}
                    <form method="GET" action="{{ route('preparation.index') }}" class="flex gap-2 items-center">
                        <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Cari No. SPK atau Mekanik..."
                                class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring focus:ring-blue-200 focus:outline-none w-64">
                        
                        <button type="submit"
                                class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow transition duration-200">
                            <i class="fa-solid fa-search mr-2"></i> Cari
                        </button>
                    </form>
                </div>

                @if(session('success'))
                    <div class="bg-green-100 text-green-700 border border-green-300 px-4 py-3 rounded-lg mb-4 flex items-center">
                        <i class="fa-solid fa-circle-check mr-2"></i>
                        {{ session('success') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-200 text-sm rounded-lg overflow-hidden">
                        <thead class="bg-blue-50 text-blue-800 uppercase text-xs">
                            <tr>
                                <th class="px-4 py-3 text-left">No</th>
                                <th class="px-4 py-3 text-left">Mekanik</th>
                                <th class="px-4 py-3 text-left">No. SPK</th>
                                <th class="px-4 py-3 text-left">Tanggal</th>
                                <th class="px-4 py-3 text-left">Jam Mulai</th>
                                <th class="px-4 py-3 text-left">Jam Selesai</th>
                                <th class="px-4 py-3 text-left">Status</th>
                                <th class="px-4 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            {{-- Ganti variabel $bodies -> $preparations dan $body -> $preparation --}}
                            @forelse ($preparations as $preparation)
                                <tr class="hover:bg-blue-50 transition">
                                    <td class="px-4 py-2">{{ $loop->iteration + $preparations->firstItem() - 1 }}</td>
                                    <td class="px-4 py-2 font-semibold text-gray-800">{{ $preparation->mekanik->nama ?? '-' }}</td>
                                    <td class="px-4 py-2">{{ $preparation->spk->no_spk ?? '-' }}</td>
                                    <td class="px-4 py-2">{{ $preparation->tanggal ? $preparation->tanggal->translatedFormat('d F Y') : '-' }}</td>
                                    <td class="px-4 py-2">{{ $preparation->jam_mulai ? \Carbon\Carbon::parse($preparation->jam_mulai)->format('H:i') : '-' }}</td>
                                    <td class="px-4 py-2">{{ $preparation->jam_selesai ? \Carbon\Carbon::parse($preparation->jam_selesai)->format('H:i') : '-' }}</td>
                                    <td class="px-4 py-2">
                                        <span @class([
                                            'px-3 py-1 rounded-full text-xs font-semibold text-white',
                                            'bg-green-600' => $preparation->status == 'Selesai',
                                            'bg-yellow-500' => $preparation->status == 'Proses',
                                            'bg-red-500' => $preparation->status == 'Antri',
                                            'bg-gray-400' => !in_array($preparation->status, ['Selesai', 'Proses', 'Antri'])
                                        ])>
                                            {{ $preparation->status ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-2 text-center">
                                        <div class="flex justify-center gap-2">
                                            
                                            <button data-id="{{ $preparation->id }}"
                                                class="btn-detail bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded-md text-xs font-medium shadow transition flex items-center gap-1">
                                                <i class="fa-solid fa-circle-info"></i> Detail
                                            </button>

                                            <a href="{{ route('preparation.edit', $preparation->id) }}" 
                                               class="bg-green-600 hover:bg-green-700 text-white px-3 py-1.5 rounded-md text-xs font-medium shadow transition flex items-center gap-1">
                                                <i class="fa-solid fa-pen-to-square"></i> Edit
                                            </a>

                                            <form action="{{ route('preparation.destroy', $preparation->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded-md text-xs font-medium shadow transition flex items-center gap-1">
                                                    <i class="fa-solid fa-trash"></i> Hapus
                                                </button>
                                            </form>
                                            
                                            <a href="{{ route('preparation.report', $preparation->id) }}" target="_blank"
                                               class="bg-gray-700 hover:bg-gray-800 text-white px-3 py-1.5 rounded-md text-xs font-medium shadow transition flex items-center gap-1">
                                                <i class="fa-solid fa-print"></i> Cetak
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-4 py-3 text-center text-gray-500 italic">
                                        <i class="fa-solid fa-circle-info mr-1"></i> Belum ada data Preparation
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-6">
                    {{ $preparations->links() }}
                </div>

            </div>
        </div>
    </div>

    {{-- Modal Detail --}}
    <div id="detailModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 transition-opacity duration-300 ease-out opacity-0">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-xl p-6 relative transform scale-95 transition-transform duration-300 ease-out">
            <h2 class="text-lg font-semibold mb-4 border-b pb-2 text-gray-700 flex items-center gap-2">
                {{-- Ganti Icon dan Judul --}}
                <i class="fa-solid fa-spray-can-sparkles text-blue-600"></i> Detail Pengerjaan Preparation
            </h2>
            
            <div id="modal_details_body" class="overflow-y-auto max-h-96 pr-2">
                <table class="w-full text-sm border border-gray-200 rounded-lg overflow-hidden mb-4">
                     <tbody>
                        <tr class="bg-gray-50"><th class="border px-3 py-2 w-1/3 text-left">No SPK</th><td class="border px-3 py-2 font-semibold" id="d_no_spk">Memuat...</td></tr>
                        <tr><th class="border px-3 py-2 w-1/3 text-left bg-gray-50">Mekanik</th><td class="border px-3 py-2" id="d_mekanik">Memuat...</td></tr>
                        <tr><th class="border px-3 py-2 w-1/3 text-left bg-gray-50">Tanggal</th><td class="border px-3 py-2" id="d_tanggal">Memuat...</td></tr>
                        <tr><th class="border px-3 py-2 w-1/3 text-left bg-gray-50">Jam Mulai</th><td class="border px-3 py-2" id="d_jam_mulai">Memuat...</td></tr>
                        <tr><th class="border px-3 py-2 w-1/3 text-left bg-gray-50">Jam Selesai</th><td class="border px-3 py-2" id="d_jam_selesai">Memuat...</td></tr>
                        <tr><th class="border px-3 py-2 w-1/3 text-left bg-gray-50">Status</th><td class="border px-3 py-2" id="d_status">Memuat...</td></tr>
                    </tbody>
                </table>
                 <h3 class="text-md font-semibold mb-2 text-gray-700">Bahan Digunakan:</h3>
                 <div id="d_bahan" class="border p-3 rounded-lg bg-blue-50 text-blue-800 text-sm min-h-[50px]">Memuat...</div>
            </div>
            
            <div class="mt-4 pt-3 border-t flex justify-end gap-2">
                <a id="btnCetak" href="#" target="_blank"
                   class="bg-gray-700 hover:bg-gray-800 text-white text-sm px-4 py-2 rounded-lg shadow flex items-center gap-1">
                    <i class="fa-solid fa-print"></i> Cetak Laporan
                </a>
                <button id="closeModal"
                        class="bg-red-600 hover:bg-red-700 text-white text-sm px-4 py-2 rounded-lg shadow flex items-center gap-1">
                    <i class="fa-solid fa-xmark"></i> Tutup
                </button>
            </div>
        </div>
    </div>

    {{-- Script Modal & Fetch Data --}}
    <script>
        // 🔥 GANTI URL ROUTE KE PREPARATION
        const baseReportUrl = "{{ route('preparation.report', ['id' => 'PLACEHOLDER']) }}"; 
        const baseDetailUrl = "{{ route('preparation.show', ['preparation' => 'PLACEHOLDER']) }}"; // 🔥 Ganti ke route show

        document.addEventListener('DOMContentLoaded', function () {
            const detailModal = document.getElementById('detailModal');
            const modalContent = detailModal.querySelector('.transform');
            const btnCetakModal = document.getElementById('btnCetak');

            function showModal() {
                 detailModal.classList.remove('hidden');
                 setTimeout(() => {
                    detailModal.classList.remove('opacity-0');
                    modalContent.classList.remove('scale-95');
                 }, 10);
            }

            function hideModal() {
                detailModal.classList.add('opacity-0');
                modalContent.classList.add('scale-95');
                 setTimeout(() => {
                     detailModal.classList.add('hidden');
                 }, 300);
            }
            
            document.querySelectorAll('.btn-detail').forEach(btn => {
                btn.addEventListener('click', function () {
                    const id = this.dataset.id;
                    
                    document.getElementById('d_no_spk').textContent = 'Memuat...';
                    document.getElementById('d_mekanik').textContent = 'Memuat...';
                    document.getElementById('d_tanggal').textContent = 'Memuat...';
                    document.getElementById('d_jam_mulai').textContent = 'Memuat...';
                    document.getElementById('d_jam_selesai').textContent = 'Memuat...';
                    document.getElementById('d_status').textContent = 'Memuat...';
                    document.getElementById('d_bahan').textContent = 'Memuat...';
                    btnCetakModal.href = '#';
                    
                    showModal();

                    // 🔥 GANTI URL FETCH KE PREPARATION
                    fetch(baseDetailUrl.replace('PLACEHOLDER', id))
                        .then(res => {
                            if (!res.ok) { throw new Error(`HTTP error! status: ${res.status}`); }
                            return res.json();
                        })
                        .then(data => {
                            if (data.error) { throw new Error(data.error); }

                            document.getElementById('d_no_spk').textContent = data.no_spk || '-';
                            document.getElementById('d_mekanik').textContent = data.mekanik || '-';
                            document.getElementById('d_tanggal').textContent = data.tanggal || '-';
                            document.getElementById('d_jam_mulai').textContent = data.jam_mulai || '-';
                            document.getElementById('d_jam_selesai').textContent = data.jam_selesai || '-';
                            document.getElementById('d_status').textContent = data.status || '-';
                            document.getElementById('d_bahan').textContent = data.bahan || '-'; 
                            
                            // 🔥 Ganti URL Cetak
                            btnCetakModal.href = baseReportUrl.replace('PLACEHOLDER', data.id);

                        })
                        .catch(error => {
                            console.error('Error saat memuat detail:', error);
                            document.getElementById('d_no_spk').textContent = 'Error';
                            document.getElementById('d_bahan').textContent = `Gagal memuat: ${error.message}`;
                            btnCetakModal.href = '#';
                        });
                });
            });

            document.getElementById('closeModal').addEventListener('click', hideModal);

            detailModal.addEventListener('click', function(event) {
                if (event.target === detailModal) {
                    hideModal();
                }
            });
        });
    </script>
</x-app-layout>
