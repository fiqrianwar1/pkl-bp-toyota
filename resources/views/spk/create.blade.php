<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 flex items-center gap-2">
            <i class="fa-solid fa-file-circle-plus text-blue-600"></i>
            Tambah SPK Baru
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border border-gray-200 rounded-2xl shadow-lg p-8 transition hover:shadow-xl">

                <div class="mb-6 border-b pb-4 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                        <i class="fa-solid fa-sheet-plastic text-blue-600"></i> Form Data SPK
                    </h3>
                    <span class="text-xs bg-blue-100 text-blue-600 px-3 py-1 rounded-full font-medium">
                        SPK No. {{ $no_spk }}
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

                <form method="POST" action="{{ route('spk.store') }}" class="space-y-6">
                    @csrf

                    {{-- Info Dasar --}}
                    <h3 class="text-gray-800 font-semibold mb-2 border-b pb-2">Data Customer & Kendaraan</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        
                        {{-- Field No SPK --}}
                        <div>
                            <label for="no_spk" class="block text-sm font-semibold text-gray-700 mb-1">
                                <i class="fa-solid fa-hashtag mr-1 text-blue-600"></i> No. SPK
                            </label>
                            <input type="text" name="no_spk" id="no_spk" value="{{ $no_spk }}" readonly
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-600 focus:border-blue-600 transition bg-gray-100 cursor-not-allowed">
                        </div>

                        {{-- Field Customer --}}
                        <div>
                            <label for="customer_id" class="block text-sm font-semibold text-gray-700 mb-1">
                                <i class="fa-solid fa-user-tag mr-1 text-blue-600"></i> Customer
                            </label>
                            <select name="customer_id" id="customer_id" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-600 focus:border-blue-600 transition" required>
                                <option value="">-- Pilih Customer --</option>
                                @foreach ($customers as $c)
                                    <option value="{{ $c->id }}" {{ old('customer_id') == $c->id ? 'selected' : '' }}>
                                        {{ $c->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('customer_id')
                                <p class="text-sm text-red-600 mt-1"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Field Model --}}
                        <div>
                            <label for="model" class="block text-sm font-semibold text-gray-700 mb-1">
                                <i class="fa-solid fa-car-side mr-1 text-blue-600"></i> Model
                            </label>
                            <input type="text" name="model" id="model" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-600 focus:border-blue-600 transition"
                                   value="{{ old('model') }}" required>
                            @error('model')
                                <p class="text-sm text-red-600 mt-1"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Field No Polisi --}}
                        <div>
                            <label for="no_polisi" class="block text-sm font-semibold text-gray-700 mb-1">
                                <i class="fa-solid fa-id-badge mr-1 text-blue-600"></i> No. Polisi
                            </label>
                            <input type="text" name="no_polisi" id="no_polisi" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-600 focus:border-blue-600 transition"
                                   value="{{ old('no_polisi') }}" required>
                            @error('no_polisi')
                                <p class="text-sm text-red-600 mt-1"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Field Tanggal Masuk --}}
                        <div>
                            <label for="tgl_masuk" class="block text-sm font-semibold text-gray-700 mb-1">
                                <i class="fa-solid fa-calendar-plus mr-1 text-blue-600"></i> Tanggal Masuk
                            </label>
                            <input type="date" name="tgl_masuk" id="tgl_masuk" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-600 focus:border-blue-600 transition"
                                   value="{{ old('tgl_masuk', date('Y-m-d')) }}" required>
                            @error('tgl_masuk')
                                <p class="text-sm text-red-600 mt-1"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Field Estimasi Selesai --}}
                        <div>
                            <label for="estimasi_selesai" class="block text-sm font-semibold text-gray-700 mb-1">
                                <i class="fa-solid fa-hourglass-half mr-1 text-blue-600"></i> Estimasi Selesai
                            </label>
                            <input type="date" name="estimasi_selesai" id="estimasi_selesai" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-600 focus:border-blue-600 transition"
                                   value="{{ old('estimasi_selesai') }}">
                            @error('estimasi_selesai')
                                <p class="text-sm text-red-600 mt-1"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Panel dan Jenis Pekerjaan (Dynamic Rows) --}}
                    <h3 class="text-gray-800 font-semibold mt-6 mb-2 border-b pb-2">Detail Pekerjaan Panel</h3>
                    <div id="panel-container">
                        {{-- Baris Template (Wajib ada satu baris) --}}
                        <div class="grid grid-cols-12 gap-4 panel-row mb-4 p-4 border border-gray-200 rounded-lg bg-gray-50">
                            
                            {{-- Nama Panel --}}
                            <div class="col-span-4">
                                <label class="block text-gray-600 text-sm mb-1">Nama Panel</label>
                                <select name="nama_panel[]" class="w-full border-gray-300 rounded-lg shadow-sm" required>
                                    <option value="">-- Pilih Panel --</option>
                                    @foreach ($panels as $p)
                                        <option value="{{ $p }}" {{ old('nama_panel.0') == $p ? 'selected' : '' }}>{{ $p }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Jenis Pekerjaan (Tambahkan class 'jenis-select' lagi!) --}}
                            <div class="col-span-3">
                                <label class="block text-gray-600 text-sm mb-1">Jenis Pekerjaan</label>
                                <select name="jenis_pekerjaan[]" class="w-full border-gray-300 rounded-lg shadow-sm jenis-select" required>
                                    <option value="">-- Pilih Jenis --</option>
                                    <option value="KC" {{ old('jenis_pekerjaan.0') == 'KC' ? 'selected' : '' }}>Ketok Cat</option>
                                    <option value="GC" {{ old('jenis_pekerjaan.0') == 'GC' ? 'selected' : '' }}>Ganti Cat</option>
                                    <option value="SC" {{ old('jenis_pekerjaan.0') == 'SC' ? 'selected' : '' }}>Spesial Cat</option>
                                </select>
                            </div>

                            {{-- Biaya (Tambahkan class 'biaya-input' lagi!) --}}
                            <div class="col-span-3">
                                <label class="block text-gray-600 text-sm mb-1">Biaya (Rp)</label>
                                <input type="number" name="biaya[]" class="w-full border-gray-300 rounded-lg shadow-sm biaya-input"
                                        value="{{ old('biaya.0') }}" min="0" required>
                            </div>

                            {{-- Tombol Hapus --}}
                            <div class="col-span-2 flex items-end">
                                <button type="button" class="remove-row bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-lg shadow transition flex items-center justify-center w-full h-10">
                                    <i class="fa-solid fa-trash-can mr-1"></i> Hapus
                                </button>
                            </div>
                        </div>

                        {{-- Jika ada data old, tambahkan baris tambahan (untuk error validasi) --}}
                        @if(is_array(old('nama_panel')) && count(old('nama_panel')) > 1)
                            @for($i = 1; $i < count(old('nama_panel')); $i++)
                                <div class="grid grid-cols-12 gap-4 panel-row mb-4 p-4 border border-gray-200 rounded-lg bg-gray-50">
                                    {{-- Nama Panel --}}
                                    <div class="col-span-4">
                                        <label class="block text-gray-600 text-sm mb-1">Nama Panel</label>
                                        <select name="nama_panel[]" class="w-full border-gray-300 rounded-lg shadow-sm">
                                            <option value="">-- Pilih Panel --</option>
                                            @foreach ($panels as $p)
                                                <option value="{{ $p }}" {{ old('nama_panel.'.$i) == $p ? 'selected' : '' }}>{{ $p }}</option>
                                            @endforeach
                                        </select>
                                    </div>
        
                                    {{-- Jenis Pekerjaan (Tambahkan class 'jenis-select' lagi!) --}}
                                    <div class="col-span-3">
                                        <label class="block text-gray-600 text-sm mb-1">Jenis Pekerjaan</label>
                                        <select name="jenis_pekerjaan[]" class="w-full border-gray-300 rounded-lg shadow-sm jenis-select">
                                            <option value="">-- Pilih Jenis --</option>
                                            <option value="KC" {{ old('jenis_pekerjaan.'.$i) == 'KC' ? 'selected' : '' }}>Ketok Cat</option>
                                            <option value="GC" {{ old('jenis_pekerjaan.'.$i) == 'GC' ? 'selected' : '' }}>Ganti Cat</option>
                                            <option value="SC" {{ old('jenis_pekerjaan.'.$i) == 'SC' ? 'selected' : '' }}>Spesial Cat</option>
                                        </select>
                                    </div>
        
                                    {{-- Biaya (Tambahkan class 'biaya-input' lagi!) --}}
                                    <div class="col-span-3">
                                        <label class="block text-gray-600 text-sm mb-1">Biaya (Rp)</label>
                                        <input type="number" name="biaya[]" class="w-full border-gray-300 rounded-lg shadow-sm biaya-input"
                                                value="{{ old('biaya.'.$i) }}" min="0" required>
                                    </div>
        
                                    {{-- Tombol Hapus --}}
                                    <div class="col-span-2 flex items-end">
                                        <button type="button" class="remove-row bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-lg shadow transition flex items-center justify-center w-full h-10">
                                            <i class="fa-solid fa-trash-can mr-1"></i> Hapus
                                        </button>
                                    </div>
                                </div>
                            @endfor
                        @endif

                    </div>

                    {{-- Tombol Tambah Panel --}}
                    <div class="mt-3 mb-5">
                        <button type="button" id="add-row" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow transition">
                            <i class="fa-solid fa-square-plus mr-1"></i> Tambah Panel
                        </button>
                    </div>
                    @error('nama_panel')
                        <p class="text-sm text-red-600 mt-1"><i class="fa-solid fa-circle-exclamation mr-1"></i>Detail Panel wajib diisi.</p>
                    @enderror


                    {{-- Catatan & Status --}}
                    <h3 class="text-gray-800 font-semibold mt-6 mb-2 border-b pb-2">Status & Catatan</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        
                        <div>
                            <label for="status" class="block text-sm font-semibold text-gray-700 mb-1">
                                <i class="fa-solid fa-list-check mr-1 text-blue-600"></i> Status
                            </label>
                            <select name="status" id="status" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-600 focus:border-blue-600 transition">
                                <option value="proses" {{ old('status', 'proses') == 'proses' ? 'selected' : '' }}>Proses</option>
                                <option value="selesai" {{ old('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="batal" {{ old('status') == 'batal' ? 'selected' : '' }}>Batal</option>
                            </select>
                        </div>

                        <div>
                            <label for="catatan" class="block text-sm font-semibold text-gray-700 mb-1">
                                <i class="fa-solid fa-note-sticky mr-1 text-blue-600"></i> Catatan
                            </label>
                            <textarea name="catatan" id="catatan" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-600 focus:border-blue-600 transition" rows="2">{{ old('catatan') }}</textarea>
                            @error('catatan')
                                <p class="text-sm text-red-600 mt-1"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Tombol Simpan & Batal --}}
                    <div class="flex justify-end gap-3 pt-4 border-t mt-6">
                        <a href="{{ route('spk.index') }}"
                            class="flex items-center gap-2 bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded-lg shadow transition">
                            <i class="fa-solid fa-arrow-left"></i> Batal
                        </a>
                        <button type="submit"
                            class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow transition">
                            <i class="fa-solid fa-floppy-disk"></i> Simpan SPK
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Script Dynamic Rows (Logika Biaya Diperbaiki) --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Data Harga untuk biaya otomatis
            const hargaDasar = { KC: 550000, GC: 700000, SC: 850000 }; 

            function updateBiaya(row) {
                const jenis = row.querySelector('.jenis-select').value;
                const biayaInput = row.querySelector('.biaya-input');
                
                // Set harga otomatis berdasarkan jenis
                biayaInput.value = jenis && hargaDasar[jenis] !== undefined ? hargaDasar[jenis] : 0;
                
                // Pastikan biaya minimal 0
                if (parseInt(biayaInput.value) < 0 || biayaInput.value === '') {
                    biayaInput.value = 0;
                }
            }
            
            // Event Delegasi: Memastikan harga terupdate saat 'Jenis Pekerjaan' diubah
            document.getElementById('panel-container').addEventListener('change', function(e) {
                if (e.target.classList.contains('jenis-select')) {
                    const row = e.target.closest('.panel-row');
                    updateBiaya(row);
                }
            });

            // Logika Tambah Baris
            document.getElementById('add-row').addEventListener('click', () => {
                const container = document.getElementById('panel-container');
                const originalRow = container.querySelector('.panel-row');
                
                if (originalRow) {
                    const newRow = originalRow.cloneNode(true);
                    
                    // Reset nilai input/select di baris baru
                    newRow.querySelectorAll('input, select').forEach(el => {
                        if(el.tagName === 'SELECT') {
                            el.selectedIndex = 0; // Reset select ke opsi pertama
                        } else {
                            el.value = ''; // Kosongkan input
                        }
                        if (el.classList.contains('biaya-input')) {
                            el.value = '0'; // Biaya default 0
                        }
                    });
                    container.appendChild(newRow);
                }
            });

            // Logika Hapus Baris
            document.addEventListener('click', function (e) {
                if (e.target.classList.contains('remove-row') || e.target.closest('.remove-row')) {
                    const button = e.target.closest('.remove-row');
                    const row = button.closest('.panel-row');
                    // Hanya hapus jika baris > 1
                    if (document.querySelectorAll('.panel-row').length > 1) {
                        row.remove();
                    } else {
                        alert('Minimal harus ada satu baris panel!');
                    }
                }
            });
            
            // Inisialisasi: Update biaya untuk baris yang ada saat halaman dimuat (untuk old data)
             document.querySelectorAll('.panel-row').forEach(row => {
                updateBiaya(row);
            });
        });
    </script>
</x-app-layout>