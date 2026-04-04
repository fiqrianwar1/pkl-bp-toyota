<?php

namespace App\Http\Controllers;

use App\Models\Poles; // 🔥 Ganti ke Poles
use App\Models\Mekanik;
use App\Models\Spk;
use Illuminate\Http\Request;
use Carbon\Carbon; // 🔥 Ditambahkan
use Exception; // 🔥 Ditambahkan

class PolesController extends Controller
{
    /**
     * Display a listing of the resource.
     * (Sudah ada Search & Paginate)
     */
    public function index(Request $request) 
    {
        $search = $request->input('search');

        $poles = Poles::with(['mekanik', 'spk']) // 🔥 Ganti ke Poles
            ->when($search, function ($query, $search) {
                $query->whereHas('spk', function ($q) use ($search) {
                    $q->where('no_spk', 'like', "%{$search}%");
                })
                ->orWhereHas('mekanik', function ($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%");
                });
            })
            ->latest() 
            ->paginate(10); 

        return view('poles.index', compact('poles')); // 🔥 Ganti ke poles.index
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Filter mekanik 'poles'
        $mekaniks = Mekanik::where('teknisi', 'poles')->get(); // 🔥 Ganti ke poles
        $spks = Spk::all(); 
        
        // 🔥 Daftar Bahan untuk POLES (List #4 dari kamu)
        $daftar_bahan = [
            'Amplas Basah Nikken P(1000)',
            'Amplas Basah Nikken P(1500)',
            'Amplas Basah Nikken P(2000)',
            'Compound (3M)',
            'Wax (3M Premium Wax)',
            'Dgreser (M600)',
            'Majun',
        ];

        return view('poles.create', compact('mekaniks', 'spks', 'daftar_bahan')); // 🔥 Ganti ke poles.create
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'mekanik_id' => 'required|exists:mekaniks,id',
            'spk_id' => 'required|exists:spks,id', 
            'tanggal' => 'required|date',
            'jam_mulai' => 'nullable|date_format:H:i',
            'jam_selesai' => 'nullable|date_format:H:i|after_or_equal:jam_mulai',
            'status' => 'required|in:Antri,Proses,Selesai',
            'nama_bahan' => 'nullable|array', // Diubah jadi nullable
            'qty_bahan' => 'nullable|array', // Diubah jadi nullable
            'nama_bahan.*' => 'required|string',
            'qty_bahan.*' => 'required|numeric|min:1',
        ]);

        $bahanData = [];
        if (isset($validated['nama_bahan'])) {
            foreach ($validated['nama_bahan'] as $index => $nama) {
                if (isset($validated['qty_bahan'][$index])) {
                    $bahanData[] = [
                        'nama_bahan' => $nama,
                        'qty' => (int)$validated['qty_bahan'][$index],
                    ];
                }
            }
        }

        $dataToStore = collect($validated)->except(['nama_bahan', 'qty_bahan'])->toArray();
        $dataToStore['bahan'] = $bahanData; 
        
        Poles::create($dataToStore); // 🔥 Ganti ke Poles

        return redirect()->route('poles.index')->with('success', 'Data Poles berhasil ditambahkan'); // 🔥 Ganti ke poles.index
    }

    /**
     * 🔥 METHOD BARU
     * Mengambil detail JSON untuk modal.
     * Note: Parameter {pole} (singular) akan otomatis dicari oleh Laravel (Route Model Binding)
     */
    public function show(Poles $pole) // 🔥 Ganti ke Poles
    {
        try {
            $pole->loadMissing(['mekanik', 'spk']); // 🔥 Ganti ke $pole
            
            $bahan_array = $pole->bahan ?? []; // 🔥 Ganti ke $pole
            $bahan_string = collect($bahan_array)->map(function ($item) {
                return ucfirst($item['nama_bahan'] ?? '-') . ' (' . ($item['qty'] ?? 0) . ')';
            })->implode(', ');
            
            if (empty(trim($bahan_string))) {
                $bahan_string = '-';
            }

            return response()->json([
                'id' => $pole->id, // 🔥 Ganti ke $pole
                'no_spk' => $pole->spk->no_spk ?? '-',
                'mekanik' => $pole->mekanik->nama ?? '-',
                'tanggal' => $pole->tanggal ? $pole->tanggal->translatedFormat('d F Y') : '-',
                'jam_mulai' => $pole->jam_mulai ? \Carbon\Carbon::parse($pole->jam_mulai)->format('H:i') : '-',
                'jam_selesai' => $pole->jam_selesai ? \Carbon\Carbon::parse($pole->jam_selesai)->format('H:i') : '-',
                'status' => ucfirst($pole->status),
                'bahan' => $bahan_string, 
            ]);

        } catch (Exception $e) {
            return response()->json(['error' => 'Internal Server Error: ' . $e->getMessage()], 500); 
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Poles $pole) // 🔥 Ganti ke Poles $pole
    {
        $mekaniks = Mekanik::where('teknisi', 'poles') // 🔥 Ganti ke poles
                            ->orWhere('id', $pole->mekanik_id) // 🔥 Ganti ke $pole
                            ->get();
        $spks = Spk::all(); 

        // 🔥 Daftar Bahan untuk POLES (Sama kayak di create)
        $daftar_bahan = [
            'Amplas Basah Nikken P(1000)',
            'Amplas Basah Nikken P(1500)',
            'Amplas Basah Nikken P(2000)',
            'Compound (3M)',
            'Wax (3M Premium Wax)',
            'Dgreser (M600)',
            'Majun',
        ];

        $bahan_tersimpan = $pole->bahan ?? [];  // 🔥 Ganti ke $pole

        return view('poles.edit', compact('pole', 'mekaniks', 'spks', 'daftar_bahan', 'bahan_tersimpan')); // 🔥 Ganti ke poles.edit
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Poles $pole) // 🔥 Ganti ke Poles $pole
    {
        $validated = $request->validate([
            'mekanik_id' => 'required|exists:mekaniks,id',
            'spk_id' => 'required|exists:spks,id',
            'tanggal' => 'required|date',
            'jam_mulai' => 'nullable|date_format:H:i',
            'jam_selesai' => 'nullable|date_format:H:i|after_or_equal:jam_mulai',
            'status' => 'required|in:Antri,Proses,Selesai',
            'nama_bahan' => 'nullable|array', // Diubah jadi nullable
            'qty_bahan' => 'nullable|array', // Diubah jadi nullable
            'nama_bahan.*' => 'required|string',
            'qty_bahan.*' => 'required|numeric|min:1',
        ]);

        $bahanData = [];
        if (isset($validated['nama_bahan'])) {
             foreach ($validated['nama_bahan'] as $index => $nama) {
                if (isset($validated['qty_bahan'][$index])) {
                    $bahanData[] = [
                        'nama_bahan' => $nama,
                        'qty' => (int)$validated['qty_bahan'][$index],
                    ];
                }
            }
        }
       
        $dataToUpdate = collect($validated)->except(['nama_bahan', 'qty_bahan'])->toArray();
        $dataToUpdate['bahan'] = $bahanData; 

        $pole->update($dataToUpdate); // 🔥 Ganti ke $pole

        return redirect()->route('poles.index')->with('success', 'Data Poles berhasil diperbarui'); // 🔥 Ganti ke poles.index
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Poles $pole) // 🔥 Ganti ke Poles $pole
    {
        $pole->delete();
        return redirect()->route('poles.index')->with('success', 'Data Poles berhasil dihapus'); // 🔥 Ganti ke poles.index
    }

    /**
     * Generate a report for a single Body entry.
     */
    // 🔥 Diubah jadi report($id)
    public function report($id) 
    {
        // 🔥 Cari data Poles berdasarkan ID
        $poles_item = Poles::with(['mekanik', 'spk.customer'])->findOrFail($id); 
        
        // 🔥 BARU: Cari Forman & Leader untuk departemen 'poles'
        $forman = \App\Models\Mekanik::where('jabatan', 'forman')
                                      ->where('teknisi', 'poles')
                                      ->first();
        
        $leader = \App\Models\Mekanik::where('jabatan', 'leader')
                                      ->where('teknisi', 'poles')
                                      ->first();

        // 🔥 BARU: Kirim $forman dan $leader ke view
        // (Menggunakan $poles_item agar tidak bentrok dengan nama Model 'Poles')
        return view('poles.report', compact('poles_item', 'forman', 'leader')); // 🔥 Ganti ke poles.report
    }
}
