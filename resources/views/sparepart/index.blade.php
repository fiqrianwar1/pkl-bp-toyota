<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 flex items-center gap-2">
            <i class="fa-solid fa-gears text-blue-600"></i>
            {{ ('Daftar Sparepart') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-2xl p-6 border border-gray-100">

                {{-- Tombol Tambah & Pencarian --}}
                <div class="flex flex-col sm:flex-row justify-between items-center mb-5 gap-3">
                    <a href="{{ route('sparepart.create') }}" 
                        class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow transition duration-200">
                        <i class="fa-solid fa-plus mr-2"></i> Tambah Sparepart
                    </a>

                    {{-- Form Pencarian --}}
                    <form method="GET" action="{{ route('sparepart.index') }}" class="flex gap-2 items-center">
                        <input type="text" name="search" value="{{ request('search') }}" 
                                placeholder="Cari No. SPK atau Nama Customer..." 
                                class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring focus:ring-blue-200 focus:outline-none w-64">
                        <button type="submit" 
                                class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow transition duration-200">
                            <i class="fa-solid fa-search mr-2"></i> Cari
                        </button>
                    </form>
                </div>

                {{-- Notifikasi Sukses --}}
                @if (session('success'))
                    <div class="bg-green-100 text-green-700 border border-green-300 px-4 py-3 rounded-lg mb-4 flex items-center">
                        <i class="fa-solid fa-circle-check mr-2"></i>
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Tabel Data --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-200 text-sm rounded-lg overflow-hidden">
                        <thead class="bg-blue-50 text-blue-800 uppercase text-xs">
                            <tr>
                                <th class="px-4 py-3 text-left w-12">No</th>
                                <th class="px-4 py-3 text-left w-40">No. SPK</th> 
                                <th class="px-4 py-3 text-left">Customer</th>
                                <th class="px-4 py-3 text-right">Tgl Estimasi Datang</th>
                                <th class="px-4 py-3 text-right w-40">Total Harga Gabungan</th>
                                <th class="px-4 py-3 text-center w-32">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($spareparts as $sparepart)
                                @php
                                    $first_item = $sparepart->spk->spareparts()->first();
                                    $first_item_id = $first_item->id ?? 0;
                                @endphp
                                <tr class="hover:bg-blue-50 transition">
                                    <td class="px-4 py-2 text-gray-700 w-12">{{ $loop->iteration }}</td>
                                    
                                    {{-- Kolom No. SPK --}}
                                    <td class="px-4 py-2 w-40 font-semibold">{{ $sparepart->spk->no_spk ?? '-' }}</td>
                                    
                                    <td class="px-4 py-2">{{ $sparepart->spk->customer->nama ?? '-' }}</td>
                                    
                                    {{-- Tgl Estimasi Diambil dari item pertama dalam grouping --}}
                                    <td class="px-4 py-2 text-right">
                                        {{ \Carbon\Carbon::parse($sparepart->spk->spareparts()->first()->tgl_estimasi_datang ?? now())->translatedFormat('d M Y') }}
                                    </td> 
                                    
                                    {{-- Total Harga Gabungan --}}
                                    <td class="px-4 py-2 text-right font-semibold text-green-700 w-40">
                                        Rp {{ number_format($sparepart->total_harga_gabungan, 0, ',', '.') }}
                                    </td>
                                    
                                    <td class="px-4 py-2 text-center">
                                        <div class="flex justify-center gap-2">
                                            
                                            <button data-id="{{ $sparepart->spk_id }}"
                                                    class="btn-detail bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded-md text-xs shadow transition flex items-center gap-1">
                                                <i class="fa-solid fa-circle-info"></i> Detail
                                            </button>
                                            
                                            <a href="{{ route('sparepart.edit', $sparepart->spk_id) }}" 
                                            class="bg-green-600 hover:bg-green-700 text-white px-3 py-1.5 rounded-md text-xs shadow transition flex items-center gap-1">
                                                <i class="fa-solid fa-pen-to-square"></i> Edit
                                            </a>
                                            
                                            <form action="{{ route('sparepart.destroy', $first_item_id) }}" 
                                                    method="POST"
                                                    onsubmit="return confirm('PERINGATAN: Anda akan menghapus item sparepart pertama ({{ $first_item->nama_sparepart ?? 'N/A' }}).\n\nUntuk melihat dan menghapus item lain, gunakan tombol DETAIL.\n\nYakin ingin melanjutkan?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded-md text-xs shadow transition flex items-center gap-1">
                                                    <i class="fa-solid fa-trash"></i> Hapus
                                                </button>
                                            </form>
                                            
                                            <a href="{{ route('sparepart.report') }}?id_spk={{ $sparepart->spk_id }}" target="_blank"
                                               class="bg-gray-700 hover:bg-gray-800 text-white px-3 py-1.5 rounded-md text-xs shadow transition flex items-center gap-1">
                                                <i class="fa-solid fa-print"></i> Cetak
                                            </a>
                                            
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-3 text-center text-gray-500 italic">
                                        <i class="fa-solid fa-circle-info mr-1"></i> Belum ada data sparepart
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                        
                        {{-- Total Keseluruhan di Footer --}}
                        @if($spareparts->count() > 0)
                            <tfoot>
                                <tr class="bg-blue-100 font-bold text-gray-800">
                                    <td colspan="4" class="px-4 py-3 text-right border-t border-gray-300">Total Halaman Ini:</td>
                                    <td class="px-4 py-3 text-right border-t border-gray-300 text-green-700">
                                        Rp {{ number_format($spareparts->sum('total_harga_gabungan'), 0, ',', '.') }}
                                    </td>
                                    <td colspan="1" class="border-t border-gray-300"></td>
                                </tr>
                            </tfoot>
                        @endif
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="mt-4 flex justify-end">
                    {{ $spareparts->links() }}
                </div>
            </div>
        </div>
    </div>
    
    {{-- MODAL DETAIL --}}
    <div id="detailModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-4xl p-6 relative animate-fadeIn">
            <h2 class="text-lg font-semibold mb-4 border-b pb-2 text-gray-700 flex items-center gap-2">
                <i class="fa-solid fa-circle-info text-blue-600"></i> Detail Item Sparepart
            </h2>
            
            <div id="modal_details_body" class="overflow-y-auto max-h-96">
                
                {{-- PERBAIKAN: Container untuk No. SPK di atas tabel --}}
                <div class="mb-3">
                    <span class="font-bold text-base text-gray-900">No. SPK: </span>
                    <span id="modal_no_spk" class="text-blue-600 font-bold"></span>
                </div>
                
                <table class="w-full text-sm border border-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-3 py-2 border text-left">Nama Sparepart/Panel</th>
                            <th class="px-3 py-2 border text-center w-16">Jumlah</th>
                            <th class="px-3 py-2 border text-right w-32">Harga Satuan</th>
                            <th class="px-3 py-2 border text-right w-32">Total Harga</th>
                        </tr>
                    </thead>
                    <tbody id="details_list">
                        {{-- Isi Detail dari JS --}}
                    </tbody>
                    {{-- BARIS TOTAL BIAYA (DIPINDAHKAN KE BAWAH TABEL) --}}
                    <tfoot>
                        <tr class="bg-blue-100 font-bold text-gray-800">
                            <td colspan="3" class="px-3 py-2 border-t border-gray-300 text-right">TOTAL BIAYA:</td>
                            <td colspan="1" class="px-3 py-2 border-t border-gray-300 text-right text-green-700" id="modal_total_gabungan"></td>
                        </tr>
                    </tfoot>
                </table>
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
    
    {{-- SCRIPT MODAL --}}
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const detailModal = document.getElementById('detailModal');
        const detailsList = document.getElementById('details_list');
        const modalTotalGabungan = document.getElementById('modal_total_gabungan');
        // NOTE: Menggunakan ID baru dari HTML
        const modalNoSpk = document.getElementById('modal_no_spk'); 
        const btnCetak = document.getElementById('btnCetak');

        // Base URLs
        const editBaseUrl = "{{ route('sparepart.edit', ['sparepart' => 'ITEM_ID']) }}";
        const destroyBaseUrl = "{{ route('sparepart.destroy', ['sparepart' => 'ITEM_ID']) }}";

        document.querySelectorAll('.btn-detail').forEach(btn => {
            btn.addEventListener('click', function () {
                const spkId = this.dataset.id;
                
                // Fetch data dari SpkController@show (GET /sparepart/{spkId})
                fetch(`/sparepart/${spkId}`) 
                    .then(res => {
                        if (!res.ok) {
                            throw new Error('Gagal mengambil data Sparepart. Status: ' + res.status);
                        }
                        return res.json();
                    })
                    .then(data => {
                        // PERBAIKAN: Mengisi No. SPK ke elemen baru di atas tabel
                        modalNoSpk.textContent = data.no_spk;
                        
                        modalTotalGabungan.textContent = data.total_gabungan;
                        detailsList.innerHTML = ''; // Bersihkan isi lama

                        // Memperbaiki Link Cetak
                        btnCetak.href = `{{ route('sparepart.report') }}?id_spk=${spkId}`;

                        data.details.forEach(item => {
                            // Cuma tampilkan data, tidak ada aksi edit/hapus di modal
                            const row = `
                                <tr>
                                    <td class="px-3 py-2 border-b">${item.nama_sparepart}</td>
                                    <td class="px-3 py-2 border-b text-center">${item.jumlah}</td>
                                    <td class="px-3 py-2 border-b text-right">${item.harga_satuan}</td>
                                    <td class="px-3 py-2 border-b text-right font-semibold">${item.total_harga}</td>
                                </tr>
                            `;
                            detailsList.innerHTML += row;
                        });

                        detailModal.classList.remove('hidden');
                    })
                    .catch(error => {
                        console.error('Error fetching sparepart details:', error);
                        alert('Gagal memuat detail sparepart. Cek console.');
                    });
            });
        });

        document.getElementById('closeModal').addEventListener('click', () => {
            detailModal.classList.add('hidden');
        });
    });
    </script>
</x-app-layout>