<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>

        body {
            font-family: sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }

        /* ===== HEADER ===== */

        .header-table {
            width: 100%;
            border-bottom: 2px solid black;
            padding-bottom: 8px;
            margin-bottom: 12px;
            padding-left: 30px; 
        }

        .header-table td {
            border: none;
            vertical-align: middle;
        }

        .logo-cell {
            width: 90px;
            text-align: center;
        }

        .title-big {
            font-size: 18px;
            font-weight: bold;
            margin: 2px 0;
            position: relative;
            left: -50px;
        }

        .title-mid {
            font-size: 14px;
            font-weight: bold;
            margin: 2px 0;
            position: relative;
            left: -50px;
        }

        .title-small {
            font-size: 11px;
            margin: 1px 0;
            position: relative;
            left: -50px;
        }

        /* ===== JUDUL ===== */

        .judul {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            margin: 10px 0 12px;
        }

        /* ===== TABLE ===== */

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            border: 1px solid black;
            padding: 6px;
            font-size: 12px;
            background: #f3f3f3;
        }

        td {
            border: 1px solid black;
            padding: 5px;
            font-size: 11px;
        }

        td.center {
            text-align: center;
        }

        td.ket {
            text-align: left;
        }

        .bukti-img {
            width: 55px;
            height: auto;
        }

        /* ===== FOOTER ===== */

        .footer {
            width: 100%;
            margin-top: 28px;
            text-align: right;
            font-size: 12px;
            line-height: 1.4;
        }

        .ttd-space {
        height: 80px;   
        }

    </style>
</head>
<body>

<!-- ===== HEADER ===== -->

<table class="header-table">
    <tr>
        <td class="logo-cell">
            <img src="{{ public_path('img/Logo_SMK.png') }}" width="90">
        </td>
        <td align="center">
            <div class="title-mid">PEMERINTAH PROVINSI JAWA TIMUR</div>
            <div class="title-mid">DINAS PENDIDIKAN</div>
            <div class="title-big">SEKOLAH MENENGAH KEJURUAN NEGERI 4 BOJONEGORO</div>
            <div class="title-small">
                Jalan Raya Surabaya – Desa Sukowati, Kec. Kapas 62181 Telp. 081269966444
            </div>
            <div class="title-small">
                Web : www.smkn4bojonegoro.sch.id | Email : smkn4bojonegoro@yahoo.co.id
            </div>
        </td>
    </tr>
</table>

<div class="judul">LAPORAN ASPIRASI SISWA</div>

<!-- ===== TABLE DATA ===== -->

<table>
    <thead>
        <tr>
            <th width="35">NO</th>
            <th width="75">TANGGAL</th>
            <th width="60">NIS</th>
            <th width="130">NAMA LENGKAP</th>
            <th width="95">KATEGORI</th>
            <th width="75">LOKASI</th>
            <th>KETERANGAN</th>
            <th width="70">BUKTI</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $i => $row)
        <tr>
            <td class="center">{{ $i + 1 }}</td>
            <td class="center">{{ $row->created_at->format('d-m-Y') }}</td>
            <td class="center">{{ $row->siswa->nis ?? '-' }}</td>
            <td>{{ strtoupper($row->siswa->nama_lengkap ?? '-') }}</td>
            <td class="center">{{ strtoupper($row->kategori->ket_kategori ?? '-') }}</td>
            <td class="center">{{ strtoupper($row->lokasi) }}</td>
            <td class="ket">{{ $row->ket_laporan }}</td>
            <td class="center">
                @if($row->foto_bukti)
                    <img src="{{ public_path('storage/'.$row->foto_bukti) }}" class="bukti-img">
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<!-- ===== FOOTER ===== -->

<div class="footer">
    BOJONEGORO, {{ now()->translatedFormat('d F Y') }}<br>
    KEPALA SMK NEGERI 4 BOJONEGORO

    <div class="ttd-space"></div>

    <b>ABDUL FATAH, S.Pd., M.M.Pd.</b><br>
    NIP : 196708121987031005
</div>

</body>
</html>