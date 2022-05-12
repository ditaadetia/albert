<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="">
</head>
<body>
    @if($position == 'kepala_dinas')
        <h3>Pengajuan Pengembalian Dana telah disetujui!</h3>
    @endif
    @if($position == 'bendahara_to_penyewa')
        <h3>Pengajuan Pengembalian Dana telah diproses!</h3>
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
    <p>Total pengembalian dana: <b>{{ 'Rp. ' . number_format($total_bayar, 2, ",", ".") }}</b></p>
</body>
</html>