<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Customer - {{ $customer->nama }}</title> 
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            color: #000;
        }
        
        /* --- STYLE KOP SURAT (LOGO KIRI - TEKS KANAN) --- */
        .kop-table {
            width: 100%;
            border-bottom: 3px double #000; /* Garis ganda di bawah */
            padding-bottom: 10px;
            margin-bottom: 30px;
        }
        .kop-table td {
            vertical-align: middle; /* Biar posisi vertikal di tengah */
        }
        
        /* LOGO DI KIRI */
        .logo-cell {
            width: 100px;
            text-align: left; /* Logo nempel kiri */
        }
        .logo-img {
            width: 90px;
            height: auto;
        }

        /* TEKS DI KANAN */
        .teks-cell {
            text-align: right; /* 🔥 Teks nempel kanan */
        }
        .kop-teks h1 {
            font-size: 22px; /* Dikecilin dikit biar muat di kanan */
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

        /* --- STYLE LAINNYA --- */
        .info-table {
            width: 100%;
            border-spacing: 0;
            margin-bottom: 20px;
            font-size: 14px;
        }
        .info-table td {
            vertical-align: top;
            padding: 6px 0;
        }
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
            {{-- LOGO DI KIRI --}}
            <td class="logo-cell">
                <img src="{{ asset('images/logo-toyota.png') }}" class="logo-img" alt="Logo">
            </td>
            
            {{-- TEKS DI KANAN --}}
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
        Laporan Data Customer
    </div>

    <h3 style="margin-bottom: 10px; font-size: 16px; border-left: 4px solid #c00; padding-left: 10px; color: #333;">Informasi Detail</h3>

    <table class="info-table">
        <tr>
            <td width="150" style="font-weight: bold; color: #555;">Nama Customer</td>
            <td width="350">: <strong style="font-size: 16px;">{{ $customer->nama }}</strong></td>
            <td width="150" style="font-weight: bold; color: #555;">Jenis Kelamin</td>
            <td>: {{ $customer->jenis_kelamin }}</td>
        </tr>
        <tr>
            <td style="font-weight: bold; color: #555;">Alamat</td>
            <td>: {{ $customer->alamat }}</td>
            <td style="font-weight: bold; color: #555;">Telepon</td>
            <td>: {{ $customer->telp }}</td>
        </tr>
        <tr>
            <td style="font-weight: bold; color: #555;">Email</td>
            <td>: {{ $customer->email }}</td>
            <td style="font-weight: bold; color: #555;">Tanggal Estimasi</td>
            <td>: {{ \Carbon\Carbon::parse($customer->tanggal_estimasi)->translatedFormat('d F Y') }}</td>
        </tr>
    </table>

    <div style="text-align:right; margin-top:40px; font-size: 14px; margin-right: 50px;">
        Banjarmasin, {{ now()->translatedFormat('d F Y') }}
    </div>

    <div class="signature">
        <div class="signature-box">
            <b>Dibuat Oleh (Controller)</b><br>
            <img src="{{ asset('images/ttdfadil.png') }}" class="ttd-img" alt="TTD" 
                 onerror="this.style.display='none'; this.parentElement.innerHTML+='<br><br><br><br>';"> 
            <u style="font-weight: bold;">Fadhillah</u>
        </div>

        <div class="signature-box">
            <b>Mengetahui Manager</b><br>
            <img src="{{ asset('images/ttdsugiannnor.png') }}" class="ttd-img" alt="TTD"
                 onerror="this.style.display='none'; this.parentElement.innerHTML+='<br><br><br><br>';">
            <u style="font-weight: bold;">Sugiannor</u>
        </div>
    </div>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>