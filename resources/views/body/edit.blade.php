<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 flex items-center gap-2">
            <i class="fa-solid fa-car-burst text-green-600"></i> {{-- Icon disesuaikan --}}
            {{ ('Edit Data Body') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8"> {{-- Lebar disamakan dengan create --}}
            <div class="bg-white border border-gray-200 rounded-2xl shadow-lg p-8 transition hover:shadow-xl">

                {{-- Judul Form dan Tombol Kembali --}}
                <div class="mb-6 border-b pb-4 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                        <i class="fa-solid fa-pen-to-square text-green-600"></i> Form Edit Data Body (SPK: {{ $body->spk->no_spk ?? '-' }})
                    </h3>
                    <a href="{{ route('body.index') }}"
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

                <form action="{{ route('body.update', $body->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT') {{-- Method untuk update --}}

                    {{-- Data Utama --}}
                    <h3 class="text-gray-800 font-semibold mb-2 border-b pb-2">Data Pengerjaan</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Mekanik --}}
                        <div>
                            <label for="mekanik_id" class="block text-sm font-semibold text-gray-700 mb-1">
                                <i class="fa-solid fa-user-gear mr-1 text-blue-600"></i> Mekanik (Body)
                            </label>
                            <select name="mekanik_id" id="mekanik_id" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-600 focus:border-green-600 transition" required> {{-- Warna focus disamakan --}}
                                <option value="">-- Pilih Mekanik --</option>
                                @foreach ($mekaniks as $mekanik)
                                    <option value="{{ $mekanik->id }}" {{ old('mekanik_id', $body->mekanik_id) == $mekanik->id ? 'selected' : '' }}>{{ $mekanik->nama }}</option>
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
                                @foreach ($spks as $spk_item) {{-- Ganti variabel $spk jadi $spk_item --}}
                                    <option value="{{ $spk_item->id }}" {{ old('spk_id', $body->spk_id) == $spk_item->id ? 'selected' : '' }}>
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
                            
                            {{-- Logic: Cek old input -> Cek $body ada isinya gak -> Format tanggal -> Kalau kosong string kosong --}}
                            <input type="date" name="tanggal" id="tanggal" 
                                value="{{ old('tanggal', $body->tanggal ? $body->tanggal->format('Y-m-d') : '') }}"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-600 focus:border-green-600 transition" required>
                        </div>

                         {{-- Status --}}
                        <div>
                            <label for="status" class="block text-sm font-semibold text-gray-700 mb-1">
                                <i class="fa-solid fa-check-circle mr-1 text-blue-600"></i> Status
                            </label>
                            <select name="status" id="status" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-600 focus:border-green-600 transition" required>
                                <option value="Antri" {{ old('status', $body->status) == 'Antri' ? 'selected' : '' }}>Antri</option>
                                <option value="Proses" {{ old('status', $body->status) == 'Proses' ? 'selected' : '' }}>Proses</option>
                                <option value="Selesai" {{ old('status', $body->status) == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                            </select>
                        </div>

                        {{-- Jam Mulai --}}
                        <div>
                            <label for="jam_mulai" class="block text-sm font-semibold text-gray-700 mb-1">
                                <i class="fa-solid fa-clock mr-1 text-blue-600"></i> Jam Mulai
                            </label>
                            <input type="time" name="jam_mulai" id="jam_mulai" value="{{ old('jam_mulai', $body->jam_mulai ? \Carbon\Carbon::parse($body->jam_mulai)->format('H:i') : '') }}"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-600 focus:border-green-600 transition">
                        </div>

                        {{-- Jam Selesai --}}
                        <div>
                            <label for="jam_selesai" class="block text-sm font-semibold text-gray-700 mb-1">
                                <i class="fa-solid fa-clock mr-1 text-blue-600"></i> Jam Selesai
                            </label>
                            <input type="time" name="jam_selesai" id="jam_selesai" value="{{ old('jam_selesai', $body->jam_selesai ? \Carbon\Carbon::parse($body->jam_selesai)->format('H:i') : '') }}"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-600 focus:border-green-600 transition">
                        </div>
                    </div>

                    {{-- Dynamic Row Bahan --}}
                    <h3 class="text-gray-800 font-semibold mt-6 mb-2 border-b pb-2">Bahan yang Digunakan</h3>
                    <div id="bahan-container">
                        {{-- Loop data bahan yang sudah ada --}}
                        @forelse ($bahan_tersimpan as $index => $item_bahan)
                            <div class="grid grid-cols-12 gap-4 bahan-row mb-4 p-4 border border-gray-200 rounded-lg bg-gray-50">
                                {{-- Pilih Bahan --}}
                                <div class="col-span-6">
                                    <label class="block text-gray-600 text-sm mb-1">Nama Bahan</label>
                                    <select name="nama_bahan[]" class="w-full border-gray-300 rounded-lg shadow-sm" required>
                                        <option value="">-- Pilih Bahan --</option>
                                        @foreach ($daftar_bahan as $bahan_option)
                                            <option value="{{ $bahan_option }}" {{ (old('nama_bahan.'.$index, $item_bahan['nama_bahan'] ?? '') == $bahan_option) ? 'selected' : '' }}>
                                                {{ $bahan_option }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Qty Bahan --}}
                                <div class="col-span-4">
                                    <label class="block text-gray-600 text-sm mb-1">Jumlah (Qty)</label>
                                    <input type="number" name="qty_bahan[]" value="{{ old('qty_bahan.'.$index, $item_bahan['qty'] ?? 1) }}" min="1" class="w-full border-gray-300 rounded-lg shadow-sm" required>
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
                                    <select name="nama_bahan[]" class="w-full border-gray-300 rounded-lg shadow-sm" required>
                                        <option value="">-- Pilih Bahan --</option>
                                        @foreach ($daftar_bahan as $bahan_option)
                                            <option value="{{ $bahan_option }}">{{ $bahan_option }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-span-4">
                                    <label class="block text-gray-600 text-sm mb-1">Jumlah (Qty)</label>
                                    <input type="number" name="qty_bahan[]" value="1" min="1" class="w-full border-gray-300 rounded-lg shadow-sm" required>
                                </div>
                                <div class="col-span-2 flex items-end">
                                    <button type="button" class="remove-bahan-row bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-lg shadow transition flex items-center justify-center w-full h-10">
                                        <i class="fa-solid fa-trash-can mr-1"></i> Hapus
                                    </button>
                                </div>
                            </div>
                        @endforelse
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
                        <a href="{{ route('body.index') }}"
                            class="flex items-center gap-2 bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded-lg shadow transition">
                            <i class="fa-solid fa-xmark"></i> Batal {{-- Icon diubah --}}
                        </a>
                        <button type="submit"
                            class="flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-lg shadow transition"> {{-- Warna tombol disamakan --}}
                            <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    {{-- Script Dynamic Row Bahan (Sama seperti di create) --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const container = document.getElementById('bahan-container');
            
            // Template HTML untuk baris baru (diambil dari baris kosong jika ada, atau baris pertama)
            const templateRow = container.querySelector('.bahan-row') ? container.querySelector('.bahan-row').cloneNode(true) : null;
            if(templateRow){
                 // Reset nilai input/select di template
                templateRow.querySelectorAll('select').forEach(el => el.selectedIndex = 0);
                templateRow.querySelectorAll('input[type="number"]').forEach(el => el.value = '1'); // Qty default 1
            }

            // Logika Tambah Baris Bahan
            document.getElementById('add-bahan-row').addEventListener('click', () => {
                 if (templateRow) {
                    const newRow = templateRow.cloneNode(true); // Gunakan template yang sudah direset
                    container.appendChild(newRow);
                } else {
                    console.error("Template row tidak ditemukan!"); // Untuk debugging
                }
            });

            // Logika Hapus Baris Bahan (Event Delegation)
            container.addEventListener('click', function (e) {
                if (e.target.classList.contains('remove-bahan-row') || e.target.closest('.remove-bahan-row')) {
                    const button = e.target.closest('.remove-bahan-row');
                    const row = button.closest('.bahan-row');
                    
                    if (container.querySelectorAll('.bahan-row').length > 1) {
                        row.remove();
                    } else {
                        alert('Minimal harus ada satu baris bahan!'); 
                    }
                }
            });
        });
    </script>
</x-app-layout>
