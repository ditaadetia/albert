<?php
  use Carbon\Carbon;
  setlocale(LC_TIME, 'id_ID');
  \Carbon\Carbon::setLocale('id');
  \Carbon\Carbon::now()->formatLocalized("%A, %d %B %Y");
?>
<?php
// Skrip berikut ini adalah skrip yang bertugas untuk meng-export data tadi ke excell
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Daftar-Pembatalan.xls");
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
    <center><h3 style="margin-bottom: 24px"><b>REKAPITULASI PEMBATALAN PENYEWAAN</b></h3></center>
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
          <td rowspan="1"><h6><b>JUMLAH HARI SEWA</b></h6></td>
          <td rowspan="1"><h6><b>JUMLAH JAM SEWA</b></h6></td>
          <td colspan="1"><h6><b>NAMA ALAT</b></h6></td>
          <td rowspan="1"><h6><b>BIAYA SEWA</b></h6></td>
        </tr>
      </thead>
      <tbody class="list">
        <?php $no = 0 ?>
        @if($orders->count()>0)
          @foreach ($orders as $order)
            <?php
              setlocale(LC_TIME, 'id_ID');
              \Carbon\Carbon::setLocale('id');
              \Carbon\Carbon::now()->formatLocalized("%A, %d %B %Y");
              $tanggal_mulai = new DateTime($order->tanggal_mulai);
              $tanggal_selesai = new DateTime($order->tanggal_selesai);
              $total_waktu = $tanggal_selesai->diff($tanggal_mulai);
            ?>
            <?php $no++ ?>
            <tr style="text-align:center !important; vertical-align: middle !important">
              <td class="no">
                {{ $no }}
              </td>
              <td>
                <b>ALB-{{ $order->id }}</b>
              </td>
              <td>
                {{ $order->nama_kegiatan }}
              </td>
              <td>
                {{ $order->nama_instansi }}
              </td>
              <td>
                {{ $order->alamat_instansi }}
              </td>
              <td>
                <ul type="none">
                  <li>
                    {{ $order->nama }}
                  </li>
                </ul>
              </td>
              <td>
                <b>ALB-{{ $order->id }}</b>
              </td>
              <td style="width: 145px;">
                {{ Carbon::parse($order->created_at)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
              </td>
              <td>
                <b>{{ $total_waktu->days }}</b>
              </td>
              <td>
                <b>{{ $total_waktu->h }}</b>
              </td>
              <?php
                $detail_orders = DB::table('orders')
                ->join('detail_orders', 'detail_orders.order_id', '=', 'orders.id')
                ->join('equipments', 'detail_orders.equipment_id', '=', 'equipments.id')
                ->where('orders.id', '=', $order->id)
                ->select('orders.tanggal_mulai', 'orders.tanggal_selesai', 'equipments.harga_sewa_perhari', 'equipments.harga_sewa_perjam', 'equipments.nama', 'equipments.jenis', 'equipments.id')->get();
              ?>
              <td>
                @foreach ($detail_orders as $detail_order)
                  {{ $detail_order->nama }}
                @endforeach
              </td>
              <td style="width: 130px;">
                <?php $total =0; ?>
                @foreach ($detail_orders as $detail_order)
                  <?php
                    $jumlah = ($detail_order->harga_sewa_perhari * $total_waktu->days) + ($detail_order->harga_sewa_perjam * $total_waktu->h);
                    $total = $total + $jumlah;
                  ?>
                @endforeach
                <b>{{ 'Rp. ' . number_format($total, 2, ",", ".") }}</b>
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