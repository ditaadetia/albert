<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="">
</head>
<body>
    <h3>SKR telah terbit!</h3>
    <p>Nama Kegiatan: {{ $nama_kegiatan }}</p>
    <p>Nama Instansi: {{ $nama_instansi }}</p>
    <p>Nama Penyewa: {{ $nama_penyewa }}</p>
    <?php
        use Carbon\Carbon;
        setlocale(LC_TIME, 'id_ID');
        \Carbon\Carbon::setLocale('id');
        \Carbon\Carbon::now()->formatLocalized("%A, %d %B %Y");
    ?>
    <p>Total yang harus dibayar: <b>{{ 'Rp. ' . number_format($total, 2, ",", ".") }}</b></p>
    <p>Harap segera lakukan pembayaran. Pembayaran dilakukan maksimal 30 hari setelah SKR diterbitkan. Jika pembayaran dilakukn lebih dari 30 hari, maka penyewa akan dikenakan denda sebesar 2% dari total pesanan</p>
</body>
</html>