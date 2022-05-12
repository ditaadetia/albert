<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="">
</head>
<body>
    @if($position == 'penyewa_to_bendahara')
        <h3>Terdapat pembayaran baru!</h3>
    @elseif($position == 'bendahara_to_penyewa')
        <h3>Pembayaran berhasil dikonfirmasi!</h3>
    @endif
    <p>Nama Kegiatan: {{ $nama_kegiatan }}</p>
    <p>Nama Instansi: {{ $nama_instansi }}</p>
    <p>Nama Penyewa: {{ $nama_penyewa }}</p>
    <?php
        use Carbon\Carbon;
        setlocale(LC_TIME, 'id_ID');
        \Carbon\Carbon::setLocale('id');
        \Carbon\Carbon::now()->formatLocalized("%A, %d %B %Y");
    ?>
    <p>Total pembayaran: <b>{{ 'Rp. ' . number_format($total_bayar, 2, ",", ".") }}</b></p>
    @if($position == 'penyewa_to_bendahara')
        <p>Harap segera konfirmasi pembayaran <a href="http://311c-2001-448a-6060-f025-e5cf-8ee-86e5-f879.ngrok.io/">http://311c-2001-448a-6060-f025-e5cf-8ee-86e5-f879.ngrok.io</a></p>
    @endif
</body>
</html>