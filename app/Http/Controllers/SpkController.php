<?php

namespace App\Http\Controllers;

use App\Models\Spk;
use App\Models\Customer;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Exception; // Tambahkan ini untuk try-catch block

class SpkController extends Controller
{
    /**
     * Menampilkan daftar SPK dengan pencarian dan pagination.
     */
    public function index(Request $request) 
    {
        $search = $request->input('search');

        $spks = Spk::with('customer')
            ->when($search, function ($query, $search) {
                return $query->where('no_spk', 'like', "%{$search}%")
                    ->orWhereHas('customer', function ($q) use ($search) {
                        $q->where('nama', 'like', "%{$search}%");
                    });
            })
            ->latest()
            ->paginate(10); 

        return view('spk.index', compact('spks'));
    }

    /**
     * Menampilkan form tambah SPK.
     */
    public function create()
    {
        $customers = Customer::all();
        $no_spk = Spk::generateNoSpk(); 

        $panels = [
            'Bumper FRT', 'Bumper RR', 'Bodykit FRT', 'Bodykit RR', 'Pintu Depan RH', 'Pintu Depan LH','Pintu Belakang RH', 'Pintu Belakang LH', 'Kap Mesin', 'Fender RH', 'Fender LH', 'Triplank RH', 'Triplank LH', 'Quarter RH','Quarter LH', 'Roof', 'Pintu Bagasi'
        ];

        return view('spk.create', compact('customers', 'no_spk', 'panels')); 
    }

    /**
     * Simpan data SPK baru.
     */
    public function store(Request $request)
    {
        // 1. Validasi Data
        $validated = $request->validate([
            'no_spk' => 'required|unique:spks,no_spk',
            'customer_id' => 'required|exists:customers,id',
            'model' => 'required|string',
            'no_polisi' => 'required|string',
            'tgl_masuk' => 'required|date',
            'estimasi_selesai' => 'nullable|date', 
            'status' => 'required|in:proses,selesai,batal',
            'catatan' => 'nullable|string',
            
            'nama_panel' => 'required|array',
            'jenis_pekerjaan' => 'required|array',
            'biaya' => 'required|array',
            'nama_panel.*' => 'required|string',
            'jenis_pekerjaan.*' => 'required|in:KC,GC,SC',
            'biaya.*' => 'nullable|numeric|min:0',
        ]);
        
        // 2. Format Detail Panel menjadi array terstruktur untuk kolom 'details' (JSON)
        $detailsData = [];
        $panels = $request->nama_panel;
        foreach ($panels as $index => $panel) {
            if (isset($request->jenis_pekerjaan[$index]) && isset($request->biaya[$index])) {
                $detailsData[] = [
                    'nama_panel' => $panel,
                    'jenis_pekerjaan' => $request->jenis_pekerjaan[$index],
                    'biaya' => (float)($request->biaya[$index] ?? 0), 
                ];
            }
        }

        // 3. Gabungkan Data Utama dan Detail untuk disimpan
        $dataToStore = array_merge($validated, [
            'details' => $detailsData, 
        ]);
        
        // Hapus array detail terpisah agar tidak mengganggu proses create
        unset($dataToStore['nama_panel'], $dataToStore['jenis_pekerjaan'], $dataToStore['biaya']); 
        
        // 4. Simpan ke Database
        Spk::create($dataToStore);

        return redirect()->route('spk.index')->with('success', 'SPK ' . $validated['no_spk'] . ' berhasil disimpan!');
    }

