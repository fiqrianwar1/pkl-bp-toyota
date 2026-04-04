<?php

namespace App\Http\Controllers;

use App\Models\Sparepart;
use App\Models\Spk;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB; // WAJIB
use Exception; // WAJIB

class SparepartController extends Controller
{
    // List Panel Body dan Harga Default
    private function getPanels()
    {
        return [
            'Bumper FRT' => 850000, 
            'Bumper RR' => 850000,
            'Bodykit FRT' => 700000, 
            'Bodykit RR' => 700000, 
            'Pintu Depan RH' => 950000, 
            'Pintu Depan LH' => 950000,
            'Pintu Belakang RH' => 950000, 
            'Pintu Belakang LH' => 950000, 
            'Kap Mesin' => 1200000, 
            'Fender RH' => 750000, 
            'Fender LH' => 750000, 
            'Triplank RH' => 400000, 
            'Triplank LH' => 400000, 
            'Quarter RH' => 1100000,
            'Quarter LH' => 1100000, 
            'Roof' => 1500000, 
            'Pintu Bagasi' => 1250000
        ];
    }
    
    // List Sparepart dan Harga Default
    private function getHargaSparepart()
    {
        return [
            'Oli Mesin 10W-40' => 450000,
            'Filter Oli Toyota' => 120000,
            'Busi NGK (set)' => 250000,
            'Kampas Rem Depan' => 600000,
        ];
    }
    
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Sparepart::select('spk_id', \DB::raw('SUM(total_harga) as total_harga_gabungan'))
            ->groupBy('spk_id')
            ->with(['spk' => function($q) {
                $q->with('customer', 'spareparts');
            }]);

        if ($search) {
            $query->whereHas('spk', function($q) use ($search) {
                $q->where('no_spk', 'like', '%' . $search . '%')
                  ->orWhereHas('customer', function($qc) use ($search) {
                      $qc->where('nama', 'like', '%' . $search . '%');
                  });
            });
        }
        
        $spareparts = $query->orderBy('spk_id', 'desc')->paginate(10);
        
