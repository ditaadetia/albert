<?php
  use Carbon\Carbon;
  setlocale(LC_TIME, 'id_ID');
  \Carbon\Carbon::setLocale('id');
  \Carbon\Carbon::now()->formatLocalized("%A, %d %B %Y");
?>
{{-- <?php
// Skrip berikut ini adalah skrip yang bertugas untuk meng-export data tadi ke excell
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Daftar-Order-Umum.xls");

?> --}}
<!DOCTYPE html>
<html>
  <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta name="description" content="Start your development with a Dashboard for Bootstrap 4.">
      <meta name="author" content="Creative Tim">
      <title>SI-ALBERT - UPTD Alat Berat PUPR Kota Pontianak</title>
      <!-- Icons -->
      <link rel="stylesheet" href="assets/vendor/nucleo/css/nucleo.css'" type="text/css">
      <!-- Page plugins -->
      <!-- Argon CSS -->
      <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/logo_pupr.jpeg') }}">
      <script type="text/javascript" src="assets/js/terbilang.js"></script>
      <style>
        .text-center {
          text-align: center;
        }
        table {
          width: 100%;
          color: #212121;
        }
        tr, td {
          padding: 8px!important;
        }
        .row {
          display: flex;
          margin-right: -15px;
          margin-left: -15px;
          flex-wrap: wrap;
        }
      </style>
      {{-- <link rel="stylesheet" href="assets/css/argon.css?v=1.2.0" type="text/css"> --}}
  <!-- jquery -->
  </head>
  <body>
    {{-- <?php
      if(Request::path() === 'orders-excel/1'){
        $judul='UMUM'
      }
    ?> --}}
    <center><h3 style="margin-bottom: 24px"><b>REKAPITULASI PENGEMBALIAN DANA</b></h3></center>
    <br>
    <table border="1">
      <thead bgcolor="#F4F4F">
        <tr align="center">
          <td rowspan="1"><h6><b>NO.</b></h6></td>
          <td rowspan="1"><h6><b>KODE PEMESANAN</b></h6></td>
          <td rowspan="1"><h6><b>NAMA KEGIATAN</b></h6></td>
          <td rowspan="1"><h6><b>NAMA PERUSAHAAN</b></h6></td>
          <td rowspan="1"><h6><b>ALAMAT PERUSAHAAN</b></h6></td>
          <td rowspan="1"><h6><b>NAMA DIREKTUR</b></h6></td>
          <td rowspan="1"><h6><b>NO. KONTRAK</b></h6></td>
          <td colspan="1"><h6><b>TANGGAL KONTRAK</b></h6></td>
          <td rowspan="1"><h6><b>METODE PENGEMBALIAN DANA</b></h6></td>
          <td rowspan="1"><h6><b>JUMLAH HARI REFUND</b></h6></td>
          <td rowspan="1"><h6><b>JUMLAH JAM REFUND</b></h6></td>
          <td colspan="1"><h6><b>NAMA ALAT</b></h6></td>
          <td rowspan="1"><h6><b>JUMLAH REFUND</b></h6></td>
        </tr>
      </thead>
      <tbody class="list">
        <?php $no = 0 ?>
        @if($refunds->count()>0)
          <?php $detail_refunds = DB::table('detail_refunds')
          ->join('refunds', 'refunds.id', '=', 'detail_refunds.refund_id')
          ->where('detail_refunds.refund_id', 'refunds.id')
          ->where('ket_persetujuan_kepala_dinas', 'setuju')
          ->get(); ?>
          @foreach ($refunds1 as $refund)
              <?php
                setlocale(LC_TIME, 'id_ID');
                \Carbon\Carbon::setLocale('id');
                \Carbon\Carbon::now()->formatLocalized("%A, %d %B %Y");
                $tanggal_mulai = new DateTime($refund->tanggal_mulai);
                $tanggal_selesai = new DateTime($refund->tanggal_selesai);
                $total_waktu = $tanggal_selesai->diff($tanggal_mulai);
              ?>
            <?php $no++ ?>
            <tr style="text-align:center !important;">
              <td class="no">
                {{ $no }}
              </td>
              <td>
                <b>ALB-{{ $refund->id }}</b>
              </td>
              <td>
                {{ $refund->nama_kegiatan }}
              </td>
              <td>
                {{ $refund->nama_instansi }}
              </td>
              <td>
                {{ $refund->alamat_instansi }}
              </td>
              <td>
                {{ $refund->nama }}
              </td>
              <td>
                <b>ALB-{{ $refund->id }}</b>
              </td>
              <td style="width: 145px;">
                {{ Carbon::parse($refund->created_at)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
              </td>
              <td>
                <b>{{ $refund->metode_refund }}</b>
              </td>
            </tr>
          @endforeach
        @else
          <tr>
            <td colspan="12" align="center">
              <p>Tidak ada data!</p>
            </td>
          </tr>
        @endif
      </tbody>
    </table>
  </body>
</html>