<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="">
</head>
<body>
    <h3>Terdapat pengajuan pengembalian dana baru!</h3>
    <p>Nama Kegiatan: {{ $nama_kegiatan }}</p>
    <p>Nama Instansi: {{ $nama_instansi }}</p>
    <p>Nama Penyewa: {{ $nama_penyewa }}</p>
    <?php
        use Carbon\Carbon;
        setlocale(LC_TIME, 'id_ID');
        \Carbon\Carbon::setLocale('id');
        \Carbon\Carbon::now()->formatLocalized("%A, %d %B %Y");
    ?>
    <p>Total pengembalian dana: <b>{{ 'Rp. ' . number_format($total_bayar, 2, ",", ".") }}</b></p>
    <p>Harap segera proses pengajuan pengembalian dana <a href="http://311c-2001-448a-6060-f025-e5cf-8ee-86e5-f879.ngrok.io/">http://311c-2001-448a-6060-f025-e5cf-8ee-86e5-f879.ngrok.io</a></p>
    {{-- @if($position == 'penyewa_to_bendahara')
    @endif --}}
</body>
</html>