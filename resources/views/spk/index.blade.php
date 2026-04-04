<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 flex items-center gap-2">
            <i class="fa-solid fa-file-signature text-blue-600"></i>
            {{ ('Daftar SPK') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-2xl p-6 border border-gray-100">

                <div class="flex flex-col sm:flex-row justify-between items-center mb-5 gap-3">
                    <a href="{{ route('spk.create') }}"
                        class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow transition duration-200">
                        <i class="fa-solid fa-plus mr-2"></i> Tambah SPK
                    </a>

                    <form method="GET" action="{{ route('spk.index') }}" class="flex gap-2 items-center">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari no SPK atau nama customer..."
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
                                <th class="px-4 py-3 text-left">No. SPK</th>
                                <th class="px-4 py-3 text-left">Customer</th>
                                <th class="px-4 py-3 text-left">Model</th>
                                <th class="px-4 py-3 text-left">No. Polisi</th>
                                <th class="px-4 py-3 text-left">Tanggal Masuk</th>
                                <th class="px-4 py-3 text-left">Status</th>
                                <th class="px-4 py-3 text-center w-40">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($spks as $spk)
                                <tr class="hover:bg-blue-50 transition">
                                    <td class="px-4 py-2 text-gray-700">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-2 font-semibold text-gray-800">{{ $spk->no_spk }}</td>
                                    <td class="px-4 py-2">{{ $spk->customer->nama ?? '-' }}</td>
                                    <td class="px-4 py-2">{{ $spk->model }}</td>
                                    <td class="px-4 py-2">{{ $spk->no_polisi }}</td>
                                    <td class="px-4 py-2">{{ \Carbon\Carbon::parse($spk->tgl_masuk)->translatedFormat('d M Y') }}</td>
                                    <td class="px-4 py-2">
                                        <span class="px-2 py-1 rounded text-white text-xs
                                            @if ($spk->status == 'selesai') bg-green-600
                                            @elseif ($spk->status == 'batal') bg-red-600
                                            @else bg-yellow-500 @endif">
                                            {{ ucfirst($spk->status) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-2 text-center w-40">
                                        <div class="flex justify-center gap-2">
                                            
                                            <button data-id="{{ $spk->id }}"
                                                class="btn-detail bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded-md text-xs shadow transition flex items-center gap-1">
                                                <i class="fa-solid fa-circle-info"></i> Detail
                                            </button>

                                            <a href="{{ route('spk.edit', $spk->id) }}"
                                               class="bg-green-600 hover:bg-green-700 text-white px-3 py-1.5 rounded-md text-xs shadow transition flex items-center gap-1">
                                                <i class="fa-solid fa-pen-to-square"></i> Edit
                                            </a>
                                            
                                            <form action="{{ route('spk.destroy', $spk->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded-md text-xs shadow transition flex items-center gap-1">
                                                    <i class="fa-solid fa-trash"></i> Hapus
                                                </button>
                                            </form>
                                            
                                            <a href="{{ route('spk.report', $spk->id) }}" target="_blank"
                                               class="bg-gray-700 hover:bg-gray-800 text-white px-3 py-1.5 rounded-md text-xs shadow transition flex items-center gap-1">
                                                <i class="fa-solid fa-print"></i> Cetak
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-4 py-3 text-center text-gray-500 italic">
                                        <i class="fa-solid fa-circle-info mr-1"></i> Belum ada data SPK
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $spks->links() }}
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL DETAIL (DIUBAH STRUKTUR HTML SESUAI PERMINTAAN) --}}
    <div id="detailModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-3xl p-6 relative animate-fadeIn">
            <h2 class="text-lg font-semibold mb-4 border-b pb-2 text-gray-700 flex items-center gap-2">
                <i class="fa-solid fa-circle-info text-blue-600"></i> Detail SPK: <span id="modal_no_spk_header" class="ml-2 font-bold text-gray-900"></span>
            </h2>
            
            <div id="modal_details_body" class="overflow-y-auto max-h-96">
                
                {{-- TABEL DETAIL (STRUKTUR PALING AWAL) --}}
                <table class="w-full text-sm border border-gray-200 rounded-lg overflow-hidden">
                    <tbody>
                        <tr><th class="border px-2 py-1 w-1/3 bg-gray-50">No SPK</th><td class="border px-2 py-1" id="d_no_spk"></td></tr>
                        <tr><th class="border px-2 py-1 bg-gray-50">Customer</th><td class="border px-2 py-1" id="d_customer"></td></tr>
                        <tr><th class="border px-2 py-1 bg-gray-50">Model</th><td class="border px-2 py-1" id="d_model"></td></tr>
                        <tr><th class="border px-2 py-1 bg-gray-50">No Polisi</th><td class="border px-2 py-1" id="d_no_polisi"></td></tr>
                        <tr><th class="border px-2 py-1 bg-gray-50">Tanggal Masuk</th><td class="border px-2 py-1" id="d_tgl_masuk"></td></tr>
                        <tr><th class="border px-2 py-1 bg-gray-50">Estimasi Selesai</th><td class="border px-2 py-1" id="d_estimasi_selesai"></td></tr>
                        <tr><th class="border px-2 py-1 bg-gray-50">Status</th><td class="border px-2 py-1" id="d_status"></td></tr>
                        
                        {{-- DETAIL PANEL (Gabungan) --}}
                        <tr><th class="border px-2 py-1 bg-gray-50">Nama Panel</th><td class="border px-2 py-1" id="d_nama_panel"></td></tr>
                        <tr><th class="border px-2 py-1 bg-gray-50">Jenis Pekerjaan</th><td class="border px-2 py-1" id="d_jenis_pekerjaan"></td></tr>
                        <tr><th class="border px-2 py-1 bg-gray-50">Biaya (Per Panel)</th><td class="border px-2 py-1" id="d_biaya"></td></tr> 
                        
                        <tr><th class="border px-2 py-1 bg-gray-50">Catatan</th><td class="border px-2 py-1" id="d_catatan"></td></tr>
                        
                        {{-- PERMINTAAN: TOTAL BIAYA DIPINDAH KE BAWAH CATATAN --}}
                        <tr><th class="border px-2 py-1 bg-blue-100 font-bold">TOTAL BIAYA</th><td class="border px-2 py-1 bg-blue-100 font-bold" id="d_total_biaya"></td></tr>
                        
                    </tbody>
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

    {{-- Deklarasi URL Dasar di PHP/Blade --}}
    <script>
        const baseReportUrl = "{{ route('spk.report', ['spk' => 'PLACEHOLDER']) }}"; 
    </script>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const detailModal = document.getElementById('detailModal');
        const modalNoSpkHeader = document.getElementById('modal_no_spk_header');
        
        document.querySelectorAll('.btn-detail').forEach(btn => {
            btn.addEventListener('click', function () {
                const id = this.dataset.id;
                
                // Fetch data dari SpkController@show (GET /spk/{id})
                fetch(`/spk/${id}`)
                    .then(res => {
                        if (!res.ok) {
                            throw new Error('Server response was not OK: ' + res.status);
                        }
                        return res.json();
                    })
                    .then(data => {
                        // Mengisi Header
                        modalNoSpkHeader.textContent = data.no_spk;
                        
                        // Mengisi Data SPK Utama
                        document.getElementById('d_no_spk').textContent = data.no_spk;
                        document.getElementById('d_customer').textContent = data.customer;
                        document.getElementById('d_model').textContent = data.model;
                        document.getElementById('d_no_polisi').textContent = data.no_polisi;
                        document.getElementById('d_tgl_masuk').textContent = data.tgl_masuk;
                        document.getElementById('d_estimasi_selesai').textContent = data.estimasi_selesai;
                        document.getElementById('d_status').textContent = data.status;
                        document.getElementById('d_catatan').textContent = data.catatan || '-'; 
                        
                        // Mengisi Detail Panel (Menggunakan innerHTML karena controller mengirim data dengan tag <br>)
                        document.getElementById('d_nama_panel').innerHTML = data.nama_panel || '-';
                        document.getElementById('d_jenis_pekerjaan').innerHTML = data.jenis_pekerjaan || '-';
                        document.getElementById('d_biaya').innerHTML = data.biaya; // Biaya per panel
                        
                        // Mengisi Total Biaya (Dipindahkan ke bawah Catatan)
                        document.getElementById('d_total_biaya').textContent = data.total_biaya; 
                        
                        // Memperbaiki Link Cetak
                        document.getElementById('btnCetak').href = baseReportUrl.replace('PLACEHOLDER', id);

                        // Tampilkan modal
                        detailModal.classList.remove('hidden');
                    })
                    .catch(error => {
                        console.error('Error saat memuat detail (Fetch Gagal atau JSON Error):', error);
                        alert('Gagal memuat detail SPK. Cek console browser.');
                    });
            });
        });

        document.getElementById('closeModal').addEventListener('click', () => {
            document.getElementById('detailModal').classList.add('hidden');
        });
    });
    </script>
</x-app-layout>