<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- Title disesuaikan untuk Sparepart --}}
    <title>Laporan Sparepart - {{ $spareparts->first()->spk->no_spk ?? 'Total Laporan' }}</title> 
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            color: #000;
        }
        
        /* --- STYLE KOP SURAT (SAMA DENGAN SPK & CUSTOMER) --- */
        .kop-table {
            width: 100%;
            border-bottom: 3px double #000;
            padding-bottom: 10px;
            margin-bottom: 30px;
        }
        .kop-table td {
            vertical-align: middle;
        }
        .logo-cell {
            width: 100px;
            text-align: left;
        }
        .logo-img {
            width: 90px;
            height: auto;
        }
        .teks-cell {
            text-align: right;
        }
        .kop-teks h1 {
            font-size: 22px;
            font-weight: bold;
            margin: 0;
            text-transform: uppercase;
            color: #c00;
            line-height: 1.2;
        }
        .kop-teks h2 {
            font-size: 16px;
            margin: 5px 0;
            font-weight: bold;
            color: #333;
        }
        .kop-teks p {
            font-size: 12px;
            margin: 2px 0;
            color: #555;
        }

        /* --- STYLE TABEL INFO --- */
        .info-table {
            width: 100%;
            border-spacing: 0;
            margin-bottom: 20px;
            font-size: 14px;
        }
        .info-table td {
            vertical-align: top;
            padding: 5px 0;
        }

        /* --- STYLE TABEL DETAIL --- */
        .detail-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
            margin-top: 15px;
        }
        .detail-table th, .detail-table td {
            border: 1px solid #000;
            padding: 6px 8px;
            text-align: left;
        }
        .detail-table th {
            background-color: #f0f0f0;
            text-align: center;
            font-weight: bold;
        }

        /* --- STYLE TANDA TANGAN (3 KOLOM) --- */
        .signature {
            margin-top: 60px;
            display: flex;
            justify-content: space-between;
            padding: 0 10px;
        }
        .signature-box {
            text-align: center;
            width: 200px;
        }
        .ttd-img {
            height: 80px;
            width: auto;
            display: block;
            margin: 10px auto;
        }
        .info-block { 
            font-size: 14px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    
    {{-- HEADER KOP SURAT --}}
    <table class="kop-table">
        <tr>
            <td class="logo-cell">
                <img src="{{ asset('images/logo-toyota.png') }}" class="logo-img" alt="Logo">
            </td>
            <td class="teks-cell">
                <div class="kop-teks">
                    <h1>PT. WIRA MEGAH PROFITAMAS</h1>
                    <h2>BODY & PAINT WIRA TOYOTA BANJARMASIN</h2>
                    <p>Jl. A. Yani Km. 10, Kertak Hanyar, Kab. Banjar</p>
                    <p>(0511) 4225000 &nbsp;|&nbsp; service@wiratoyota.co.id</p>
                </div>
            </td>
        </tr>
    </table>

    {{-- JUDUL LAPORAN --}}
    <div style="text-align: center; font-weight: bold; font-size: 20px; margin-bottom: 30px; text-decoration: underline; text-transform: uppercase;">
        LAPORAN PEMESANAN SPAREPART
    </div>

    {{-- Blok Info SPK --}}
    @php
        $spk = $spareparts->first()->spk ?? null;
        $totalKeseluruhan = $spareparts->sum('total_harga');
    @endphp

    @if ($spk)
    <table class="info-table">
        <tr>
            <td width="180" style="font-weight: bold;">SPK Tujuan</td>
            <td>: <strong>{{ $spk->no_spk }}</strong> ({{ $spk->customer->nama ?? '-' }})</td>
        </tr>
        <tr>
            <td width="180" style="font-weight: bold;">Estimasi Kedatangan</td>
            <td>: <strong>{{ \Carbon\Carbon::parse($spareparts->first()->tgl_estimasi_datang)->translatedFormat('d F Y') }}</strong></td>
        </tr>
    </table>
    @else
    <div class="info-block">
        <strong style="color: #c00;">Laporan Total Keseluruhan Sparepart</strong>
    </div>
    @endif
    
    <h3 style="margin-top: 30px; margin-bottom: 5px; font-size: 16px; border-left: 4px solid #c00; padding-left: 10px;">Detail Item Dipesan</h3>
    
    {{-- Tabel Detail Item Sparepart --}}
    <table class="detail-table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="20%">No SPK</th>
                <th width="30%">Nama Sparepart/Panel</th>
                <th width="10%">Jumlah</th>
                <th width="15%">Harga Satuan</th>
                <th width="20%">Total Harga</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($spareparts as $item)
            <tr>
                <td style="text-align: center;">{{ $loop->iteration }}</td>
                <td style="text-align: center;">{{ $item->spk->no_spk ?? '-' }}</td>
                <td>{{ $item->nama_sparepart }}</td>
                <td style="text-align: center;">{{ $item->jumlah }}</td>
                <td style="text-align: right;">Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                <td style="text-align: right;">Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center;">Tidak ada item sparepart yang tercatat.</td>
            </tr>
            @endforelse
            <tr>
                <td colspan="5" style="text-align: right; font-weight: bold; background-color: #f0f0f0;">TOTAL KESELURUHAN ITEM</td>
                <td style="text-align: right; font-weight: bold; background-color: #f0f0f0;">Rp {{ number_format($totalKeseluruhan, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div style="margin-top: 20px; font-size: 14px; border: 1px dashed #999; padding: 10px; background: #fafafa;">
        <strong>Catatan Tambahan:</strong><br>
        {{ $spk->catatan ?? 'Tidak ada catatan terkait SPK ini.' }}<br>
        (Lokasi Penyimpanan: {{ $spareparts->first()->lokasi ?? '-' }})
    </div>

    <div style="text-align:right; margin-top:40px; font-size: 14px; margin-right: 50px;">
        Banjarmasin, {{ now()->translatedFormat('d F Y') }}
    </div>

    {{-- TANDA TANGAN (3 KOLOM) --}}
    <div class="signature">
        {{-- KIRI: DYLAN --}}
        <div class="signature-box">
            <b>Dibuat Oleh (Partman)</b><br>
            
            {{-- Gambar TTD Dylan --}}
            {{-- Pastikan nama filenya 'ttd_dylan.png' atau sesuaikan --}}
            <img src="{{ asset('images/ttddilan.png') }}" class="ttd-img" alt="TTD" 
                 onerror="this.style.display='none'; this.parentElement.innerHTML+='<br><br><br><br>';"> 
            
            <u>Dylan</u>
        </div>

        {{-- TENGAH: SUGIANNOR --}}
        <div class="signature-box">
            <b>Mengetahui Manager</b><br>

            {{-- Gambar TTD Sugiannor --}}
            <img src="{{ asset('images/ttdsugiannnor.png') }}" class="ttd-img" alt="TTD"
                 onerror="this.style.display='none'; this.parentElement.innerHTML+='<br><br><br><br>';">

            <u>Sugiannor</u>
        </div>

        {{-- KANAN: CUSTOMER --}}
        <div class="signature-box">
            <b>Disiapkan untuk SPK</b><br>
            <br><br><br><br><br> {{-- Kosong buat paraf manual --}}
            <u>{{ $spk->customer->nama ?? '....................' }}</u>
        </div>
    </div>
    
    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>