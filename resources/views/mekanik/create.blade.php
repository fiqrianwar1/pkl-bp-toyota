<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 flex items-center gap-2">
            <i class="fa-solid fa-user-plus text-blue-600"></i>
            {{ ('Tambah Mekanik') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border border-gray-200 rounded-2xl shadow-lg p-8 transition hover:shadow-xl">
                
                <div class="mb-6 border-b pb-4 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                        <i class="fa-solid fa-user-pen text-blue-600"></i> Form Tambah Mekanik
                    </h3>
                    <span class="text-xs bg-blue-100 text-blue-600 px-3 py-1 rounded-full font-medium">
                        Wira Toyota Banjarmasin
                    </span>
                </div>

                <form action="{{ route('mekanik.store') }}" method="POST" class="space-y-5">
                    @csrf

                    <div>
                        <label for="nama" class="block text-sm font-semibold text-gray-700 mb-1">
                            <i class="fa-solid fa-id-card mr-1 text-blue-600"></i> Nama Mekanik
                        </label>
                        <input type="text" name="nama" id="nama" value="{{ old('nama') }}"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-600 focus:border-blue-600 transition" required>
                        @error('nama')
                            <p class="text-sm text-red-600 mt-1"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="jabatan" class="block text-sm font-semibold text-gray-700 mb-1">
                            <i class="fa-solid fa-briefcase mr-1 text-blue-600"></i> Jabatan
                        </label>
                        <select name="jabatan" id="jabatan" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-600 focus:border-blue-600 transition" required>
                            <option value="">-- Pilih Jabatan --</option>
                            <option value="forman" {{ old('jabatan') == 'forman' ? 'selected' : '' }}>Forman</option>
                            <option value="leader" {{ old('jabatan') == 'leader' ? 'selected' : '' }}>Leader</option>
                            <option value="teknisi" {{ old('jabatan') == 'teknisi' ? 'selected' : '' }}>Teknisi</option>
                        </select>
                        @error('jabatan')
                            <p class="text-sm text-red-600 mt-1"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="teknisi" class="block text-sm font-semibold text-gray-700 mb-1">
                            <i class="fa-solid fa-wrench mr-1 text-blue-600"></i> Bidang Teknisi
                        </label>
                        <select name="teknisi" id="teknisi" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-600 focus:border-blue-600 transition" required>
                            <option value="">-- Pilih Bidang --</option>
                            <option value="body" {{ old('teknisi') == 'body' ? 'selected' : '' }}>Body</option>
                            <option value="preparation" {{ old('teknisi') == 'preparation' ? 'selected' : '' }}>Preparation</option>
                            <option value="paint" {{ old('teknisi') == 'paint' ? 'selected' : '' }}>Paint</option>
                            <option value="poles" {{ old('teknisi') == 'poles' ? 'selected' : '' }}>Poles</option>
                            <option value="sparepart" {{ old('teknisi') == 'sparepart' ? 'selected' : '' }}>Sparepart</option>
                        </select>
                        @error('teknisi')
                            <p class="text-sm text-red-600 mt-1"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="telp" class="block text-sm font-semibold text-gray-700 mb-1">
                            <i class="fa-solid fa-phone mr-1 text-blue-600"></i> Telepon
                        </label>
                        <input type="text" name="telp" id="telp" value="{{ old('telp') }}"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-600 focus:border-blue-600 transition">
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
                            class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow transition">
                            <i class="fa-solid fa-floppy-disk"></i> Simpan
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>