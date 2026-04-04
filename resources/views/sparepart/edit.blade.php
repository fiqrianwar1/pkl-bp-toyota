<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 flex items-center gap-2">
            <i class="fa-solid fa-file-pen text-green-600"></i>
            Edit Item Sparepart (SPK No. {{ $sparepart->spk->no_spk ?? 'N/A' }})
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl rounded-2xl p-8 border border-gray-100">
                
                <div class="flex items-center justify-between mb-6 border-b pb-3">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                        <i class="fa-solid fa-truck-ramp-box text-green-600"></i> Form Edit Item Sparepart
                    </h3>
                    <a href="{{ route('sparepart.index') }}" 
                       class="flex items-center text-sm bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg shadow transition">
                        <i class="fa-solid fa-arrow-left mr-2"></i> Kembali
                    </a>
                </div>

                {{-- Notifikasi Error --}}
                @if ($errors->any())
                    <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-6 border border-red-300">
                        <strong class="block mb-2"><i class="fa-solid fa-circle-exclamation"></i> Terjadi Kesalahan:</strong>
                        <ul class="list-disc px-6 text-sm space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('sparepart.update', $spk->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <h3 class="text-gray-800 font-semibold mb-2 border-b pb-2">Informasi Pemesanan</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                        
                        {{-- Field SPK (TIDAK BISA DIUBAH) --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">
                                <i class="fa-solid fa-file-signature mr-1 text-blue-500"></i> SPK Terkait
                            </label>
                            <input type="hidden" name="spk_id" value="{{ $spk->id }}">
                            <select class="w-full border-gray-300 rounded-xl shadow-sm bg-gray-100 cursor-not-allowed" disabled>
                                <option value="{{ $spk->id }}">{{ $spk->no_spk }} - ({{ $spk->customer->nama ?? 'N/A' }})</option>
                            </select>
                            @error('spk_id')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        {{-- Field Tgl Estimasi Datang --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">
                                <i class="fa-solid fa-calendar-check mr-1 text-blue-500"></i> Estimasi Datang
                            </label>
                            <input type="date" name="tgl_estimasi_datang"
                                   value="{{ old('tgl_estimasi_datang', $spareparts->first()->tgl_estimasi_datang) }}"
                                   class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-green-500 focus:border-green-500 transition">
                            @error('tgl_estimasi_datang')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Field Lokasi Simpan --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">
                                <i class="fa-solid fa-map-marker-alt mr-1 text-blue-500"></i> Lokasi Simpan
                            </label>
                            <input type="text" name="lokasi" 
                                   value="{{ old('lokasi', $spareparts->first()->lokasi) }}"
                                   class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-green-500 focus:border-green-500 transition" placeholder="Rak A3 / Gudang Belakang">
                            @error('lokasi')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Detail Sparepart (Dynamic Rows - LOOPING) --}}
                    <h3 class="text-gray-800 font-semibold mt-6 mb-2 border-b pb-2">Item Sparepart Dipesan</h3>
                    <div id="sparepart-container">
                        
                        {{-- LOOPING SEMUA ITEM SPAREPART DARI SPK INI --}}
                        @forelse ($spareparts as $index => $item)
                        <div class="grid grid-cols-12 gap-3 mb-3 sparepart-row p-4 border border-gray-200 rounded-lg bg-gray-50">
                            
                            {{-- Pilih Nama Sparepart (Kolom 1 - 4) --}}
                            <div class="col-span-4">
                                <label class="block text-gray-600 text-sm mb-1">Nama Sparepart / Panel</label>
                                <select name="nama_sparepart[]" class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-green-500 focus:border-green-500 transition sparepart-select">
                                    
                                    {{-- Item Aktif Saat Ini --}}
                                    <option value="{{ old('nama_sparepart.'.$index, $item->nama_sparepart) }}" selected data-harga="{{ $item->harga_satuan }}">
                                        {{ old('nama_sparepart.'.$index, $item->nama_sparepart) }} (Aktif)
                                    </option>

                                    <optgroup label="Sparepart Umum">
                                        @foreach($hargaSparepart as $nama => $harga)
                                            <option value="{{ $nama }}" data-harga="{{ $harga }}">{{ $nama }}</option>
                                        @endforeach
                                    </optgroup>
                                    <optgroup label="Panel Body (Custom)">
                                        @foreach($panels as $panel => $harga)
                                            <option value="{{ $panel }}" data-harga="{{ $harga }}">{{ $panel }} (Panel Body)</option>
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>

                            {{-- Jumlah (Kolom 5 - 6) --}}
                            <div class="col-span-2">
                                <label class="block text-gray-600 text-sm mb-1">Jumlah</label>
                                <input type="number" name="jumlah[]" class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-green-500 focus:border-green-500 transition jumlah-input" 
                                       value="{{ old('jumlah.'.$index, $item->jumlah) }}" min="1" required>
                            </div>

                            {{-- Harga Satuan (Kolom 7 - 9) --}}
                            <div class="col-span-3">
                                <label class="block text-gray-600 text-sm mb-1">Harga Satuan</label>
                                <input type="number" name="harga_satuan[]" class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-green-500 focus:border-green-500 transition harga-input" 
                                       value="{{ old('harga_satuan.'.$loop->index, $item->harga_satuan) }}" min="0">
                            </div>
                            
                            {{-- TOTAL HARGA & TOMBOL HAPUS (Kolom 10 - 12) --}}
                            <div class="col-span-3">
                                <label class="block text-gray-600 text-sm mb-1">Total Harga</label>
                                <div class="flex gap-2">
                                    {{-- Display Total --}}
                                    <input type="text" name="total_display[]" class="w-full border-gray-300 rounded-xl shadow-sm bg-gray-100 cursor-not-allowed text-green-700 font-bold total-display" 
                                           value="{{ $item->getTotalHargaRupiahAttribute() }}" readonly>
                                    
                                    {{-- Tombol Hapus Baris --}}
                                    <button type="button"
                                            class="remove-row bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-lg shadow transition flex items-center gap-1 text-sm whitespace-nowrap h-10">
                                        <i class="fa-solid fa-trash-can mr-1"></i> Hapus
                                    </button>
                                </div>
                            </div>
                            
                        </div>
                        @empty
                        <div class="grid grid-cols-12 gap-3 mb-3 sparepart-row p-4 border border-gray-200 rounded-lg bg-gray-50">
                            <div class="col-span-4"><label class="block text-gray-600 text-sm mb-1">Nama Sparepart / Panel</label><select name="nama_sparepart[]" class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-green-500 focus:border-green-500 transition sparepart-select"><option value="">-- Pilih Item --</option><optgroup label="Sparepart Umum"><option value="Oli Mesin 10W-40" data-harga="450000">Oli Mesin 10W-40</option></optgroup><optgroup label="Panel Body (Custom)"><option value="Bumper FRT" data-harga="850000">Bumper FRT (Panel Body)</option></optgroup></select></div>
                            <div class="col-span-2"><label class="block text-gray-600 text-sm mb-1">Jumlah</label><input type="number" name="jumlah[]" class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-green-500 focus:border-green-500 transition jumlah-input" value="1" min="1" required></div>
                            <div class="col-span-3"><label class="block text-gray-600 text-sm mb-1">Harga Satuan</label><input type="number" name="harga_satuan[]" class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-green-500 focus:border-green-500 transition harga-input" value="0" min="0"></div>
                            <div class="col-span-3"><label class="block text-gray-600 text-sm mb-1">Total Harga</label><div class="flex gap-2"><input type="text" name="total_display[]" class="w-full border-gray-300 rounded-xl shadow-sm bg-gray-100 cursor-not-allowed text-green-700 font-bold total-display" readonly><button type="button" class="remove-row bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-lg shadow transition flex items-center gap-1 text-sm whitespace-nowrap h-10"><i class="fa-solid fa-trash-can mr-1"></i> Hapus</button></div></div>
                        </div>
                        @endforelse

                    </div> {{-- /#sparepart-container --}}

                    <button type="button" id="add-row"
                        class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow transition">
                        <i class="fa-solid fa-square-plus mr-1"></i> Tambah Item
                    </button>

                    <div class="flex justify-end gap-3 pt-4 border-t mt-6">
                        <a href="{{ route('sparepart.index') }}" 
                           class="flex items-center gap-2 bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded-lg shadow transition">
                            <i class="fa-solid fa-xmark mr-2"></i> Batal
                        </a>
                        <button type="submit" 
                                class="flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-lg shadow transition">
                            <i class="fa-solid fa-floppy-disk mr-2"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Script Kalkulasi Harga --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const container = document.getElementById('sparepart-container');
            
            // Data list harga dari PHP (disuntikkan ke JS)
            const allPrices = {
                @foreach($allSpareparts as $name => $price)
                    "{{ $name }}": {{ $price }},
                @endforeach
            };

            function formatRupiah(angka) {
                // PERBAIKAN UTAMA UNTUK FORMAT RUPIAH
                if (typeof angka !== 'number') angka = parseInt(angka) || 0;
                if (angka < 0) angka = 0;
                
                const number_string = Math.round(angka).toString();
                let rupiah = number_string.replace(/[^,\d]/g, '');
                
                // Tambahkan titik sebagai pemisah ribuan
                const parts = rupiah.split('.');
                const integerPart = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                
                return 'Rp ' + integerPart;
            }

            function hitungTotal(row) {
                const hargaInput = row.querySelector('.harga-input');
                const jumlahInput = row.querySelector('.jumlah-input');
                const totalDisplayInput = row.querySelector('.total-display');
                
                // Ambil nilai numerik dari input
                const harga = parseFloat(hargaInput.value) || 0;
                const jumlah = parseInt(jumlahInput.value) || 1;
                const total = harga * jumlah;
                
                totalDisplayInput.value = formatRupiah(total);
            }

            function updateHargaDariSelect(row) {
                const selectNama = row.querySelector('.sparepart-select');
                const hargaInput = row.querySelector('.harga-input');
                
                const selectedValue = selectNama.value;
                let hargaSatuan = allPrices[selectedValue] || 0;
                
                // 1. Logika Penguncian Input
                if (hargaSatuan > 0) {
                    // Sparepart Umum / Panel dengan harga default -> Kunci input
                    hargaInput.value = hargaSatuan;
                    hargaInput.readOnly = true;
                    hargaInput.classList.add('bg-gray-100');
                } else {
                    // Item Aktif / Custom -> Buka input
                    hargaInput.readOnly = false;
                    hargaInput.classList.remove('bg-gray-100');
                    
                    // Jika harga default 0, kosongkan agar user bisa input harga custom
                    if (parseFloat(hargaInput.value) === 0 || hargaInput.value === '') {
                        hargaInput.value = '';
                    }
                }
                
                hitungTotal(row);
            }

            // --- EVENT LISTENERS & INIT ---
            
            // Event Delegasi untuk Change & Input (Dipanggil untuk semua rows)
            container.addEventListener('change', function(e) {
                const row = e.target.closest('.sparepart-row');
                if (e.target.classList.contains('sparepart-select')) {
                    updateHargaDariSelect(row);
                }
            });

            container.addEventListener('input', function(e) {
                const row = e.target.closest('.sparepart-row');
                if (e.target.classList.contains('jumlah-input') || e.target.classList.contains('harga-input')) {
                    // Pastikan jumlah minimal 1
                    if (e.target.classList.contains('jumlah-input') && (parseInt(e.target.value) < 1 || e.target.value === '')) {
                        e.target.value = 1;
                    }
                    hitungTotal(row);
                }
            });

            // Logika Tambah Baris
            document.getElementById('add-row').addEventListener('click', () => {
                const originalRow = container.querySelector('.sparepart-row');
                if (originalRow) {
                    const newRow = originalRow.cloneNode(true);
                    
                    // Reset nilai input/select ke nilai default
                    newRow.querySelectorAll('input, select').forEach(el => {
                        el.value = '';
                        el.classList.remove('bg-gray-100');
                        if(el.tagName === 'SELECT') el.selectedIndex = 0;
                        if(el.name === 'jumlah[]') el.value = '1';
                        if(el.name === 'harga_satuan[]') {
                            el.value = 0;
                            el.readOnly = false;
                        }
                    });
                    
                    // Re-attach listeners untuk baris baru
                    newRow.querySelector('.sparepart-select').addEventListener('change', () => updateHargaDariSelect(newRow));
                    newRow.querySelector('.jumlah-input').addEventListener('input', () => hitungTotal(newRow));
                    newRow.querySelector('.harga-input').addEventListener('input', () => hitungTotal(newRow));
                    
                    container.appendChild(newRow);
                    hitungTotal(newRow); // Hitung total untuk baris baru (default 0)
                }
            });

            // Logika Hapus Baris
            container.addEventListener('click', function (e) {
                if (e.target.classList.contains('remove-row') || e.target.closest('.remove-row')) {
                    const row = e.target.closest('.sparepart-row');
                    if (document.querySelectorAll('.sparepart-row').length > 1) {
                        row.remove();
                    } else {
                        alert('Minimal harus ada satu item sparepart!');
                    }
                }
            });
            
            // Init: Panggil hitungTotal untuk semua baris yang ada saat dimuat
            document.querySelectorAll('.sparepart-row').forEach(row => {
                const select = row.querySelector('.sparepart-select');
                // Panggil updateHargaDariSelect untuk set readOnly state dan hitung total awal
                if (select.value !== '') {
                    updateHargaDariSelect(row);
                } else {
                    hitungTotal(row);
                }
                
                // Pastikan listeners terpasang untuk baris yang di-loop PHP
                row.querySelector('.sparepart-select').addEventListener('change', () => updateHargaDariSelect(row));
                row.querySelector('.jumlah-input').addEventListener('input', () => hitungTotal(row));
                row.querySelector('.harga-input').addEventListener('input', () => hitungTotal(row));
            });
        });
    </script>
</x-app-layout>