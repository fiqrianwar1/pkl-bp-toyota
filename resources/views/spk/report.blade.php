<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Perintah Kerja (SPK) - {{ $spk->no_spk }}</title> 
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            color: #000;
        }
        
        /* --- STYLE KOP SURAT (SAMA PERSIS DENGAN LAPORAN CUSTOMER) --- */
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
            justify-content: space-between; /* Biar nyebar kiri-tengah-kanan */
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
        SURAT PERINTAH KERJA (SPK)
    </div>

    {{-- TABEL INFO UTAMA --}}
    <table class="info-table">
        <tr>
            <td width="150" style="font-weight: bold;">No. SPK</td>
            <td width="300">: <strong style="font-size: 16px;">{{ $spk->no_spk }}</strong></td>
            <td width="150" style="font-weight: bold;">Model Kendaraan</td>
            <td>: {{ $spk->model }}</td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Customer</td>
            <td>: {{ $spk->customer->nama ?? '-' }}</td>
            <td style="font-weight: bold;">No. Polisi</td>
            <td>: {{ $spk->no_polisi }}</td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Tanggal Masuk</td>
            <td>: {{ \Carbon\Carbon::parse($spk->tgl_masuk)->translatedFormat('d F Y') }}</td>
            <td style="font-weight: bold;">Estimasi Selesai</td>
            <td>: {{ $spk->estimasi_selesai ? \Carbon\Carbon::parse($spk->estimasi_selesai)->translatedFormat('d F Y') : '-' }}</td>
        </tr>
    </table>

    <h3 style="margin-top: 30px; margin-bottom: 5px; font-size: 16px; border-left: 4px solid #c00; padding-left: 10px;">Detail Pekerjaan</h3>
    
    {{-- TABEL DETAIL PEKERJAAN --}}
    <table class="detail-table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="40%">Nama Panel</th>
                <th width="30%">Jenis Pekerjaan</th>
                <th width="25%">Biaya</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($spk->details as $index => $detail)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td>{{ $detail['nama_panel'] }}</td>
                <td style="text-align: center;">{{ $detail['jenis_pekerjaan'] }}</td>
                <td style="text-align: right;">Rp {{ number_format($detail['biaya'], 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="text-align: center;">Tidak ada detail pekerjaan dicatat.</td>
            </tr>
            @endforelse
            <tr>
                <td colspan="3" style="text-align: right; font-weight: bold; background-color: #f0f0f0;">TOTAL BIAYA</td>
                <td style="text-align: right; font-weight: bold; background-color: #f0f0f0;">Rp {{ number_format($spk->total_biaya ?? 0, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    {{-- CATATAN --}}
    <div style="margin-top: 20px; font-size: 14px; border: 1px dashed #999; padding: 10px; background: #fafafa;">
        <strong>Catatan Tambahan:</strong><br>
        {{ $spk->catatan ?? '-' }}
    </div>

    <div style="text-align:right; margin-top:40px; font-size: 14px; margin-right: 50px;">
        Banjarmasin, {{ now()->translatedFormat('d F Y') }}
    </div>

    {{-- TANDA TANGAN (3 KOLOM) --}}
    <div class="signature">
        {{-- KIRI --}}
        <div class="signature-box">
            <b>Dibuat Oleh</b><br>
            <img src="{{ asset('images/ttdfadil.png') }}" class="ttd-img" alt="TTD" 
                 onerror="this.style.display='none'; this.parentElement.innerHTML+='<br><br><br><br>';"> 
            <u>Fadhillah</u>
        </div>

        {{-- TENGAH --}}
        <div class="signature-box">
            <b>Mengetahui Manager</b><br>
            <img src="{{ asset('images/ttdsugiannnor.png') }}" class="ttd-img" alt="TTD"
                 onerror="this.style.display='none'; this.parentElement.innerHTML+='<br><br><br><br>';">
            <u>Sugiannor</u>
        </div>

        {{-- KANAN --}}
        <div class="signature-box">
            <b>Customer</b><br>
            {{-- TTD Customer biasanya kosong karena tanda tangan manual --}}
            <br><br><br><br><br> 
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