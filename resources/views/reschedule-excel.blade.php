<?php
  use Carbon\Carbon;
  setlocale(LC_TIME, 'id_ID');
  \Carbon\Carbon::setLocale('id');
  \Carbon\Carbon::now()->formatLocalized("%A, %d %B %Y");
?>
<?php
// Skrip berikut ini adalah skrip yang bertugas untuk meng-export data tadi ke excell
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Daftar-Reschedule.xls");

?>
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
      <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/logo_kota_pontianak.png') }}">
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
    <center><h3 style="margin-bottom: 24px"><b>REKAPITULASI PERUBAHAN JADWAL</b></h3></center>
    <br>
    <table border="1">
      <thead>
        <tr align="center" style="text-align:center !important; vertical-align: middle !important; background-color:#FAD603">
          <td rowspan="1"><h6><b>NO.</b></h6></td>
          <td rowspan="1"><h6><b>KODE PEMESANAN</b></h6></td>
          <td rowspan="1"><h6><b>NAMA KEGIATAN</b></h6></td>
          <td rowspan="1"><h6><b>NAMA PERUSAHAAN</b></h6></td>
          <td rowspan="1"><h6><b>ALAMAT PERUSAHAAN</b></h6></td>
          <td rowspan="1"><h6><b>NAMA DIREKTUR</b></h6></td>
          <td rowspan="1"><h6><b>NO. KONTRAK</b></h6></td>
          <td colspan="1"><h6><b>TANGGAL KONTRAK</b></h6></td>
          <td rowspan="1" width="15%"><h6><b>NAMA ALAT</b></h6></td>
          <td rowspan="1" width="15%"><h6><b>WAKTU MULAI</b></h6></td>
          <td rowspan="1" width="15%"><h6><b>WAKTU SELESAI</b></h6></td>
        </tr>
      </thead>
      <tbody class="list">
        <?php $no = 0 ?>
        <?php
          $detail_reschedules = DB::table('detail_reschedules')
          ->join('reschedules', 'reschedules.id', '=', 'detail_reschedules.reschedule_id')
          ->join('orders', 'orders.id', '=', 'reschedules.order_id')
          ->join('tenants', 'tenants.id', '=', 'orders.tenant_id')
          ->join('equipments', 'detail_reschedules.equipment_id', '=', 'equipments.id')
          ->where('detail_reschedules.ket_persetujuan_kepala_uptd', 'setuju')
          ->get();
        ?>
        {{-- <?php
          setlocale(LC_TIME, 'id_ID');
          \Carbon\Carbon::setLocale('id');
          \Carbon\Carbon::now()->formatLocalized("%A, %d %B %Y");
          $tanggal_mulai = new DateTime($refund->tanggal_mulai);
          $tanggal_selesai = new DateTime($refund->tanggal_selesai);
          $total_waktu = $tanggal_selesai->diff($tanggal_mulai);
        ?> --}}
        @if($reschedules->count()>0)
          <?php $no++ ?>
          @foreach ($reschedules as $reschedule)
            <tr style="text-align:center !important; vertical-align: middle !important">
              <td class="no" valign="middle">
                {{ $no }}
              </td>
              <td valign="middle" style="margin-bottom: 80px !important">
                <b>ALB-{{ $reschedule->id }}</b>
              </td>
              <td>
                {{ $reschedule->nama_kegiatan }}
              </td>
              <td>
                {{ $reschedule->nama_instansi }}
              </td>
              <td>
                {{ $reschedule->alamat_instansi }}
              </td>
              <td>
                {{ $reschedule->nama }}
              </td>
              <td>
                <b>ALB-{{ $reschedule->id }}</b>
              </td>
              <td style="width: 145px;">
                {{ Carbon::parse($reschedule->created_at)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
              </td>
              <td>
                @foreach ($detail_reschedules as $detail_reschedule)
                  <ul type="none">
                    <li>
                      <b style="margin-left: -30px;">{{ $detail_reschedule->nama }}</b>
                    </li>
                  </ul>
                @endforeach
              </td>
              <td>
                @foreach ($detail_reschedules as $detail_reschedule)
                <ul type="none">
                  <li>
                    <b style="margin-left: -30px;">{{ Carbon::parse($detail_reschedule->waktu_mulai)->locale('id')->isoFormat('dddd, D MMMM YYYY') }} {{ Carbon::parse($detail_reschedule->waktu_mulai)->format('H:i') }}</b>
                  </li>
                </ul>
                @endforeach
              </td>
              <td>
                @foreach ($detail_reschedules as $detail_reschedule)
                <ul type="none">
                  <li>
                    <b style="margin-left: -30px;">{{ Carbon::parse($detail_reschedule->waktu_selesai)->locale('id')->isoFormat('dddd, D MMMM YYYY') }} {{ Carbon::parse($detail_reschedule->waktu_selesai)->format('H:i') }}</b>
                  </li>
                </ul>
                @endforeach
              </td>
            </tr>
          @endforeach
        @else
          <tr>
            <td colspan="13" style="text-align: center">
              Tidak ada data!
            </td>
          </tr>
        @endif
      </tbody>
    </table>
  </body>
</html>