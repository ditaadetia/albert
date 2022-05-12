<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="">
</head>
<body>
    <h3>Mohon maaf pengajuan {{ $status }} yang Anda ajukan ditolak.</h3>
    <p>Nama Kegiatan: {{ $nama_kegiatan }}</p>
    <p>Nama Instansi: {{ $nama_instansi }}</p>
    <p>Nama Penyewa: {{ $nama_penyewa }}</p>
    <p>Alasan Penolakan: {{ $alasan }}</p>

    <?php
        use Carbon\Carbon;
        setlocale(LC_TIME, 'id_ID');
        \Carbon\Carbon::setLocale('id');
        \Carbon\Carbon::now()->formatLocalized("%A, %d %B %Y");
    ?>
    @if($status==='perubahan jadwal')
        <p>Waktu Awal: {{ Carbon::parse($tanggal_mulai)->locale('id')->isoFormat('dddd, D MMMM YYYY') }} {{ \Carbon\Carbon::parse($tanggal_mulai)->format('H:i') }} s/d {{ Carbon::parse($tanggal_selesai)->locale('id')->isoFormat('dddd, D MMMM YYYY') }} {{ \Carbon\Carbon::parse($tanggal_selesai)->format('H:i') }}</p>
        <p>Waktu Reschedule: {{ Carbon::parse($waktu->waktu_mulai)->locale('id')->isoFormat('dddd, D MMMM YYYY') }} {{ \Carbon\Carbon::parse($waktu->waktu_mulai)->format('H:i') }} s/d {{ Carbon::parse($waktu->waktu_selesai)->locale('id')->isoFormat('dddd, D MMMM YYYY') }} {{ \Carbon\Carbon::parse($waktu->waktu_selesai)->format('H:i') }}</p>
    @endif
</body>
</html>