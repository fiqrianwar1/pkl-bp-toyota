<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Preparation - SPK {{ $preparation->spk->no_spk ?? 'N/A' }}</title> 
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            color: #000;
        }
        
        /* --- STYLE KOP SURAT --- */
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
        LAPORAN PENGERJAAN PREPARATION
    </div>

    {{-- TABEL INFO UTAMA --}}
    <table class="info-table">
        <tr>
            <td width="180" style="font-weight: bold;">No. SPK</td>
            <td width="300">: <strong>{{ $preparation->spk->no_spk ?? '-' }}</strong></td>
            <td width="180" style="font-weight: bold;">Customer</td>
            <td>: {{ $preparation->spk->customer->nama ?? '-' }}</td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Mekanik</td>
            <td>: {{ $preparation->mekanik->nama ?? '-' }}</td>
            <td style="font-weight: bold;">Tanggal Pengerjaan</td>
            <td>: {{ $preparation->tanggal ? \Carbon\Carbon::parse($preparation->tanggal)->translatedFormat('d F Y') : '-' }}</td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Jam Mulai</td>
            <td>: {{ $preparation->jam_mulai ? \Carbon\Carbon::parse($preparation->jam_mulai)->format('H:i') : '-' }}</td>
            <td style="font-weight: bold;">Jam Selesai</td>
            <td>: {{ $preparation->jam_selesai ? \Carbon\Carbon::parse($preparation->jam_selesai)->format('H:i') : '-' }}</td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Status</td>
            <td>: <strong>{{ ucfirst($preparation->status ?? '-') }}</strong></td>
            <td></td><td></td>
        </tr>
    </table>

    {{-- TABEL BAHAN --}}
    <h3 style="margin-top: 30px; margin-bottom: 5px; font-size: 16px; border-left: 4px solid #c00; padding-left: 10px;">Bahan yang Digunakan</h3>
    
    <table class="detail-table">
        <thead>
            <tr>
                <th width="10%">No</th>
                <th width="60%">Nama Bahan</th>
                <th width="30%">Jumlah (Qty)</th>
            </tr>
        </thead>
        <tbody>
            @php $bahan_tersimpan = is_array($preparation->bahan) ? $preparation->bahan : []; @endphp 
            @forelse ($bahan_tersimpan as $index => $item_bahan)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td>{{ isset($item_bahan['nama_bahan']) ? $item_bahan['nama_bahan'] : '-' }}</td>
                <td style="text-align: center;">{{ isset($item_bahan['qty']) ? $item_bahan['qty'] : '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="3" style="text-align: center;">Tidak ada data bahan yang tercatat.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div style="text-align:right; margin-top:40px; font-size: 14px; margin-right: 50px;">
        Banjarmasin, {{ now()->translatedFormat('d F Y') }}
    </div>

    {{-- TANDA TANGAN (3 KOLOM) --}}
    <div class="signature">
        {{-- KIRI: MEKANIK PREP --}}
        <div class="signature-box">
            <b>Dikerjakan Oleh</b><br>
            <br><br><br><br><br> 
            <u>{{ $preparation->mekanik->nama ?? '....................' }}</u>
        </div>

        {{-- TENGAH: FOREMAN --}}
        <div class="signature-box">
            <b>Foreman / Leader</b><br>
            {{-- Gambar TTD Foreman (Ganti kalau ada) --}}
            <img src="{{ asset('images/ttduci.png') }}" class="ttd-img" alt="TTD" 
                 onerror="this.style.display='none'; this.parentElement.innerHTML+='<br><br><br><br>';">
            
            <u>{{ $forman->nama ?? ($leader->nama ?? '....................') }}</u> 
        </div>

        {{-- KANAN: MANAGER --}}
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