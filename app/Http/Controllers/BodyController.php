<?php

namespace App\Http\Controllers;

use App\Models\Body;
use App\Models\Mekanik;
use App\Models\Spk;
use Illuminate\Http\Request;
use Carbon\Carbon; // 🔥 DITAMBAHKAN
use Exception; // 🔥 DITAMBAHKAN

class BodyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) 
    {
        $search = $request->input('search');

        $bodies = Body::with(['mekanik', 'spk'])
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

        return view('body.index', compact('bodies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $mekaniks = Mekanik::where('teknisi', 'body')->get();
        $spks = Spk::all(); 
        
        // Daftar Bahan untuk Body
        $daftar_bahan = [
            'Siller Body', 
            'Siller Kaca', 
            'Amplas Kering 3M (80)',
            'Amplas Kering 3M (120)', 
            'Dgreser (M600)', 
            'Majun', 
            'Double Tipe (3M)', 
            'Isolasi (nasuha)',
            // Tambahkan bahan lain jika perlu
        ];

        return view('body.create', compact('mekaniks', 'spks', 'daftar_bahan')); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data utama
        $validated = $request->validate([
            'mekanik_id' => 'required|exists:mekaniks,id',
            'spk_id' => 'required|exists:spks,id', 
            'tanggal' => 'required|date',
            'jam_mulai' => 'nullable|date_format:H:i',
            'jam_selesai' => 'nullable|date_format:H:i|after_or_equal:jam_mulai',
            'status' => 'required|in:Antri,Proses,Selesai',
            
            // Validasi untuk dynamic row bahan
            'nama_bahan' => 'nullable|array',
            'qty_bahan' => 'nullable|array',
            'nama_bahan.*' => 'required|string',
            'qty_bahan.*' => 'required|numeric|min:1',
        ]);

        // Format data bahan menjadi array [{nama_bahan: ..., qty: ...}]
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

        // Gabungkan data utama dan data bahan
        $dataToStore = collect($validated)->except(['nama_bahan', 'qty_bahan'])->toArray();
        $dataToStore['bahan'] = $bahanData; // Simpan array bahan ke kolom 'bahan'
        
        // Simpan ke database
        Body::create($dataToStore);

        return redirect()->route('body.index')->with('success', 'Data Body berhasil ditambahkan');
    }

    /**
     * Mengambil detail Body dalam format JSON (untuk modal).
     */
    public function show(Body $body)
    {
        try {
            $body->loadMissing(['mekanik', 'spk']); // Load relasi jika belum
            
            // Format Bahan dari array [{nama_bahan: ..., qty: ...}] menjadi string
            $bahan_array = $body->bahan ?? [];
            $bahan_string = collect($bahan_array)->map(function ($item) {
                return ucfirst($item['nama_bahan'] ?? '-') . ' (' . ($item['qty'] ?? 0) . ')';
            })->implode(', ');
            
            if (empty(trim($bahan_string))) {
                $bahan_string = '-';
            }

            return response()->json([
                'id' => $body->id,
                'no_spk' => $body->spk->no_spk ?? '-',
                'mekanik' => $body->mekanik->nama ?? '-',
                'tanggal' => $body->tanggal ? $body->tanggal->translatedFormat('d F Y') : '-',
                'jam_mulai' => $body->jam_mulai ? \Carbon\Carbon::parse($body->jam_mulai)->format('H:i') : '-',
                'jam_selesai' => $body->jam_selesai ? \Carbon\Carbon::parse($body->jam_selesai)->format('H:i') : '-',
                'status' => ucfirst($body->status),
                'bahan' => $bahan_string, 
            ]);

        } catch (Exception $e) {
            return response()->json(['error' => 'Internal Server Error: ' . $e->getMessage()], 500); 
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Body $body)
    {
        $mekaniks = Mekanik::where('teknisi', 'body')
                            ->orWhere('id', $body->mekanik_id)
                            ->get();
        $spks = Spk::all(); 

        // Daftar Bahan untuk Body
        $daftar_bahan = [
            'Siller Body', 
            'Siller Kaca', 
            'Amplas Kering 3M (80)',
            'Amplas Kering 3M (120)', 
            'Dgreser (M600)', 
            'Majun', 
            'Double Tipe (3M)', 
            'Isolasi (nasuha)',
            // Tambahkan bahan lain jika perlu
        ];

        // Ambil data bahan yang sudah tersimpan untuk ditampilkan di form edit
        $bahan_tersimpan = $body->bahan ?? []; 

        return view('body.edit', compact('body', 'mekaniks', 'spks', 'daftar_bahan', 'bahan_tersimpan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Body $body)
    {
        // Validasi data utama
        $validated = $request->validate([
            'mekanik_id' => 'required|exists:mekaniks,id',
            'spk_id' => 'required|exists:spks,id',
            'tanggal' => 'required|date',
            'jam_mulai' => 'nullable|date_format:H:i',
            'jam_selesai' => 'nullable|date_format:H:i|after_or_equal:jam_mulai',
            'status' => 'required|in:Antri,Proses,Selesai',
            
            // Validasi untuk dynamic row bahan
            'nama_bahan' => 'nullable|array',
            'qty_bahan' => 'nullable|array',
            'nama_bahan.*' => 'required|string',
            'qty_bahan.*' => 'required|numeric|min:1',
        ]);

        // Format data bahan menjadi array [{nama_bahan: ..., qty: ...}]
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
       
        // Gabungkan data utama dan data bahan
        $dataToUpdate = collect($validated)->except(['nama_bahan', 'qty_bahan'])->toArray();
        $dataToUpdate['bahan'] = $bahanData; // Simpan array bahan ke kolom 'bahan'

        // Update ke database
        $body->update($dataToUpdate);

        return redirect()->route('body.index')->with('success', 'Data Body berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Body $body)
    {
        $body->delete();
        return redirect()->route('body.index')->with('success', 'Data Body berhasil dihapus');
    }

    /**
     * Generate a report for a single Body entry.
     */
    public function report($id)
    {
        $body = Body::with(['spk.customer', 'mekanik'])->findOrFail($id);
        
        // 🔥 BARU: Cari Forman & Leader untuk departemen 'body'
        $forman = \App\Models\Mekanik::where('jabatan', 'forman')
                                      ->where('teknisi', 'body')
                                      ->first();
        
        $leader = \App\Models\Mekanik::where('jabatan', 'leader')
                                      ->where('teknisi', 'body')
                                      ->first();
                                      
        // 🔥 BARU: Kirim $forman dan $leader ke view
        return view('body.report', compact('body', 'forman', 'leader'));
    }
}

