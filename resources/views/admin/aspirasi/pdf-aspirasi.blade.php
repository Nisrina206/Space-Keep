<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Detail Aspirasi</title>
    <style>
        body{
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        table{
            width:100%;
            border-collapse: collapse;
        }
        th,td{
            border:1px solid #000;
            padding:8px;
            text-align:left;
        }
        .header{
            display:flex;
            align-items:center;
            margin-bottom:20px;
        }
        .header img{
            width:70px;
            margin-right:15px;
        }
        .title{
            font-size:16px;
            font-weight:bold;
        }
        .subtitle{
            font-size:12px;
        }
        .bukti{
            margin-top:20px;
        }
        .bukti img{
            max-width:100%;
            max-height:300px;
        }
    </style>
</head>
<body>

<div class="header">
    <img src="{{ public_path('img/logo.png') }}">
    <div>
        <div class="title">SMK Negeri 4 Bojonegoro</div>
        <div class="subtitle">Detail Aspirasi Siswa</div>
    </div>
</div>

<table>
    <tr><th width="30%">NIS</th><td>{{ $nis }}</td></tr>
    <tr><th>Nama</th><td>{{ $nama }}</td></tr>
    <tr><th>Kategori</th><td>{{ $kategori }}</td></tr>
    <tr><th>Tempat</th><td>{{ $lokasi }}</td></tr>
    <tr><th>Keterangan</th><td>{{ $keterangan }}</td></tr>
    <tr><th>Status</th><td>{{ $status }}</td></tr>
    <tr><th>Tanggal</th><td>{{ $tanggal }}</td></tr>
</table>

<div class="bukti">
    <h4>Lampiran</h4>
    @if($bukti)
        <img src="{{ public_path('storage/'.$bukti) }}">
    @else
        <p>-</p>
    @endif
</div>

</body>
</html>