    /**
     * Mengambil detail SPK dalam format JSON (untuk modal).
     */
    public function show(Spk $spk)
    {
        try {
            $spk->load('customer');
            
            // Ambil detail. Gunakan array kosong jika null/tidak ada.
            $details = collect($spk->details ?? []);

            // Gabungkan detail menjadi string dengan <br> untuk modal
            $namaPanel = $details->pluck('nama_panel')->implode('<br>');
            $jenisPekerjaan = $details->pluck('jenis_pekerjaan')->implode('<br>');

            // Format biaya
            $biayaFormatted = $details->pluck('biaya')->map(function ($b) {
                $biaya = is_numeric($b) ? (float) $b : 0;
                return 'Rp ' . number_format($biaya, 0, ',', '.');
            })->implode('<br>');
            
            $totalBiayaFormatted = 'Rp ' . number_format($spk->getTotalBiayaAttribute(), 0, ',', '.');
            
            // PERBAIKAN: Check NULL sebelum menggunakan Carbon::parse() untuk menghindari error 500
            $tglMasukFormatted = $spk->tgl_masuk ? Carbon::parse($spk->tgl_masuk)->translatedFormat('d M Y') : '-';
            $estimasiSelesaiFormatted = $spk->estimasi_selesai ? Carbon::parse($spk->estimasi_selesai)->translatedFormat('d M Y') : '-';

            return response()->json([
                'no_spk' => $spk->no_spk,
                'customer' => $spk->customer->nama ?? '-',
                'model' => $spk->model,
                'no_polisi' => $spk->no_polisi,
                'tgl_masuk' => $tglMasukFormatted,
                'estimasi_selesai' => $estimasiSelesaiFormatted,
                'status' => ucfirst($spk->status),
                'catatan' => $spk->catatan ?? '-',
                
                'nama_panel' => $namaPanel,
                'jenis_pekerjaan' => $jenisPekerjaan,
                'biaya' => $biayaFormatted, 
                
                'total_biaya' => $totalBiayaFormatted, 
            ]);

        } catch (Exception $e) {
            // Blok ini akan menangkap error dan mengembalikan status 500
            // Ini mencegah tampilan error PHP di browser, tapi memberitahu user ada masalah
            return response()->json(['error' => 'Internal Server Error'], 500); 
        }
    }

    /**
     * Menampilkan form edit SPK.
     */
    public function edit(Spk $spk)
    {
        $customers = Customer::all();
        
        $panels = [
            'Bumper FRT', 'Bumper RR', 'Bodykit FRT', 'Bodykit RR', 'Pintu Depan RH', 'Pintu Depan LH','Pintu Belakang RH', 'Pintu Belakang LH', 'Kap Mesin', 'Fender RH', 'Fender LH', 'Triplank RH', 'Triplank LH', 'Quarter RH','Quarter LH', 'Roof', 'Pintu Bagasi'
        ];
        
        return view('spk.edit', compact('spk', 'customers', 'panels'));
    }

    /**
     * Update SPK.
     */
    public function update(Request $request, Spk $spk)
    {
        // 1. Validasi Data
        $validated = $request->validate([
            'no_spk' => 'required|unique:spks,no_spk,' . $spk->id, 
            'customer_id' => 'required|exists:customers,id',
            'model' => 'required|string',
            'no_polisi' => 'required|string',
            'tgl_masuk' => 'required|date',
            'estimasi_selesai' => 'nullable|date',
            'status' => 'required|string',
            'catatan' => 'nullable|string',
            
            'nama_panel' => 'required|array',
            'jenis_pekerjaan' => 'required|array',
            'biaya' => 'required|array',
            'nama_panel.*' => 'required|string',
            'jenis_pekerjaan.*' => 'required|in:KC,GC,SC',
            'biaya.*' => 'nullable|numeric|min:0',
        ]);

        // 2. Format Detail Panel menjadi array terstruktur untuk kolom 'details' (JSON)
        $detailsData = [];
        $panels = $request->nama_panel;
        foreach ($panels as $index => $panel) {
            if (isset($request->jenis_pekerjaan[$index]) && isset($request->biaya[$index])) {
                $detailsData[] = [
                    'nama_panel' => $panel,
                    'jenis_pekerjaan' => $request->jenis_pekerjaan[$index],
                    'biaya' => (float)($request->biaya[$index] ?? 0), 
                ];
            }
        }
        
        // 3. Gabungkan Data Utama dan Detail untuk di-update
        $dataToUpdate = array_merge($validated, [
            'details' => $detailsData, 
        ]);
        
        // Hapus array detail terpisah
        unset($dataToUpdate['nama_panel'], $dataToUpdate['jenis_pekerjaan'], $dataToUpdate['biaya']); 

        // 4. Update ke Database
        $spk->update($dataToUpdate);

        return redirect()->route('spk.index')->with('success', 'Data SPK berhasil diperbarui!');
    }

    /**
     * Hapus SPK.
     */
    public function destroy(Spk $spk)
    {
        $spk->delete();
        return redirect()->route('spk.index')->with('success', 'Data SPK berhasil dihapus!');
    }

    /**
     * Cetak laporan SPK.
     */
    public function report(Spk $spk)
    {
        $spk->load('customer');
        return view('spk.report', compact('spk'));
    }
}