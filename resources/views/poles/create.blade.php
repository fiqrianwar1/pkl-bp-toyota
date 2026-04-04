<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 flex items-center gap-2">
            {{-- 🔥 Ganti Icon & Judul --}}
            <i class="fa-solid fa-broom text-blue-600"></i>
            {{ ('Tambah Data Poles') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border border-gray-200 rounded-2xl shadow-lg p-8 transition hover:shadow-xl">
                
                {{-- 🔥 Judul Form dan Tombol Kembali --}}
                <div class="mb-6 border-b pb-4 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                        <i class="fa-solid fa-plus-circle text-blue-600"></i> Form Tambah Data Poles
                    </h3>
                    <span class="text-xs bg-blue-100 text-blue-600 px-3 py-1 rounded-full font-medium">
                        Wira Toyota Banjarmasin
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

                {{-- 🔥 Ganti Route ke poles.store --}}
                <form action="{{ route('poles.store') }}" method="POST" class="space-y-6">
                    @csrf

                    {{-- Data Utama --}}
                    <h3 class="text-gray-800 font-semibold mb-2 border-b pb-2">Data Pengerjaan</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Mekanik --}}
                        <div>
                            <label for="mekanik_id" class="block text-sm font-semibold text-gray-700 mb-1">
                                {{-- 🔥 Ganti Judul Label --}}
                                <i class="fa-solid fa-user-gear mr-1 text-blue-600"></i> Mekanik (Poles)
                            </label>
                            <select name="mekanik_id" id="mekanik_id" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-600 focus:border-blue-600 transition" required>
                                <option value="">-- Pilih Mekanik --</option>
                                @foreach ($mekaniks as $mekanik)
                                    <option value="{{ $mekanik->id }}" {{ old('mekanik_id') == $mekanik->id ? 'selected' : '' }}>{{ $mekanik->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- SPK --}}
                        <div>
                            <label for="spk_id" class="block text-sm font-semibold text-gray-700 mb-1">
                                <i class="fa-solid fa-file-signature mr-1 text-blue-600"></i> No. SPK
                            </label>
                            <select name="spk_id" id="spk_id" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-600 focus:border-blue-600 transition" required>
                                <option value="">-- Pilih No. SPK --</option>
                                @foreach ($spks as $spk)
                                    <option value="{{ $spk->id }}" {{ old('spk_id') == $spk->id ? 'selected' : '' }}>{{ $spk->no_spk }} ({{ $spk->customer->nama }})</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Tanggal --}}
                        <div>
                            <label for="tanggal" class="block text-sm font-semibold text-gray-700 mb-1">
                                <i class="fa-solid fa-calendar-days mr-1 text-blue-600"></i> Tanggal Pengerjaan
                            </label>
                            <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-600 focus:border-blue-600 transition" required>
                        </div>

                         {{-- Status --}}
                        <div>
                            <label for="status" class="block text-sm font-semibold text-gray-700 mb-1">
                                <i class="fa-solid fa-check-circle mr-1 text-blue-600"></i> Status
                            </label>
                            <select name="status" id="status" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-600 focus:border-blue-600 transition" required>
                                <option value="Antri" {{ old('status', 'Antri') == 'Antri' ? 'selected' : '' }}>Antri</option>
                                <option value="Proses" {{ old('status') == 'Proses' ? 'selected' : '' }}>Proses</option>
                                <option value="Selesai" {{ old('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                            </select>
                        </div>

                        {{-- Jam Mulai --}}
                        <div>
                            <label for="jam_mulai" class="block text-sm font-semibold text-gray-700 mb-1">
                                <i class="fa-solid fa-clock mr-1 text-blue-600"></i> Jam Mulai
                            </label>
                            <input type="time" name="jam_mulai" id="jam_mulai" value="{{ old('jam_mulai') }}"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-600 focus:border-blue-600 transition">
                        </div>

                        {{-- Jam Selesai --}}
                        <div>
                            <label for="jam_selesai" class="block text-sm font-semibold text-gray-700 mb-1">
                                <i class="fa-solid fa-clock mr-1 text-blue-600"></i> Jam Selesai
                            </label>
                            <input type="time" name="jam_selesai" id="jam_selesai" value="{{ old('jam_selesai') }}"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-600 focus:border-blue-600 transition">
                        </div>
                    </div>

                    {{-- Dynamic Row Bahan --}}
                    <h3 class="text-gray-800 font-semibold mt-6 mb-2 border-b pb-2">Bahan yang Digunakan</h3>
                    <div id="bahan-container">
                        {{-- Baris Template Bahan (Akan diduplikasi oleh JS) --}}
                        {{-- 🔥 NOTE: Controller Poles mengirim $daftar_bahan yang berbeda --}}
                        <div class="grid grid-cols-12 gap-4 bahan-row mb-4 p-4 border border-gray-200 rounded-lg bg-gray-50">
                            {{-- Pilih Bahan --}}
                            <div class="col-span-6">
                                <label class="block text-gray-600 text-sm mb-1">Nama Bahan</label>
                                <select name="nama_bahan[]" class="w-full border-gray-300 rounded-lg shadow-sm" required>
                                    <option value="">-- Pilih Bahan --</option>
                                    @foreach ($daftar_bahan as $bahan)
                                        <option value="{{ $bahan }}" {{ old('nama_bahan.0') == $bahan ? 'selected' : '' }}>{{ $bahan }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            {{-- Qty Bahan --}}
                            <div class="col-span-4">
                                <label class="block text-gray-600 text-sm mb-1">Jumlah (Qty)</label>
                                <input type="number" name="qty_bahan[]" value="{{ old('qty_bahan.0', 1) }}" min="1" class="w-full border-gray-300 rounded-lg shadow-sm" required>
                            </div>

                            {{-- Tombol Hapus Bahan --}}
                            <div class="col-span-2 flex items-end">
                                <button type="button" class="remove-bahan-row bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-lg shadow transition flex items-center justify-center w-full h-10">
                                    <i class="fa-solid fa-trash-can mr-1"></i> Hapus
                                </button>
                            </div>
                        </div>

                        {{-- Tampilkan baris tambahan jika ada error validasi (old data) --}}
                        @if(is_array(old('nama_bahan')) && count(old('nama_bahan')) > 1)
                            @for($i = 1; $i < count(old('nama_bahan')); $i++)
                            <div class="grid grid-cols-12 gap-4 bahan-row mb-4 p-4 border border-gray-200 rounded-lg bg-gray-50">
                                <div class="col-span-6">
                                    <label class="block text-gray-600 text-sm mb-1">Nama Bahan</label>
                                    <select name="nama_bahan[]" class="w-full border-gray-300 rounded-lg shadow-sm" required>
                                        <option value="">-- Pilih Bahan --</option>
                                        @foreach ($daftar_bahan as $bahan)
                                            <option value="{{ $bahan }}" {{ old('nama_bahan.'.$i) == $bahan ? 'selected' : '' }}>{{ $bahan }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-span-4">
                                    <label class="block text-gray-600 text-sm mb-1">Jumlah (Qty)</label>
                                    <input type="number" name="qty_bahan[]" value="{{ old('qty_bahan.'.$i, 1) }}" min="1" class="w-full border-gray-300 rounded-lg shadow-sm" required>
                                </div>
                                <div class="col-span-2 flex items-end">
                                    <button type="button" class="remove-bahan-row bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-lg shadow transition flex items-center justify-center w-full h-10">
                                        <i class="fa-solid fa-trash-can mr-1"></i> Hapus
                                    </button>
                                </div>
                            </div>
                            @endfor
                        @endif
                    </div>

                    {{-- Tombol Tambah Bahan --}}
                    <div class="mt-3 mb-5">
                        <button type="button" id="add-bahan-row" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow transition">
                            <i class="fa-solid fa-plus-circle mr-1"></i> Tambah Bahan
                        </button>
                    </div>
                     @error('nama_bahan') {{-- Validasi umum jika array bahan kosong --}}
                         <p class="text-sm text-red-600 -mt-4 mb-4"><i class="fa-solid fa-circle-exclamation mr-1"></i>Minimal harus ada satu bahan yang dipilih.</p>
                     @enderror

                    {{-- Tombol Simpan & Batal --}}
                    <div class="flex justify-end gap-3 pt-4 border-t mt-6">
                        {{-- 🔥 Ganti Route ke poles.index --}}
                        <a href="{{ route('poles.index') }}"
                            class="flex items-center gap-2 bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded-lg shadow transition">
                            <i class="fa-solid fa-arrow-left"></i> Batal
                        </a>
                        <button type="submit"
                            class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow transition">
                            <i class="fa-solid fa-floppy-disk"></i> Simpan
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    {{-- Script Dynamic Row Bahan (Sama Persis) --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const container = document.getElementById('bahan-container');

            // Logika Tambah Baris Bahan
            document.getElementById('add-bahan-row').addEventListener('click', () => {
                const originalRow = container.querySelector('.bahan-row'); // Ambil baris pertama sebagai template
                if (originalRow) {
                    const newRow = originalRow.cloneNode(true);
                    
                    // Reset nilai input/select di baris baru
                    newRow.querySelectorAll('select').forEach(el => el.selectedIndex = 0);
                    newRow.querySelectorAll('input[type="number"]').forEach(el => el.value = '1'); // Qty default 1
                    
                    container.appendChild(newRow);
                }
            });

            // Logika Hapus Baris Bahan (Event Delegation)
            container.addEventListener('click', function (e) {
                if (e.target.classList.contains('remove-bahan-row') || e.target.closest('.remove-bahan-row')) {
                    const button = e.target.closest('.remove-bahan-row');
                    const row = button.closest('.bahan-row');
                    
                    // Cek jika ini baris terakhir
                    if (container.querySelectorAll('.bahan-row').length > 1) {
                        row.remove();
                    } else {
                        // NOTE: Validasi di controller poles sdh 'nullable'
                        // jadi alert ini bisa di-nonaktifkan jika poles boleh tanpa bahan
                        // alert('Minimal harus ada satu baris bahan!'); 
                        
                        // ATAU, jika mau tetap ada 1 baris tapi boleh kosong (opsional):
                        // Cukup hapus 'required' di select/input & nonaktifkan alert
                        
                        // Jika 'required' tetap ada (seperti kode di atas):
                        alert('Minimal harus ada satu baris bahan!');
                    }
                }
            });
        });
    </script>
</x-app-layout>
