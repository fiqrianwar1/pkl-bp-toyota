<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 flex items-center gap-2">
            {{-- Mengubah icon ke biru --}}
            <i class="fa-solid fa-users text-blue-600"></i>
            {{ ('Daftar Customers') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-2xl p-6 border border-gray-100">
                
                <div class="flex justify-between items-center mb-5">
                    <a href="{{ route('customers.create') }}" 
                        class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow transition duration-200">
                        <i class="fa-solid fa-plus mr-2"></i> Tambah Customer
                    </a>

                    <form method="GET" action="{{ route('customers.index') }}" class="flex gap-2 items-center">
                        <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Cari nama customer..."
                                class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring focus:ring-blue-200 focus:outline-none w-64">
                        
                        <button type="submit"
                                class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow transition duration-200">
                            <i class="fa-solid fa-search mr-2"></i> Cari Customer
                        </button>
                    </form>
                </div>

                @if(session('success'))
                    <div class="bg-green-100 text-green-700 border border-green-300 px-4 py-3 rounded-lg mb-4 flex items-center">
                        <i class="fa-solid fa-circle-check mr-2"></i>
                        {{ session('success') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    {{-- PERBAIKAN: Menggunakan styling seperti tabel SPK --}}
                    <table class="min-w-full border border-gray-200 text-sm rounded-lg overflow-hidden">
                        {{-- PERBAIKAN: Menggunakan warna header biru --}}
                        <thead class="bg-blue-50 text-blue-800 uppercase text-xs">
                            <tr>
                                <th class="px-4 py-3 text-left">No</th>
                                <th class="px-4 py-3 text-left">Nama</th>
                                <th class="px-4 py-3 text-left">Alamat</th>
                                <th class="px-4 py-3 text-left">Telepon</th>
                                <th class="px-4 py-3 text-left">Email</th>
                                <th class="px-4 py-3 text-left">Jenis Kelamin</th>
                                <th class="px-4 py-3 text-left">Tanggal Estimasi</th>
                                <th class="px-4 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($customers as $customer)
                                <tr class="hover:bg-blue-50 transition">
                                    <td class="px-4 py-2">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-2 font-semibold text-gray-800">{{ $customer->nama }}</td>
                                    <td class="px-4 py-2">{{ $customer->alamat }}</td>
                                    <td class="px-4 py-2">{{ $customer->telp }}</td>
                                    <td class="px-4 py-2">{{ $customer->email }}</td>
                                    <td class="px-4 py-2">{{ $customer->jenis_kelamin }}</td>
                                    <td class="px-4 py-2">{{ \Carbon\Carbon::parse($customer->tanggal_estimasi)->translatedFormat('d M Y') }}</td>
                                    <td class="px-4 py-2 text-center">
                                        <div class="flex justify-center gap-2">
                                            <a href="{{ route('customers.edit', $customer->id) }}" 
                                               class="bg-green-600 hover:bg-green-700 text-white px-3 py-1.5 rounded-md text-xs font-medium shadow transition flex items-center gap-1">
                                                <i class="fa-solid fa-pen-to-square"></i> Edit
                                            </a>

                                            <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        onclick="return confirm('Yakin ingin menghapus data customer {{ $customer->nama }}?')" 
                                                        class="bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded-md text-xs font-medium shadow transition flex items-center gap-1">
                                                    <i class="fa-solid fa-trash"></i> Hapus
                                                </button>
                                            </form>

                                            <a href="{{ route('customers.report', $customer->id) }}" target="_blank"
                                               class="bg-gray-700 hover:bg-gray-800 text-white px-3 py-1.5 rounded-md text-xs font-medium shadow transition flex items-center gap-1">
                                                <i class="fa-solid fa-print"></i> Cetak
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-4 py-3 text-center text-gray-500 italic">
                                        <i class="fa-solid fa-circle-info mr-1"></i> Belum ada data Customer
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>