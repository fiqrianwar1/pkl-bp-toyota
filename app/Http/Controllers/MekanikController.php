<?php

namespace App\Http\Controllers;

use App\Models\Mekanik;
use Illuminate\Http\Request;

class MekanikController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Menggunakan 'when' untuk query pencarian kondisional dan paginate untuk membatasi data per halaman
        $mekaniks = Mekanik::when($search, function ($query, $search) {
                return $query->where('nama', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10); // Menampilkan 10 data per halaman

        return view('mekanik.index', compact('mekaniks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('mekanik.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string',
            'teknisi' => 'required|string',
            'telp' => 'nullable|string|max:15', // Telepon bisa jadi tidak wajib
        ]);

        // Membuat data mekanik baru
        Mekanik::create($request->all());

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('mekanik.index')->with('success', 'Mekanik baru berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mekanik $mekanik)
    {
        return view('mekanik.edit', compact('mekanik'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mekanik $mekanik)
    {
        // Validasi input dari form
        $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string',
            'teknisi' => 'required|string',
            'telp' => 'nullable|string|max:15',
        ]);

        // Memperbarui data mekanik
        $mekanik->update($request->all());
        
        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('mekanik.index')->with('success', 'Data mekanik berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mekanik $mekanik)
    {
        // Menghapus data mekanik
        $mekanik->delete();

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('mekanik.index')->with('success', 'Data mekanik berhasil dihapus!');
    }

    /**
     * Generate a report for a single mechanic.
     */
     public function report($id)
    {
        // INI FUNGSI YANG BENAR
        $mekanik = Mekanik::findOrFail($id);
        return view('mekanik.report', compact('mekanik'));
    }
}

