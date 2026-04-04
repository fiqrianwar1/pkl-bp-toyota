<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 flex items-center gap-2">
            {{-- Menggunakan ikon Edit SPK --}}
            <i class="fa-solid fa-file-pen text-green-600"></i>
            Edit SPK No. {{ $spk->no_spk }}
        </h2>
    </x-slot>

    <div class="py-8">
        {{-- Style container disamakan dengan Edit Customer --}}
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl rounded-2xl p-8 border border-gray-100">
                
                <div class="flex items-center justify-between mb-6 border-b pb-3">
                    <h3 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                        {{-- Judul Form --}}
                        <i class="fa-solid fa-sheet-plastic text-green-600"></i>
                        Form Edit SPK
                    </h3>
                    {{-- Tombol Kembali disamakan dengan style Edit Customer --}}
                    <a href="{{ route('spk.index') }}" 
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

                <form method="POST" action="{{ route('spk.update', $spk->id) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    {{-- Info Dasar --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        
                        {{-- Field No SPK --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">
                                <i class="fa-solid fa-hashtag mr-1 text-blue-500"></i> No. SPK
                            </label>
                            <input type="text" name="no_spk" value="{{ old('no_spk', $spk->no_spk) }}"
                                class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-green-500 focus:border-green-500 transition">
                            @error('no_spk')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Field Customer --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">
                                <i class="fa-solid fa-user-tag mr-1 text-blue-500"></i> Customer
                            </label>
                            <select name="customer_id" class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-green-500 focus:border-green-500 transition" required>
                                @foreach ($customers as $c)
                                    <option value="{{ $c->id }}" {{ old('customer_id', $spk->customer_id) == $c->id ? 'selected' : '' }}>
                                        {{ $c->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('customer_id')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Field Model --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">
                                <i class="fa-solid fa-car-side mr-1 text-blue-500"></i> Model
                            </label>
                            <input type="text" name="model" class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-green-500 focus:border-green-500 transition"
                                   value="{{ old('model', $spk->model) }}" required>
                            @error('model')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Field No Polisi --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">
                                <i class="fa-solid fa-id-badge mr-1 text-blue-500"></i> No. Polisi
                            </label>
                            <input type="text" name="no_polisi" class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-green-500 focus:border-green-500 transition"
                                   value="{{ old('no_polisi', $spk->no_polisi) }}" required>
                            @error('no_polisi')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Field Tanggal Masuk --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">
                                <i class="fa-solid fa-calendar-plus mr-1 text-blue-500"></i> Tanggal Masuk
                            </label>
                            <input type="date" name="tgl_masuk" class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-green-500 focus:border-green-500 transition"
                                   value="{{ old('tgl_masuk', $spk->tgl_masuk) }}" required>
                            @error('tgl_masuk')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Field Estimasi Selesai --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">
                                <i class="fa-solid fa-hourglass-half mr-1 text-blue-500"></i> Estimasi Selesai
                            </label>
                            <input type="date" name="estimasi_selesai" class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-green-500 focus:border-green-500 transition"
                                   value="{{ old('estimasi_selesai', $spk->estimasi_selesai) }}">
                            @error('estimasi_selesai')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Data Panel dari Model (yang sudah di-cast menjadi array) --}}
                    @php
                        $panels_data = $spk->details ?? [];
                    @endphp

                    {{-- Panel dan Jenis Pekerjaan --}}
                    <h3 class="text-gray-800 font-semibold mt-6 mb-2 border-b pb-2">Detail Pekerjaan Panel</h3>
                    <div id="panel-container">
                        
                        {{-- LOOPING DATA YANG SUDAH ADA --}}
                        @forelse ($panels_data as $index => $detail)
                            <div class="grid grid-cols-1 sm:grid-cols-4 gap-3 mb-3 panel-row">
                                <div>
                                    <label class="block text-gray-600 text-sm mb-1">Nama Panel</label>
                                    <select name="nama_panel[]" class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-green-500 focus:border-green-500 transition px-3 py-2">
                                        <option value="">-- Pilih Panel --</option>
                                        @foreach ($panels as $p)
                                            <option value="{{ $p }}" 
                                                    {{ (old('nama_panel.'.$index, $detail['nama_panel'] ?? '') == $p) ? 'selected' : '' }}>
                                                {{ $p }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-gray-600 text-sm mb-1">Jenis Pekerjaan</label>
                                    <select name="jenis_pekerjaan[]" class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-green-500 focus:border-green-500 transition px-3 py-2 jenis-select">
                                        <option value="">-- Pilih Jenis --</option>
                                        <option value="KC" {{ (old('jenis_pekerjaan.'.$index, $detail['jenis_pekerjaan'] ?? '') == 'KC') ? 'selected' : '' }}>Ketok Cat</option>
                                        <option value="GC" {{ (old('jenis_pekerjaan.'.$index, $detail['jenis_pekerjaan'] ?? '') == 'GC') ? 'selected' : '' }}>Ganti Cat</option>
                                        <option value="SC" {{ (old('jenis_pekerjaan.'.$index, $detail['jenis_pekerjaan'] ?? '') == 'SC') ? 'selected' : '' }}>Spesial Cat</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-gray-600 text-sm mb-1">Biaya (Rp)</label>
                                    <input type="number" name="biaya[]" class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-green-500 focus:border-green-500 transition px-3 py-2 biaya-input"
                                            value="{{ old('biaya.'.$index, $detail['biaya'] ?? '') }}" readonly>
                                </div>

                                <div class="flex items-end">
                                    <button type="button"
                                            class="remove-row bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-lg shadow transition">
                                        Hapus
                                    </button>
                                </div>
                            </div>
                        @empty
                            {{-- Template Baris Kosong jika tidak ada data panel sama sekali --}}
                             <div class="grid grid-cols-1 sm:grid-cols-4 gap-3 mb-3 panel-row">
                                <div>
                                    <label class="block text-gray-600 text-sm mb-1">Nama Panel</label>
                                    <select name="nama_panel[]" class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-green-500 focus:border-green-500 transition px-3 py-2">
                                        <option value="">-- Pilih Panel --</option>
                                        @foreach ($panels as $p)
                                            <option value="{{ $p }}">{{ $p }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-gray-600 text-sm mb-1">Jenis Pekerjaan</label>
                                    <select name="jenis_pekerjaan[]" class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-green-500 focus:border-green-500 transition px-3 py-2 jenis-select">
                                        <option value="">-- Pilih Jenis --</option>
                                        <option value="KC">Ketok Cat</option>
                                        <option value="GC">Ganti Cat</option>
                                        <option value="SC">Spesial Cat</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-gray-600 text-sm mb-1">Biaya (Rp)</label>
                                    <input type="number" name="biaya[]" class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-green-500 focus:border-green-500 transition px-3 py-2 biaya-input"
                                            value="" readonly>
                                </div>

                                <div class="flex items-end">
                                    <button type="button"
                                            class="remove-row bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-lg shadow transition">
                                        Hapus
                                    </button>
                                </div>
                            </div>
                        @endforelse
                        
                    </div>

                    <button type="button" id="add-row"
                        class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow transition">
                        <i class="fa-solid fa-square-plus mr-1"></i> Tambah Panel
                    </button>
                    @error('nama_panel')
                        <p class="text-sm text-red-600 mt-1"><i class="fa-solid fa-circle-exclamation mr-1"></i>Detail Panel wajib diisi.</p>
                    @enderror


                    {{-- Catatan & Status --}}
                    <h3 class="text-gray-800 font-semibold mt-6 mb-2 border-b pb-2">Status & Catatan</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">
                                <i class="fa-solid fa-list-check mr-1 text-blue-500"></i> Status
                            </label>
                            <select name="status" class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-green-500 focus:border-green-500 transition">
                                <option value="proses" {{ old('status', $spk->status) == 'proses' ? 'selected' : '' }}>Proses</option>
                                <option value="selesai" {{ old('status', $spk->status) == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="batal" {{ old('status', $spk->status) == 'batal' ? 'selected' : '' }}>Batal</option>
                            </select>
                            @error('status')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">
                                <i class="fa-solid fa-note-sticky mr-1 text-blue-500"></i> Catatan
                            </label>
                            <textarea name="catatan" class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-green-500 focus:border-green-500 transition" rows="2">{{ old('catatan', $spk->catatan) }}</textarea>
                            @error('catatan')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Tombol Simpan --}}
                    <div class="flex justify-end gap-3 pt-4 border-t mt-6">
                        <a href="{{ route('spk.index') }}" 
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

    {{-- Script Harga Otomatis & Tambah Baris --}}
    <script>
        const hargaDasar = { KC: 550000, GC: 700000, SC: 850000 };

        function updateBiaya(row) {
            const jenis = row.querySelector('.jenis-select').value;
            const biayaInput = row.querySelector('.biaya-input');
            
            // Menggunakan harga dasar yang kita definisikan di JS
            biayaInput.value = jenis ? hargaDasar[jenis] : '';
        }

        // Init update biaya untuk data yang sudah ada saat halaman dimuat
        document.querySelectorAll('.panel-row').forEach(row => {
            const biayaInput = row.querySelector('.biaya-input');
            if (biayaInput.value === '') {
                 updateBiaya(row);
            }
        });

        document.addEventListener('change', function (e) {
            if (e.target.classList.contains('jenis-select')) {
                const row = e.target.closest('.panel-row');
                updateBiaya(row);
            }
        });

        document.getElementById('add-row').addEventListener('click', () => {
            const container = document.getElementById('panel-container');
            const originalRow = container.querySelector('.panel-row');
            
            if (originalRow) {
                const newRow = originalRow.cloneNode(true);
                // Kosongkan nilai input/select di baris baru
                newRow.querySelectorAll('input, select').forEach(el => {
                    if(el.tagName === 'SELECT') {
                        el.selectedIndex = 0; // Reset select ke opsi pertama
                    } else {
                        el.value = ''; // Kosongkan input
                    }
                });
                container.appendChild(newRow);
            }
        });

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
    </script>
</x-app-layout>