<?php

namespace App\Http\Controllers;

use App\Models\Paint; // 🔥 Ganti ke Paint
use App\Models\Mekanik;
use App\Models\Spk;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Exception;

class PaintController extends Controller
{
    /**
     * Display a listing of the resource.
     * (Sudah ada Search & Paginate)
     */
    public function index(Request $request) 
    {
        $search = $request->input('search');

        $paints = Paint::with(['mekanik', 'spk']) // 🔥 Ganti ke Paint
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

        return view('paint.index', compact('paints')); // 🔥 Ganti ke paint.index
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Filter mekanik 'paint'
        $mekaniks = Mekanik::where('teknisi', 'paint')->get(); // 🔥 Ganti ke paint
        $spks = Spk::all(); 
        
        // 🔥 Daftar Bahan untuk PAINT (List #3 dari kamu)
        $daftar_bahan = [
            'Cat (Wanda)',
            'Cat (Sikkens)',
            'Clear Coat (Wanda 2:1)',
            'Clear Coat (Wanda 4:1)',
            'Clear Coat (Sikkens)',
            'Hardener (P25)',
            'Hardener (Wanda Standart)',
            'Thiner (Medium Wanda)',
            'Thiner Cuci (Cemerlang)',
            'Dgreser (M600)',
            'Majun',
            'Kimteck',
            'Tack Clote',
            'Masking',
            'Isolasi (nasuha)',
        ];

        return view('paint.create', compact('mekaniks', 'spks', 'daftar_bahan')); // 🔥 Ganti ke paint.create
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
            
            // Validasi untuk dynamic row bahan
            'nama_bahan' => 'nullable|array', // Diubah jadi nullable, mungkin ada yg 0 bahan
            'qty_bahan' => 'nullable|array',
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
        
        Paint::create($dataToStore); // 🔥 Ganti ke Paint

        return redirect()->route('paint.index')->with('success', 'Data Paint berhasil ditambahkan'); // 🔥 Ganti ke paint.index
    }

    /**
     * Mengambil detail JSON untuk modal.
     * (Menggunakan Route Model Binding: Paint $paint)
     */
    public function show(Paint $paint) // 🔥 Ganti ke Paint
    {
        try {
            // $paint sudah otomatis di-load, tapi kita load relasinya
            $paint->loadMissing(['mekanik', 'spk']); 
            
            $bahan_array = $paint->bahan ?? [];
            $bahan_string = collect($bahan_array)->map(function ($item) {
                return ucfirst($item['nama_bahan'] ?? '-') . ' (' . ($item['qty'] ?? 0) . ')';
            })->implode(', ');
            
            if (empty(trim($bahan_string))) {
                $bahan_string = '-';
            }

            return response()->json([
                'id' => $paint->id,
                'no_spk' => $paint->spk->no_spk ?? '-',
                'mekanik' => $paint->mekanik->nama ?? '-',
                'tanggal' => $paint->tanggal ? $paint->tanggal->translatedFormat('d F Y') : '-',
                'jam_mulai' => $paint->jam_mulai ? \Carbon\Carbon::parse($paint->jam_mulai)->format('H:i') : '-',
                'jam_selesai' => $paint->jam_selesai ? \Carbon\Carbon::parse($paint->jam_selesai)->format('H:i') : '-',
                'status' => ucfirst($paint->status),
                'bahan' => $bahan_string, 
            ]);

        } catch (Exception $e) {
            return response()->json(['error' => 'Internal Server Error: ' . $e->getMessage()], 500); 
        }
    }

    /**
     * Show the form for editing the specified resource.
     * (Menggunakan Route Model Binding: Paint $paint)
     */
    public function edit(Paint $paint) // 🔥 Ganti ke Paint
    {
        $mekaniks = Mekanik::where('teknisi', 'paint') // 🔥 Ganti ke paint
                            ->orWhere('id', $paint->mekanik_id)
                            ->get();
        $spks = Spk::all(); 

        // 🔥 Daftar Bahan untuk PAINT (Sama kayak di create)
        $daftar_bahan = [
            'Cat (Wanda)',
            'Cat (Sikkens)',
            'Clear Coat (Wanda 2:1)',
            'Clear Coat (Wanda 4:1)',
            'Clear Coat (Sikkens)',
            'Hardener (P25)',
            'Hardener (Wanda Standart)',
            'Thiner (Medium Wanda)',
            'Thiner Cuci (Cemerlang)',
            'Dgreser (M600)',
            'Majun',
            'Kimteck',
            'Tack Clote',
            'Masking',
            'Isolasi (nasuha)',
        ];

        $bahan_tersimpan = $paint->bahan ?? []; 

        return view('paint.edit', compact('paint', 'mekaniks', 'spks', 'daftar_bahan', 'bahan_tersimpan')); // 🔥 Ganti ke paint.edit
    }

    /**
     * Update the specified resource in storage.
     * (Menggunakan Route Model Binding: Paint $paint)
     */
    public function update(Request $request, Paint $paint) // 🔥 Ganti ke Paint
    {
        $validated = $request->validate([
            'mekanik_id' => 'required|exists:mekaniks,id',
            'spk_id' => 'required|exists:spks,id',
            'tanggal' => 'required|date',
            'jam_mulai' => 'nullable|date_format:H:i',
            'jam_selesai' => 'nullable|date_format:H:i|after_or_equal:jam_mulai',
            'status' => 'required|in:Antri,Proses,Selesai',
            
            // Validasi untuk dynamic row bahan
            'nama_bahan' => 'nullable|array', // Diubah jadi nullable
            'qty_bahan' => 'nullable|array',
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

        $paint->update($dataToUpdate); // 🔥 Ganti ke Paint

        return redirect()->route('paint.index')->with('success', 'Data Paint berhasil diperbarui'); // 🔥 Ganti ke paint.index
    }

    /**
     * Remove the specified resource from storage.
     * (Menggunakan Route Model Binding: Paint $paint)
     */
    public function destroy(Paint $paint) // 🔥 Ganti ke Paint
    {
        $paint->delete();
        return redirect()->route('paint.index')->with('success', 'Data Paint berhasil dihapus'); // 🔥 Ganti ke paint.index
    }

    /**
     * Generate a report for a single Body entry.
     * (Menggunakan ID biasa, $id)
     */
    public function report($id) 
    {
        // 🔥 Cari data Paint berdasarkan ID
        $paint = Paint::with(['mekanik', 'spk.customer'])->findOrFail($id); 
        
        // 🔥 BARU: Cari Forman & Leader untuk departemen 'paint'
        $forman = \App\Models\Mekanik::where('jabatan', 'forman')
                                      ->where('teknisi', 'paint')
                                      ->first();
        
        $leader = \App\Models\Mekanik::where('jabatan', 'leader')
                                      ->where('teknisi', 'paint')
                                      ->first();
                                      
        // 🔥🔥 INI YANG DIBENERIN: Kirim $forman dan $leader ke view
        return view('paint.report', compact('paint', 'forman', 'leader')); 
    }
}

