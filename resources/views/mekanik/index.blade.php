<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 flex items-center gap-2">
            {{-- Menambahkan icon mekanik --}}
            <i class="fa-solid fa-user-gear text-blue-600"></i>
            {{ ('Daftar Mekanik') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-2xl p-6 border border-gray-100">
                
                <div class="flex justify-between items-center mb-5">
                    <a href="{{ route('mekanik.create') }}" 
                        class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow transition duration-200">
                        <i class="fa-solid fa-plus mr-2"></i> Tambah Mekanik
                    </a>

                    <form method="GET" action="{{ route('mekanik.index') }}" class="flex gap-2 items-center">
                        <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Cari nama mekanik..."
                                class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring focus:ring-blue-200 focus:outline-none w-64">
                        
                        <button type="submit"
                                class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow transition duration-200">
                            <i class="fa-solid fa-search mr-2"></i> Cari
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
                    <table class="min-w-full border border-gray-200 text-sm rounded-lg overflow-hidden">
                        <thead class="bg-blue-50 text-blue-800 uppercase text-xs">
                            <tr>
                                <th class="px-4 py-3 text-left">No</th>
                                <th class="px-4 py-3 text-left">Nama</th>
                                <th class="px-4 py-3 text-left">Jabatan</th>
                                <th class="px-4 py-3 text-left">Teknisi</th>
                                <th class="px-4 py-3 text-left">Telepon</th>
                                <th class="px-4 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($mekaniks as $mekanik)
                                <tr class="hover:bg-blue-50 transition">
                                    <td class="px-4 py-2">{{ $loop->iteration + ($mekaniks->currentPage() - 1) * $mekaniks->perPage() }}</td>
                                    <td class="px-4 py-2 font-semibold text-gray-800">{{ $mekanik->nama }}</td>
                                    {{-- Mengubah huruf pertama menjadi kapital --}}
                                    <td class="px-4 py-2">{{ ucfirst($mekanik->jabatan) }}</td>
                                    <td class="px-4 py-2">{{ ucfirst($mekanik->teknisi) }}</td>
                                    <td class="px-4 py-2">{{ $mekanik->telp }}</td>
                                    <td class="px-4 py-2 text-center">
                                        <div class="flex justify-center gap-2">
                                            <a href="{{ route('mekanik.edit', $mekanik->id) }}" 
                                               class="bg-green-600 hover:bg-green-700 text-white px-3 py-1.5 rounded-md text-xs font-medium shadow transition flex items-center gap-1">
                                                <i class="fa-solid fa-pen-to-square"></i> Edit
                                            </a>

                                            <form action="{{ route('mekanik.destroy', $mekanik->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        onclick="return confirm('Yakin ingin menghapus data mekanik {{ $mekanik->nama }}?')" 
                                                        class="bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded-md text-xs font-medium shadow transition flex items-center gap-1">
                                                    <i class="fa-solid fa-trash"></i> Hapus
                                                </button>
                                            </form>
                                            
                                            <a href="{{ route('mekanik.report', $mekanik->id) }}" target="_blank"
                                               class="bg-gray-700 hover:bg-gray-800 text-white px-3 py-1.5 rounded-md text-xs font-medium shadow transition flex items-center gap-1">
                                                <i class="fa-solid fa-print"></i> Cetak
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-3 text-center text-gray-500 italic">
                                        <i class="fa-solid fa-circle-info mr-1"></i> Belum ada data Mekanik
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-6">
                    {{ $mekaniks->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>

