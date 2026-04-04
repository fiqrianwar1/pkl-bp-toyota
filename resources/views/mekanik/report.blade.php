<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Mekanik - {{ $mekanik->nama }}</title> 
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

        /* --- STYLE TANDA TANGAN (2 KOLOM) --- */
        .signature {
            margin-top: 60px;
            display: flex;
            justify-content: space-between;
            padding: 0 30px;
        }
        .signature-box {
            text-align: center;
            width: 220px;
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
        LAPORAN DATA MEKANIK
    </div>

    <h3 style="margin-bottom: 10px; font-size: 16px; border-left: 4px solid #c00; padding-left: 10px;">Informasi Mekanik</h3>

    {{-- TABEL INFORMASI MEKANIK --}}
    <table class="info-table">
        <tr>
            <td width="180" style="font-weight: bold;">Nama Mekanik</td>
            <td width="300">: <strong>{{ $mekanik->nama }}</strong></td>
            
            <td width="180" style="font-weight: bold;">Jabatan</td>
            <td>: {{ ucfirst($mekanik->jabatan) }}</td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Bidang Teknisi</td>
            <td>: {{ ucfirst($mekanik->teknisi) }}</td>
            
            <td style="font-weight: bold;">Telepon</td>
            <td>: {{ $mekanik->telp }}</td>
        </tr>
        <tr>
            {{-- Tambahan informasi jika ada, atau baris kosong --}}
            <td style="font-weight: bold;">Status</td>
            <td>: Aktif</td>
            <td></td>
            <td></td>
        </tr>
    </table>

    <div style="text-align:right; margin-top:40px; font-size: 14px; margin-right: 50px;">
        Banjarmasin, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
    </div>

    {{-- TANDA TANGAN (2 KOLOM) --}}
    <div class="signature">
        {{-- KIRI: FADHILLAH --}}
        <div class="signature-box">
            <b>Dibuat Oleh (Controller)</b><br>
            
            {{-- Gambar TTD Fadhillah --}}
            <img src="{{ asset('images/ttdfadil.png') }}" class="ttd-img" alt="TTD" 
                 onerror="this.style.display='none'; this.parentElement.innerHTML+='<br><br><br><br>';"> 
            
            <u>Fadhillah</u>
        </div>

        {{-- KANAN: SUGIANNOR --}}
        <div class="signature-box">
            <b>Mengetahui Manager</b><br>

            {{-- Gambar TTD Sugiannor --}}
            <img src="{{ asset('images/ttdsugiannnor.png') }}" class="ttd-img" alt="TTD"
                 onerror="this.style.display='none'; this.parentElement.innerHTML+='<br><br><br><br>';">

            <u>Sugiannor</u>
        </div>
    </div>
    
    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>