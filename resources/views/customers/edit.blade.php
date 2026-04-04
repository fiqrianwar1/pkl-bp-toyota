<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 flex items-center gap-2">
            <i class="fa-solid fa-user-pen text-green-600"></i>
            Edit Customer
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl rounded-2xl p-8 border border-gray-100">
                
                <div class="flex items-center justify-between mb-6 border-b pb-3">
                    <h3 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                        <i class="fa-solid fa-id-card-clip text-green-600"></i>
                        Form Edit Data Customer
                    </h3>
                    <a href="{{ route('customers.index') }}" 
                       class="flex items-center text-sm bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg shadow transition">
                        <i class="fa-solid fa-arrow-left mr-2"></i> Kembali
                    </a>
                </div>

                <form action="{{ route('customers.update', $customer->id) }}" method="POST" class="space-y-5">
                    @csrf
                    @method('PUT')

                    {{-- Nama --}}
                    <div>
                        <label for="nama" class="block text-sm font-semibold text-gray-700 mb-1">
                            <i class="fa-solid fa-user mr-1 text-blue-500"></i> Nama
                        </label>
                        <input type="text" name="nama" id="nama" value="{{ old('nama', $customer->nama) }}"
                               class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-green-500 focus:border-green-500 transition">
                        @error('nama')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Alamat --}}
                    <div>
                        <label for="alamat" class="block text-sm font-semibold text-gray-700 mb-1">
                            <i class="fa-solid fa-location-dot mr-1 text-blue-500"></i> Alamat
                        </label>
                        <textarea name="alamat" id="alamat" rows="3"
                                  class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-green-500 focus:border-green-500 transition">{{ old('alamat', $customer->alamat) }}</textarea>
                        @error('alamat')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Telepon --}}
                    <div>
                        <label for="telp" class="block text-sm font-semibold text-gray-700 mb-1">
                            <i class="fa-solid fa-phone mr-1 text-blue-500"></i> Telepon
                        </label>
                        <input type="text" name="telp" id="telp" value="{{ old('telp', $customer->telp) }}"
                               class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-green-500 focus:border-green-500 transition">
                        @error('telp')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">
                            <i class="fa-solid fa-envelope mr-1 text-blue-500"></i> Email
                        </label>
                        <input type="email" name="email" id="email" value="{{ old('email', $customer->email) }}"
                               class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-green-500 focus:border-green-500 transition">
                        @error('email')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Jenis Kelamin --}}
                    <div>
                        <label for="jenis_kelamin" class="block text-sm font-semibold text-gray-700 mb-1">
                            <i class="fa-solid fa-venus-mars mr-1 text-blue-500"></i> Jenis Kelamin
                        </label>
                        <select name="jenis_kelamin" id="jenis_kelamin"
                                class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-green-500 focus:border-green-500 transition">
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="Laki-laki" {{ old('jenis_kelamin', $customer->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('jenis_kelamin', $customer->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('jenis_kelamin')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tanggal Estimasi --}}
                    <div>
                        <label for="tanggal_estimasi" class="block text-sm font-semibold text-gray-700 mb-1">
                            <i class="fa-solid fa-calendar-days mr-1 text-blue-500"></i> Tanggal Estimasi
                        </label>
                        <input type="date" name="tanggal_estimasi" id="tanggal_estimasi" value="{{ old('tanggal_estimasi', $customer->tanggal_estimasi) }}"
                               class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-green-500 focus:border-green-500 transition">
                        @error('tanggal_estimasi')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tombol --}}
                    <div class="flex justify-end gap-3 pt-4 border-t mt-6">
                        <a href="{{ route('customers.index') }}"
                           class="flex items-center bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded-lg shadow transition">
                            <i class="fa-solid fa-xmark mr-2"></i> Batal
                        </a>
                        <button type="submit"
                                class="flex items-center bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-lg shadow transition">
                            <i class="fa-solid fa-floppy-disk mr-2"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
