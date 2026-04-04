<?php

namespace App\Http\Controllers;

use App\Models\Preparation; // 🔥 Ganti ke Preparation
use App\Models\Mekanik;
use App\Models\Spk;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Exception;

class PreparationController extends Controller
{
    /**
     * Display a listing of the resource.
     * (Sudah ada Search & Paginate)
     */
    public function index(Request $request) 
    {
        $search = $request->input('search');

        $preparations = Preparation::with(['mekanik', 'spk']) // 🔥 Ganti ke Preparation
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

        return view('preparation.index', compact('preparations')); // 🔥 Ganti ke preparation.index
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Filter mekanik 'preparation'
        $mekaniks = Mekanik::where('teknisi', 'preparation')->get(); // 🔥 Ganti ke preparation
        $spks = Spk::all(); 
        
        // 🔥 Daftar Bahan untuk PREPARATION (List #2 dari kamu)
        $daftar_bahan = [
            'Amplas Kering 3M (80)',
            'Amplas Kering 3M (120)',
            'Amplas Basah Nikken P(120)',
            'Amplas Basah Nikken P(240)',
            'Amplas Basah Nikken P(320)',
            'Amplas Basah Nikken P(400)',
            'Amplas Basah Nikken P(500)',
            'Amplas Basah Nikken P(1000)',
            'Amplas Basah Nikken P(1500)',
            'Amplas Basah Nikken P(2000)',
            'Dempul (Sikkens)',
            'Dgreser (M600)',
            'Majun',
            'Efoxy (Filler Pro Max Sikkens)',
            'Hardener (P25)',
            'Thiner (Medium Wanda)',
            'Masking',
            'Isolasi (nasuha)',
        ];

        return view('preparation.create', compact('mekaniks', 'spks', 'daftar_bahan')); // 🔥 Ganti ke preparation.create
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
            'nama_bahan' => 'required|array',
            'qty_bahan' => 'required|array',
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
        
        Preparation::create($dataToStore); // 🔥 Ganti ke Preparation

        return redirect()->route('preparation.index')->with('success', 'Data Preparation berhasil ditambahkan'); // 🔥 Ganti ke preparation.index
    }

    /**
     * Mengambil detail JSON untuk modal.
     */
    public function show(Preparation $preparation) // 🔥 Ganti ke Preparation
    {
        try {
            $preparation->load(['mekanik', 'spk']);
            
            $bahan_array = $preparation->bahan ?? [];
            $bahan_string = collect($bahan_array)->map(function ($item) {
                return ucfirst($item['nama_bahan'] ?? '-') . ' (' . ($item['qty'] ?? 0) . ')';
            })->implode(', ');
            
            if (empty($bahan_string)) {
                $bahan_string = '-';
            }

            return response()->json([
                'id' => $preparation->id,
                'no_spk' => $preparation->spk->no_spk ?? '-',
                'mekanik' => $preparation->mekanik->nama ?? '-',
                'tanggal' => $preparation->tanggal ? Carbon::parse($preparation->tanggal)->translatedFormat('d F Y') : '-',
                'jam_mulai' => $preparation->jam_mulai ? Carbon::parse($preparation->jam_mulai)->format('H:i') : '-',
                'jam_selesai' => $preparation->jam_selesai ? Carbon::parse($preparation->jam_selesai)->format('H:i') : '-',
                'status' => ucfirst($preparation->status),
                'bahan' => $bahan_string, 
            ]);

        } catch (Exception $e) {
            return response()->json(['error' => 'Internal Server Error: ' . $e->getMessage()], 500); 
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Preparation $preparation) // 🔥 Ganti ke Preparation
    {
        $mekaniks = Mekanik::where('teknisi', 'preparation') // 🔥 Ganti ke preparation
                            ->orWhere('id', $preparation->mekanik_id)
                            ->get();
        $spks = Spk::all(); 

        // 🔥 Daftar Bahan untuk PREPARATION (Sama kayak di create)
        $daftar_bahan = [
            'Amplas Kering 3M (80)',
            'Amplas Kering 3M (120)',
            'Amplas Basah Nikken P(120)',
            'Amplas Basah Nikken P(240)',
            'Amplas Basah Nikken P(320)',
            'Amplas Basah Nikken P(400)',
            'Amplas Basah Nikken P(500)',
            'Amplas Basah Nikken P(1000)',
            'Amplas Basah Nikken P(1500)',
            'Amplas Basah Nikken P(2000)',
            'Dempul (Sikkens)',
            'Dgreser (M600)',
            'Majun',
            'Efoxy (Filler Pro Max Sikkens)',
            'Hardener (P25)',
            'Thiner (Medium Wanda)',
            'Masking',
            'Isolasi (nasuha)',
        ];

        $bahan_tersimpan = $preparation->bahan ?? []; 

        return view('preparation.edit', compact('preparation', 'mekaniks', 'spks', 'daftar_bahan', 'bahan_tersimpan')); // 🔥 Ganti ke preparation.edit
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Preparation $preparation) // 🔥 Ganti ke Preparation
    {
        $validated = $request->validate([
            'mekanik_id' => 'required|exists:mekaniks,id',
            'spk_id' => 'required|exists:spks,id',
            'tanggal' => 'required|date',
            'jam_mulai' => 'nullable|date_format:H:i',
            'jam_selesai' => 'nullable|date_format:H:i|after_or_equal:jam_mulai',
            'status' => 'required|in:Antri,Proses,Selesai',
            'nama_bahan' => 'required|array',
            'qty_bahan' => 'required|array',
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

        $preparation->update($dataToUpdate); // 🔥 Ganti ke Preparation

        return redirect()->route('preparation.index')->with('success', 'Data Preparation berhasil diperbarui'); // 🔥 Ganti ke preparation.index
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Preparation $preparation) // 🔥 Ganti ke Preparation
    {
        $preparation->delete();
        return redirect()->route('preparation.index')->with('success', 'Data Preparation berhasil dihapus'); // 🔥 Ganti ke preparation.index
    }

    /**
     * Generate a report for a single Body entry.
     */
    // 🔥 DIUBAH: Ganti dari (Preparation $preparation) ke ($id)
    public function report($id) 
    {
        // 🔥 DIUBAH: Cari data berdasarkan ID, sama kayak preparationController
        $preparation = Preparation::with(['mekanik', 'spk.customer'])->findOrFail($id); 

        // 🔥 BARU: Cari Forman & Leader untuk departemen 'preparation'
        $forman = \App\Models\Mekanik::where('jabatan', 'forman')
                                      ->where('teknisi', 'preparation')
                                      ->first();
        
        $leader = \App\Models\Mekanik::where('jabatan', 'leader')
                                      ->where('teknisi', 'preparation')
                                      ->first();
                                      
        // 🔥 BARU: Kirim $forman dan $leader ke view
        return view('preparation.report', compact('preparation', 'forman', 'leader')); // 🔥 Ganti ke preparation.report
    }
}

