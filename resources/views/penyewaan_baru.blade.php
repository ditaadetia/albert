<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="">
</head>
<body>
    <h3>Terdapat pengajuan penyewaan baru!</h3>
    <p>Nama Kegiatan: {{ $nama_kegiatan }}</p>
    <p>Nama Instansi: {{ $nama_instansi }}</p>
    <p>Nama Penyewa: {{ $nama_penyewa }}</p>
    <?php
        use Carbon\Carbon;
        setlocale(LC_TIME, 'id_ID');
        \Carbon\Carbon::setLocale('id');
        \Carbon\Carbon::now()->formatLocalized("%A, %d %B %Y");
    ?>
    <p>Waktu Awal: {{ Carbon::parse($tanggal_mulai)->locale('id')->isoFormat('dddd, D MMMM YYYY') }} {{ \Carbon\Carbon::parse($tanggal_mulai)->format('H:i') }} s/d {{ Carbon::parse($tanggal_selesai)->locale('id')->isoFormat('dddd, D MMMM YYYY') }} {{ \Carbon\Carbon::parse($tanggal_selesai)->format('H:i') }}</p>
    @if($position == 'admin_to_kepala_uptd')
        <p>Harap segera berikan persetujuan <a href="http://311c-2001-448a-6060-f025-e5cf-8ee-86e5-f879.ngrok.io/">http://311c-2001-448a-6060-f025-e5cf-8ee-86e5-f879.ngrok.io</a></p>
    {{-- @can('kepala_dinas')
        <p>Harap segera berikan persetujuan <a href="http://311c-2001-448a-6060-f025-e5cf-8ee-86e5-f879.ngrok.io/">http://311c-2001-448a-6060-f025-e5cf-8ee-86e5-f879.ngrok.io</a></p>
    @endcan --}}
    @elseif($position == 'kepala_uptd_to_kepala_dinas')
        <p>Harap segera berikan persetujuan <a href="http://311c-2001-448a-6060-f025-e5cf-8ee-86e5-f879.ngrok.io/">http://311c-2001-448a-6060-f025-e5cf-8ee-86e5-f879.ngrok.io</a></p>
    @elseif($position == 'kepala_dinas_to_bendahara')
        <p>Harap segera terbitkan SKR <a href="http://311c-2001-448a-6060-f025-e5cf-8ee-86e5-f879.ngrok.io/">http://311c-2001-448a-6060-f025-e5cf-8ee-86e5-f879.ngrok.io</a></p>
    @elseif($position == 'penyewa_to_admin')
        <p>Harap segera lakukan verifikasi <a href="http://311c-2001-448a-6060-f025-e5cf-8ee-86e5-f879.ngrok.io/">http://311c-2001-448a-6060-f025-e5cf-8ee-86e5-f879.ngrok.io</a></p>
    @endif
</body>
</html>