        return view('sparepart.index', compact('spareparts'));
    }

    public function show($spk_id) 
    {
        // Logika show untuk modal detail tetap sama
        $spk = Spk::with('customer')->findOrFail($spk_id);
        $details = Sparepart::where('spk_id', $spk_id)->get();
        $total_gabungan = $details->sum('total_harga');

        return response()->json([
            'no_spk' => $spk->no_spk,
            'customer' => $spk->customer->nama ?? '-',
            'total_gabungan' => 'Rp ' . number_format($total_gabungan, 0, ',', '.'),
            'details' => $details->map(function ($item) {
                return [
                    'id' => $item->id,
                    'nama_sparepart' => $item->nama_sparepart,
                    'jumlah' => $item->jumlah,
                    'harga_satuan' => $item->getHargaSatuanRupiahAttribute(), 
                    'total_harga' => $item->getTotalHargaRupiahAttribute(), 
                ];
            })
        ]);
    }


    public function create()
    {
        $spks = Spk::with('customer')->get();
        $panels = $this->getPanels(); 
        $hargaSparepart = $this->getHargaSparepart();
        
        return view('sparepart.create', compact('spks', 'panels', 'hargaSparepart'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'spk_id' => 'required|exists:spks,id',
            'nama_sparepart' => 'required|array',
            'nama_sparepart.*' => 'string|max:255',
            'jumlah' => 'required|array',
            'jumlah.*' => 'integer|min:1',
            'harga_satuan' => 'required|array',
            'harga_satuan.*' => 'integer|min:0',
            'tgl_estimasi_datang' => 'nullable|date',
            'lokasi' => 'nullable|string|max:255',
        ]);

        foreach ($request->nama_sparepart as $index => $nama) {
            if (empty($nama)) continue; 
            
            $jumlah = $request->jumlah[$index] ?? 1;
            $harga = $request->harga_satuan[$index] ?? 0;
            $total = (int)$jumlah * (int)$harga;

            Sparepart::create([
                'spk_id' => $request->spk_id,
                'nama_sparepart' => $nama,
                'jumlah' => $jumlah,
                'harga_satuan' => $harga,
                'total_harga' => $total,
                'tgl_estimasi_datang' => $request->tgl_estimasi_datang,
                'lokasi' => $request->lokasi,
            ]);
        }

        return redirect()->route('sparepart.index')->with('success', 'Data sparepart berhasil ditambahkan.');
    }

    /**
     * Form edit MULTI-ITEM berdasarkan SPK ID
     */
    public function edit($spk_id) 
    {
        // Mengambil SEMUA item sparepart untuk SPK ini
        $spareparts = Sparepart::where('spk_id', $spk_id)->get(); 
        
        // Mengambil data utama SPK untuk header/input field dasar
        $spk = Spk::with('customer')->findOrFail($spk_id);
        $spks = Spk::with('customer')->get(); // List SPK untuk dropdown
        
        // Mengirim data lists untuk Blade
        $panels = $this->getPanels(); 
        $hargaSparepart = $this->getHargaSparepart(); 
        $allSpareparts = array_merge($panels, $hargaSparepart);

        // Kirim $spareparts (jamak) dan $spk (tunggal)
        return view('sparepart.edit', compact('spareparts', 'spk', 'spks', 'panels', 'hargaSparepart', 'allSpareparts'));
    }

    /**
     * Update MULTI-ITEM berdasarkan SPK ID
     */
    public function update(Request $request, $spk_id) 
    {
        $request->validate([
            'spk_id' => 'required|exists:spks,id', 
            'nama_sparepart' => 'required|array',
            'nama_sparepart.*' => 'string|max:255',
            'jumlah' => 'required|array',
            'jumlah.*' => 'integer|min:1',
            'harga_satuan' => 'required|array',
            'harga_satuan.*' => 'integer|min:0',
            'tgl_estimasi_datang' => 'nullable|date',
            'lokasi' => 'nullable|string|max:255',
        ]);

        // 1. HAPUS SEMUA item lama untuk SPK ini
        Sparepart::where('spk_id', $spk_id)->delete(); 

        // 2. Simpan item baru (Logika sama seperti store)
        foreach ($request->nama_sparepart as $index => $nama) {
            if (empty($nama)) continue; 
            
            $jumlah = $request->jumlah[$index] ?? 1;
            $harga = $request->harga_satuan[$index] ?? 0;
            $total = (int)$jumlah * (int)$harga;

            Sparepart::create([
                'spk_id' => $spk_id, // Menggunakan $spk_id dari URL
                'nama_sparepart' => $nama,
                'jumlah' => $jumlah,
                'harga_satuan' => $harga,
                'total_harga' => $total,
                'tgl_estimasi_datang' => $request->tgl_estimasi_datang,
                'lokasi' => $request->lokasi,
            ]);
        }

        $spk = Spk::findOrFail($spk_id);
        return redirect()->route('sparepart.index')->with('success', 'Semua item sparepart untuk SPK ' . $spk->no_spk . ' berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $sparepart = Sparepart::findOrFail($id);
        $sparepart->delete();

        return redirect()->route('sparepart.index')->with('success', 'Data sparepart berhasil dihapus.');
    }

    public function report(Request $request)
    {
        $spk_id = $request->query('id_spk');
        $item_id = $request->query('item_id'); 

        if ($spk_id) {
            $spareparts = Sparepart::with('spk.customer')->where('spk_id', $spk_id)->orderBy('created_at', 'asc')->get();
        } elseif ($item_id) {
            $spareparts = Sparepart::with('spk.customer')->where('id', $item_id)->get();
        } else {
            $spareparts = Sparepart::with('spk.customer')->orderBy('created_at', 'desc')->get();
        }
        
        return view('sparepart.report', compact('spareparts'));
    }
}