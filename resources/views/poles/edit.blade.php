<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 flex items-center gap-2">
            {{-- 🔥 Ganti Icon ke Poles (hijau untuk edit) --}}
            <i class="fa-solid fa-broom text-green-600"></i>
            {{ ('Edit Data Poles') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border border-gray-200 rounded-2xl shadow-lg p-8 transition hover:shadow-xl">

                {{-- Judul Form dan Tombol Kembali --}}
                <div class="mb-6 border-b pb-4 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                        {{-- 🔥 Ganti Judul dan SPK ($pole) --}}
                        <i class="fa-solid fa-pen-to-square text-green-600"></i> Form Edit Data Poles (SPK: {{ $pole->spk->no_spk ?? '-' }})
                    </h3>
                    {{-- 🔥 Ganti route ke poles.index --}}
                    <a href="{{ route('poles.index') }}"
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

                {{-- 🔥 Ganti route ke poles.update dan $pole->id --}}
                <form action="{{ route('poles.update', $pole->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT') 

                    {{-- Data Utama --}}
                    <h3 class="text-gray-800 font-semibold mb-2 border-b pb-2">Data Pengerjaan</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Mekanik --}}
                        <div>
                            <label for="mekanik_id" class="block text-sm font-semibold text-gray-700 mb-1">
                                <i class="fa-solid fa-user-gear mr-1 text-blue-600"></i> Mekanik (Poles) {{-- 🔥 Ganti Label --}}
                            </label>
                            <select name="mekanik_id" id="mekanik_id" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-600 focus:border-green-600 transition" required>
                                <option value="">-- Pilih Mekanik --</option>
                                {{-- Variabel $mekaniks dikirim dari PolesController@edit --}}
                                @foreach ($mekaniks as $mekanik)
                                    {{-- 🔥 Ganti $paint->mekanik_id jadi $pole->mekanik_id --}}
                                    <option value="{{ $mekanik->id }}" {{ old('mekanik_id', $pole->mekanik_id) == $mekanik->id ? 'selected' : '' }}>{{ $mekanik->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- SPK --}}
                        <div>
                            <label for="spk_id" class="block text-sm font-semibold text-gray-700 mb-1">
                                <i class="fa-solid fa-file-signature mr-1 text-blue-600"></i> No. SPK
                            </label>
                            <select name="spk_id" id="spk_id" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-600 focus:border-green-600 transition" required>
                                <option value="">-- Pilih No. SPK --</option>
                                {{-- Variabel $spks dikirim dari PolesController@edit --}}
                                @foreach ($spks as $spk_item) 
                                    {{-- 🔥 Ganti $paint->spk_id jadi $pole->spk_id --}}
                                    <option value="{{ $spk_item->id }}" {{ old('spk_id', $pole->spk_id) == $spk_item->id ? 'selected' : '' }}>
                                        {{ $spk_item->no_spk }} ({{ $spk_item->customer->nama }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Tanggal --}}
                        <div>
                            <label for="tanggal" class="block text-sm font-semibold text-gray-700 mb-1">
                                <i class="fa-solid fa-calendar-days mr-1 text-blue-600"></i> Tanggal Pengerjaan
                            </label>
                            {{-- 🔥 Ganti $paint->tanggal jadi $pole->tanggal --}}
                            {{-- Pastikan $pole->tanggal adalah objek Carbon (sudah di-cast di Model) --}}
                            <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal', $pole->tanggal ? $pole->tanggal->format('Y-m-d') : '') }}"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-600 focus:border-green-600 transition" required>
                        </div>

                         {{-- Status --}}
                        <div>
                            <label for="status" class="block text-sm font-semibold text-gray-700 mb-1">
                                <i class="fa-solid fa-check-circle mr-1 text-blue-600"></i> Status
                            </label>
                            <select name="status" id="status" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-600 focus:border-green-600 transition" required>
                                {{-- 🔥 Ganti $paint->status jadi $pole->status --}}
                                <option value="Antri" {{ old('status', $pole->status) == 'Antri' ? 'selected' : '' }}>Antri</option>
                                <option value="Proses" {{ old('status', $pole->status) == 'Proses' ? 'selected' : '' }}>Proses</option>
                                <option value="Selesai" {{ old('status', $pole->status) == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                            </select>
                        </div>

                        {{-- Jam Mulai --}}
                        <div>
                            <label for="jam_mulai" class="block text-sm font-semibold text-gray-700 mb-1">
                                <i class="fa-solid fa-clock mr-1 text-blue-600"></i> Jam Mulai
                            </label>
                            {{-- 🔥 Ganti $paint->jam_mulai jadi $pole->jam_mulai --}}
                            <input type="time" name="jam_mulai" id="jam_mulai" value="{{ old('jam_mulai', $pole->jam_mulai ? \Carbon\Carbon::parse($pole->jam_mulai)->format('H:i') : '') }}"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-600 focus:border-green-600 transition">
                        </div>

                        {{-- Jam Selesai --}}
                        <div>
                            <label for="jam_selesai" class="block text-sm font-semibold text-gray-700 mb-1">
                                <i class="fa-solid fa-clock mr-1 text-blue-600"></i> Jam Selesai
                            </label>
                             {{-- 🔥 Ganti $paint->jam_selesai jadi $pole->jam_selesai --}}
                            <input type="time" name="jam_selesai" id="jam_selesai" value="{{ old('jam_selesai', $pole->jam_selesai ? \Carbon\Carbon::parse($pole->jam_selesai)->format('H:i') : '') }}"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-600 focus:border-green-600 transition">
                        </div>
                    </div>

                    {{-- Dynamic Row Bahan --}}
                    <h3 class="text-gray-800 font-semibold mt-6 mb-2 border-b pb-2">Bahan yang Digunakan</h3>
                    <div id="bahan-container">
                        {{-- 🔥 Variabel $bahan_tersimpan & $daftar_bahan dikirim dari PolesController@edit --}}
                        @forelse ($bahan_tersimpan as $index => $item_bahan)
                            <div class="grid grid-cols-12 gap-4 bahan-row mb-4 p-4 border border-gray-200 rounded-lg bg-gray-50">
                                {{-- Pilih Bahan --}}
                                <div class="col-span-6">
                                    <label class="block text-gray-600 text-sm mb-1">Nama Bahan</label>
                                    {{-- 🔥 Validasi 'nullable' di controller, jadi 'required' bisa dihapus --}}
                                    <select name="nama_bahan[]" class="w-full border-gray-300 rounded-lg shadow-sm">
                                        <option value="">-- Pilih Bahan --</option>
                                        @foreach ($daftar_bahan as $bahan_option)
                                            <option value="{{ $bahan_option }}" 
                                                    {{ (old('nama_bahan.'.$index, $item_bahan['nama_bahan'] ?? '') == $bahan_option) ? 'selected' : '' }}>
                                                {{ $bahan_option }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Qty Bahan --}}
                                <div class="col-span-4">
                                    <label class="block text-gray-600 text-sm mb-1">Jumlah (Qty)</label>
                                    {{-- 🔥 'required' dihapus --}}
                                    <input type="number" name="qty_bahan[]" value="{{ old('qty_bahan.'.$index, $item_bahan['qty'] ?? 1) }}" min="1" class="w-full border-gray-300 rounded-lg shadow-sm">
                                </div>

                                {{-- Tombol Hapus Bahan --}}
                                <div class="col-span-2 flex items-end">
                                    <button type="button" class="remove-bahan-row bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-lg shadow transition flex items-center justify-center w-full h-10">
                                        <i class="fa-solid fa-trash-can mr-1"></i> Hapus
                                    </button>
                                </div>
                            </div>
                        @empty
                            {{-- Baris Template jika tidak ada bahan tersimpan --}}
                            <div class="grid grid-cols-12 gap-4 bahan-row mb-4 p-4 border border-gray-200 rounded-lg bg-gray-50">
                                <div class="col-span-6">
                                    <label class="block text-gray-600 text-sm mb-1">Nama Bahan</label>
                                    {{-- 🔥 'required' dihapus --}}
                                    <select name="nama_bahan[]" class="w-full border-gray-300 rounded-lg shadow-sm">
                                        <option value="">-- Pilih Bahan --</option>
                                        @foreach ($daftar_bahan as $bahan_option)
                                            <option value="{{ $bahan_option }}">{{ $bahan_option }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-span-4">
                                    <label class="block text-gray-600 text-sm mb-1">Jumlah (Qty)</label>
                                    {{-- 🔥 'required' dihapus --}}
                                    <input type="number" name="qty_bahan[]" value="1" min="1" class="w-full border-gray-300 rounded-lg shadow-sm">
                                </div>
                                <div class="col-span-2 flex items-end">
                                    <button type="button" class="remove-bahan-row bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-lg shadow transition flex items-center justify-center w-full h-10">
                                        <i class="fa-solid fa-trash-can mr-1"></i> Hapus
                                    </button>
                                </div>
                            </div>
                        @endforelse
                        
                        {{-- Handle old data jika validasi gagal & user menambah baris baru --}}
                         @if(is_array(old('nama_bahan')) && count(old('nama_bahan')) > count($bahan_tersimpan))
                            @for($i = count($bahan_tersimpan); $i < count(old('nama_bahan')); $i++)
                            <div class="grid grid-cols-12 gap-4 bahan-row mb-4 p-4 border border-gray-200 rounded-lg bg-gray-50">
                                <div class="col-span-6">
                                    <label class="block text-gray-600 text-sm mb-1">Nama Bahan</label>
                                    <select name="nama_bahan[]" class="w-full border-gray-300 rounded-lg shadow-sm">
                                        <option value="">-- Pilih Bahan --</option>
                                        @foreach ($daftar_bahan as $bahan_option)
                                            <option value="{{ $bahan_option }}" {{ old('nama_bahan.'.$i) == $bahan_option ? 'selected' : '' }}>{{ $bahan_option }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-span-4">
                                    <label class="block text-gray-600 text-sm mb-1">Jumlah (Qty)</label>
                                    <input type="number" name="qty_bahan[]" value="{{ old('qty_bahan.'.$i, 1) }}" min="1" class="w-full border-gray-300 rounded-lg shadow-sm">
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
                     @error('nama_bahan')
                         <p class="text-sm text-red-600 -mt-4 mb-4"><i class="fa-solid fa-circle-exclamation mr-1"></i>Minimal harus ada satu bahan yang dipilih.</p>
                     @enderror

                    {{-- Tombol Simpan & Batal --}}
                    <div class="flex justify-end gap-3 pt-4 border-t mt-6">
                        {{-- 🔥 Ganti route ke poles.index --}}
                        <a href="{{ route('poles.index') }}"
                            class="flex items-center gap-2 bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded-lg shadow transition">
                            <i class="fa-solid fa-xmark"></i> Batal
                        </a>
                        <button type="submit"
                            class="flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-lg shadow transition"> 
                            <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    {{-- Script Dynamic Row Bahan (JS-nya generik, tidak perlu diubah) --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const container = document.getElementById('bahan-container');
            
            // Template HTML untuk baris baru
            const templateRow = container.querySelector('.bahan-row') ? container.querySelector('.bahan-row').cloneNode(true) : null;
            if(templateRow){
                templateRow.querySelectorAll('select').forEach(el => el.selectedIndex = 0);
                templateRow.querySelectorAll('input[type="number"]').forEach(el => el.value = '1');
            }

            document.getElementById('add-bahan-row').addEventListener('click', () => {
                 if (templateRow) {
                    const newRow = templateRow.cloneNode(true);
                    container.appendChild(newRow);
                } else {
                    console.error("Template row tidak ditemukan!");
                }
            });

            container.addEventListener('click', function (e) {
                if (e.target.classList.contains('remove-bahan-row') || e.target.closest('.remove-bahan-row')) {
                    const button = e.target.closest('.remove-bahan-row');
                    const row = button.closest('.bahan-row');
                    
                    // 🔥 Berbeda dari Paint, Poles BISA jadi tidak pakai bahan (nullable)
                    // Jadi kita BOLEH hapus semua baris
                    if (container.querySelectorAll('.bahan-row').length > 0) { // Cukup cek > 0
                        row.remove();
                    }
                    
                    // Tambahkan baris kosong jika semua baris terhapus (opsional, tapi bagus)
                    if (container.querySelectorAll('.bahan-row').length === 0 && templateRow) {
                         const newRow = templateRow.cloneNode(true);
                         newRow.querySelectorAll('select').forEach(el => el.selectedIndex = 0);
                         newRow.querySelectorAll('input[type="number"]').forEach(el => el.value = '1');
                         // Hapus 'required' jika baris terakhir dihapus, karena poles boleh kosong
                         newRow.querySelectorAll('select, input').forEach(el => el.required = false);
                         container.appendChild(newRow);
                    }
                }
            });
        });
    </script>
</x-app-layout>

