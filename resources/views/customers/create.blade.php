<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 flex items-center gap-2">
            <i class="fa-solid fa-user-plus text-blue-600"></i>
            Tambah Customer
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border border-gray-200 rounded-2xl shadow-lg p-8 transition hover:shadow-xl">
                
                <!-- Judul -->
                <div class="mb-6 border-b pb-4 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                        <i class="fa-solid fa-user-pen text-blue-600"></i> Form Tambah Customer
                    </h3>
                    <span class="text-xs bg-blue-100 text-blue-600 px-3 py-1 rounded-full font-medium">
                        Wira Toyota Banjarmasin
                    </span>
                </div>

                <!-- Form -->
                <form action="{{ route('customers.store') }}" method="POST" class="space-y-5">
                    @csrf

                    <!-- Nama -->
                    <div>
                        <label for="nama" class="block text-sm font-semibold text-gray-700 mb-1">
                            <i class="fa-solid fa-id-card mr-1 text-blue-600"></i> Nama Customer
                        </label>
                        <input type="text" name="nama" id="nama" value="{{ old('nama') }}"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-600 focus:border-blue-600 transition">
                        @error('nama')
                            <p class="text-sm text-red-600 mt-1"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Alamat -->
                    <div>
                        <label for="alamat" class="block text-sm font-semibold text-gray-700 mb-1">
                            <i class="fa-solid fa-location-dot mr-1 text-blue-600"></i> Alamat
                        </label>
                        <textarea name="alamat" id="alamat" rows="3"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-600 focus:border-blue-600 transition">{{ old('alamat') }}</textarea>
                        @error('alamat')
                            <p class="text-sm text-red-600 mt-1"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Telepon -->
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

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">
                            <i class="fa-solid fa-envelope mr-1 text-blue-600"></i> Email
                        </label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-600 focus:border-blue-600 transition">
                        @error('email')
                            <p class="text-sm text-red-600 mt-1"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jenis Kelamin -->
                    <div>
                        <label for="jenis_kelamin" class="block text-sm font-semibold text-gray-700 mb-1">
                            <i class="fa-solid fa-venus-mars mr-1 text-blue-600"></i> Jenis Kelamin
                        </label>
                        <select name="jenis_kelamin" id="jenis_kelamin"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-600 focus:border-blue-600 transition">
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('jenis_kelamin')
                            <p class="text-sm text-red-600 mt-1"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tanggal Estimasi -->
                    <div>
                        <label for="tanggal_estimasi" class="block text-sm font-semibold text-gray-700 mb-1">
                            <i class="fa-solid fa-calendar-days mr-1 text-blue-600"></i> Tanggal Estimasi
                        </label>
                        <input type="date" name="tanggal_estimasi" id="tanggal_estimasi" value="{{ old('tanggal_estimasi') }}"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-600 focus:border-blue-600 transition">
                        @error('tanggal_estimasi')
                            <p class="text-sm text-red-600 mt-1"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tombol -->
                    <div class="flex justify-end gap-3 pt-4 border-t mt-6">
                        <a href="{{ route('customers.index') }}"
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
