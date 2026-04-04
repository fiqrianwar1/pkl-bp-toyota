<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 flex items-center gap-2">
            <i class="fa-solid fa-cart-plus text-blue-600"></i>
            Tambah Data Sparepart
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border border-gray-200 rounded-2xl shadow-lg p-8 transition hover:shadow-xl">
                
                <div class="mb-6 border-b pb-4 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                        <i class="fa-solid fa-truck-ramp-box text-blue-600"></i> Form Pemesanan Sparepart
                    </h3>
                    <span class="text-xs bg-blue-100 text-blue-600 px-3 py-1 rounded-full font-medium">
                        Item Baru
                    </span>
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

                <form method="POST" action="{{ route('sparepart.store') }}" class="space-y-6">
                    @csrf

                    {{-- Data Pemesanan --}}
                    <h3 class="text-gray-800 font-semibold mb-2 border-b pb-2">Data Pemesanan</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                        
                        {{-- Field SPK --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">
                                <i class="fa-solid fa-file-signature mr-1 text-blue-600"></i> SPK Terkait
                            </label>
                            <select name="spk_id" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-600 focus:border-blue-600 transition" required>
                                <option value="">-- Pilih No. SPK --</option>
                                @foreach ($spks as $spk)
                                    <option value="{{ $spk->id }}" {{ old('spk_id') == $spk->id ? 'selected' : '' }}>
                                        {{ $spk->no_spk }} - ({{ $spk->customer->nama ?? 'No Customer' }})
                                    </option>
                                @endforeach
                            </select>
                            @error('spk_id')
                                <p class="text-sm text-red-600 mt-1"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>
                        
                        {{-- Field Tgl Estimasi Datang --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">
                                <i class="fa-solid fa-calendar-check mr-1 text-blue-600"></i> Estimasi Datang
                            </label>
                            <input type="date" name="tgl_estimasi_datang" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-600 focus:border-blue-600 transition"
                                   value="{{ old('tgl_estimasi_datang') }}">
                            @error('tgl_estimasi_datang')
                                <p class="text-sm text-red-600 mt-1"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Field Lokasi Simpan --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">
                                <i class="fa-solid fa-location-dot mr-1 text-blue-600"></i> Lokasi Simpan
                            </label>
                            <input type="text" name="lokasi" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-600 focus:border-blue-600 transition"
                                   value="{{ old('lokasi') }}" placeholder="Rak A3 / Gudang Belakang">
                            @error('lokasi')
                                <p class="text-sm text-red-600 mt-1"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Detail Sparepart (Dynamic Rows) --}}
                    <h3 class="text-gray-800 font-semibold mt-6 mb-2 border-b pb-2">Item Sparepart Dipesan</h3>
                    <div id="sparepart-container">
                        
                        {{-- TEMPLATE ROW SPAREPART --}}
                        {{-- GRID 12 KOLOM: 4 (Nama) + 1.5 (Jumlah) + 3 (Harga Satuan) + 2.5 (Total Harga/Hapus) --}}
                        <div class="grid grid-cols-12 gap-3 mb-3 sparepart-row p-4 border border-gray-200 rounded-lg bg-gray-50">
                            
                            {{-- Pilih Nama Sparepart (Kolom 1 - 4) --}}
                            <div class="col-span-4">
                                <label class="block text-gray-600 text-sm mb-1">Nama Sparepart / Panel</label>
                                <select name="nama_sparepart[]" class="w-full border rounded px-3 py-2 sparepart-select">
                                    <option value="">-- Pilih Item --</option>
                                    <optgroup label="Sparepart Umum">
                                        @foreach ($hargaSparepart as $nama => $harga)
                                            <option value="{{ $nama }}" data-harga="{{ $harga }}">{{ $nama }}</option>
                                        @endforeach
                                    </optgroup>
                                    <optgroup label="Panel Body (Custom)">
                                        @foreach ($panels as $panel => $harga)
                                            <option value="{{ $panel }}" data-harga="{{ $harga }}">{{ $panel }} (Panel Body)</option>
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>

                            {{-- Jumlah (Kolom 5 - 6) --}}
                            <div class="col-span-2">
                                <label class="block text-gray-600 text-sm mb-1">Jumlah</label>
                                <input type="number" name="jumlah[]" class="w-full border rounded px-3 py-2 jumlah-input" value="1" min="1" required>
                            </div>

                            {{-- Harga Satuan (Kolom 7 - 9) --}}
                            <div class="col-span-3">
                                <label class="block text-gray-600 text-sm mb-1">Harga Satuan</label>
                                <input type="number" name="harga_satuan[]" class="w-full border rounded px-3 py-2 harga-input calculable" value="0" min="0">
                            </div>
                            
                            {{-- TOTAL HARGA & TOMBOL HAPUS (Kolom 10 - 12) --}}
                            <div class="col-span-3">
                                <label class="block text-gray-600 text-sm mb-1">Total Harga</label>
                                <div class="flex gap-2">
                                    {{-- Display Total --}}
                                    <input type="text" name="total_display[]" class="w-full border rounded px-3 py-2 total-display bg-gray-100" readonly>
                                    
                                    {{-- Tombol Hapus --}}
                                    <button type="button"
                                            class="remove-row bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded flex items-center gap-1 shadow transition text-sm whitespace-nowrap h-10">
                                        <i class="fa-solid fa-trash-can"></i> Hapus
                                    </button>
                                </div>
                                {{-- Input tersembunyi untuk menyimpan nilai total angka (jika diperlukan untuk backend) --}}
                                <input type="hidden" name="total_harga_numeric[]" class="total-numeric-input">
                            </div>
                            
                        </div>

                    </div> {{-- /#sparepart-container --}}

                    {{-- Tombol Tambah Item --}}
                    <button type="button" id="add-row"
                        class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow transition">
                        <i class="fa-solid fa-square-plus mr-1"></i> Tambah Item
                    </button>

                    {{-- Tombol Simpan --}}
                    <div class="flex justify-end gap-3 pt-4 border-t mt-6">
                        <a href="{{ route('sparepart.index') }}"
                            class="flex items-center gap-2 bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded-lg shadow transition">
                            <i class="fa-solid fa-arrow-left"></i> Batal
                        </a>
                        <button type="submit"
                            class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow transition">
                            <i class="fa-solid fa-floppy-disk"></i> Simpan Sparepart
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Script Dynamic Rows & Kalkulasi Harga --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const container = document.getElementById('sparepart-container');
            
            // --- Kalkulasi Harga Total On-The-Fly ---
            
            function formatRupiah(angka) {
                if (typeof angka !== 'number') angka = parseInt(angka) || 0;
                if (angka < 0) angka = 0;
                const format = angka.toString().split('').reverse().join('');
                const rupiah = format.match(/\d{1,3}/g);
                return 'Rp ' + rupiah.join('.').split('').reverse().join('');
            }
            
            function calculateTotal(row) {
                // Ambil nilai dari input Harga Satuan dan Jumlah
                const hargaInput = row.querySelector('.harga-input');
                const jumlahInput = row.querySelector('.jumlah-input');
                const totalDisplayInput = row.querySelector('.total-display');
                
                const harga = parseFloat(hargaInput.value) || 0;
                const jumlah = parseInt(jumlahInput.value) || 0;
                
                const total = harga * jumlah;
                
                // Tampilkan total yang diformat
                totalDisplayInput.value = formatRupiah(total);

                // Jika Anda menggunakan input tersembunyi untuk menyimpan nilai numerik total:
                // row.querySelector('.total-numeric-input').value = total;
            }

            function updateHarga(row) {
                const select = row.querySelector('.sparepart-select');
                const hargaInput = row.querySelector('.harga-input');
                
                const selectedOption = select.options[select.selectedIndex];
                let hargaSatuan = 0;
                
                if (selectedOption && selectedOption.dataset.harga) {
                     hargaSatuan = parseFloat(selectedOption.dataset.harga) || 0;
                } 
                
                if (hargaSatuan > 0) {
                    hargaInput.value = hargaSatuan;
                    hargaInput.readOnly = true;
                    hargaInput.classList.add('bg-gray-100');
                } else {
                    hargaInput.value = ''; 
                    hargaInput.readOnly = false;
                    hargaInput.classList.remove('bg-gray-100');
                }
                
                if (hargaInput.value === '') {
                     hargaInput.value = 0;
                }
                
                calculateTotal(row);
            }
            
            // --- EVENT LISTENERS ---
            
            // Event Delegasi: Mengontrol Perubahan Jumlah, Harga Satuan, dan Pilihan Sparepart
            container.addEventListener('change', function(e) {
                const row = e.target.closest('.sparepart-row');
                if (e.target.classList.contains('sparepart-select')) {
                    updateHarga(row);
                }
            });

            container.addEventListener('input', function(e) {
                const row = e.target.closest('.sparepart-row');
                if (e.target.classList.contains('jumlah-input')) {
                    if (parseInt(e.target.value) < 1 || e.target.value === '') {
                        e.target.value = 1;
                    }
                    calculateTotal(row);
                } else if (e.target.classList.contains('harga-input')) {
                    calculateTotal(row);
                }
            });

            // Tambah Baris
            document.getElementById('add-row').addEventListener('click', () => {
                const originalRow = container.querySelector('.sparepart-row');
                if (originalRow) {
                    const newRow = originalRow.cloneNode(true);
                    
                    // Reset semua input/select ke nilai default
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
                    
                    container.appendChild(newRow);
                    // Init harga untuk baris baru (agar harga sparepart umum langsung muncul)
                    updateHarga(newRow); 
                }
            });
            
            // Hapus Baris
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
            
            // Init: Panggil updateHarga untuk semua baris yang ada saat dimuat
            document.querySelectorAll('.sparepart-row').forEach(row => {
                if (row.querySelector('.sparepart-select').value !== '') {
                    updateHarga(row);
                } else {
                    calculateTotal(row); // Pastikan total dihitung untuk baris default
                }
            });
        });
    </script>
</x-app-layout>