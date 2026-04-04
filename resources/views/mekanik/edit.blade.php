<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 flex items-center gap-2">
            <i class="fa-solid fa-user-pen text-green-600"></i>
            {{ ('Edit Mekanik') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border border-gray-200 rounded-2xl shadow-lg p-8 transition hover:shadow-xl">
                
                <div class="flex items-center justify-between mb-6 border-b pb-3">
                    <h3 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                        <i class="fa-solid fa-user-pen text-green-600"></i>
                        Form Edit Data Mekanik
                    </h3>
                    <a href="{{ route('mekanik.index') }}" 
                       class="flex items-center text-sm bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg shadow transition">
                        <i class="fa-solid fa-arrow-left mr-2"></i> Kembali
                    </a>
                </div>

                <form action="{{ route('mekanik.update', $mekanik->id) }}" method="POST" class="space-y-5">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="nama" class="block text-sm font-semibold text-gray-700 mb-1">
                            <i class="fa-solid fa-id-card mr-1 text-blue-600"></i> Nama Mekanik
                        </label>
                        <input type="text" name="nama" id="nama" value="{{ old('nama', $mekanik->nama) }}"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-600 focus:border-green-600 transition" required>
                        @error('nama')
                            <p class="text-sm text-red-600 mt-1"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="jabatan" class="block text-sm font-semibold text-gray-700 mb-1">
                            <i class="fa-solid fa-briefcase mr-1 text-blue-600"></i> Jabatan
                        </label>
                        <select name="jabatan" id="jabatan" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-600 focus:border-green-600 transition" required>
                            <option value="">-- Pilih Jabatan --</option>
                            <option value="forman" {{ old('jabatan', $mekanik->jabatan) == 'forman' ? 'selected' : '' }}>Forman</option>
                            <option value="leader" {{ old('jabatan', $mekanik->jabatan) == 'leader' ? 'selected' : '' }}>Leader</option>
                            <option value="teknisi" {{ old('jabatan', $mekanik->jabatan) == 'teknisi' ? 'selected' : '' }}>Teknisi</option>
                        </select>
                        @error('jabatan')
                            <p class="text-sm text-red-600 mt-1"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="teknisi" class="block text-sm font-semibold text-gray-700 mb-1">
                            <i class="fa-solid fa-wrench mr-1 text-blue-600"></i> Bidang Teknisi
                        </label>
                        <select name="teknisi" id="teknisi" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-600 focus:border-green-600 transition" required>
                            <option value="">-- Pilih Bidang --</option>
                            <option value="body" {{ old('teknisi', $mekanik->teknisi) == 'body' ? 'selected' : '' }}>Body</option>
                            <option value="preparation" {{ old('teknisi', $mekanik->teknisi) == 'preparation' ? 'selected' : '' }}>Preparation</option>
                            <option value="paint" {{ old('teknisi', $mekanik->teknisi) == 'paint' ? 'selected' : '' }}>Paint</option>
                            <option value="poles" {{ old('teknisi', $mekanik->teknisi) == 'poles' ? 'selected' : '' }}>Poles</option>
                            <option value="sparepart" {{ old('teknisi', $mekanik->teknisi) == 'sparepart' ? 'selected' : '' }}>Sparepart</option>
                        </select>
                        @error('teknisi')
                            <p class="text-sm text-red-600 mt-1"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="telp" class="block text-sm font-semibold text-gray-700 mb-1">
                            <i class="fa-solid fa-phone mr-1 text-blue-600"></i> Telepon
                        </label>
                        <input type="text" name="telp" id="telp" value="{{ old('telp', $mekanik->telp) }}"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-600 focus:border-green-600 transition">
                        @error('telp')
                            <p class="text-sm text-red-600 mt-1"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t mt-6">
                        <a href="{{ route('mekanik.index') }}"
                            class="flex items-center gap-2 bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded-lg shadow transition">
                            <i class="fa-solid fa-arrow-left"></i> Batal
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
</x-app-layout>

