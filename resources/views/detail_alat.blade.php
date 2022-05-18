<?php use Carbon\Carbon; ?>
@extends('layouts.headerPrimary')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
        integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.8.0/main.css' rel='stylesheet' />
@section('isicard')
<div class="container-fluid mt--6">
  <!-- Dark table -->
  <div class="row justify-content-center align-item-center">
    <div class="col-md-8">
      <div class="card shadow">
        <div class="card-header" style="background-color:#364a76">
          <div class="row align-items-center">
            <div class="col-md-10">
              <h3 class="mb-0 text-white">Detail Alat</h3>
            </div>
            <div class="col-md-2">
              <a href="{{ route('equipments.index') }}" class="btn btn-success btn-icon">
                <i class="fa fas fa-arrow-left"></i>
                <span class="nav-link-text">Kembali</span>
              </a>
            </div>
          </div>
        </div>
        <div class="card-body border-0" style="background-color:white">
          <div class="row justify-content-center align-item-center">
            @if($equipment->foto != '')
              <img src="{{ asset('storage/' . $equipment->foto) }}" style="width:300px; height:300px">
            @else
              <img src="{{ asset('storage/equipments/no-pict.png') }}" style="width:300px; height:300px">
            @endif
          </div>
          <div class="row justify-content-center align-item-center">
            <div class="col-md-12">
              <div id="calendar"></div>
            </div>
          </div>
          <div class="row">
            <div class="col-3">
              <h4>Nama Alat</h4>
            </div>
            <div class="col-1 text-right">
              :
            </div>
            <div class="col-8">
              <h4><b>{{ $equipment->nama }}</b></h4>
            </div>
          </div>
          {{-- <div class="row">
            <div class="col-3">
              <h4>Total Alat</h4>
            </div>
            <div class="col-1 text-right">
              :
            </div>
            <div class="col-8">
              <h4><b>{{ $equipment->total }}</b></h4>
            </div>
          </div>
          <div class="row">
            <div class="col-3">
              <h4>Jumlah Tersedia</h4>
            </div>
            <div class="col-1 text-right">
              :
            </div>
            <div class="col-8">
              <h4><b>{{ $equipment->jumlah_tersedia }}</b></h4>
            </div>
          </div> --}}
          <div class="row">
            <div class="col-3">
              <h4>Model</h4>
            </div>
            <div class="col-1 text-right">
              :
            </div>
            <div class="col-8">
              <h4><b>{{ $equipment->jenis }}</b></h4>
            </div>
          </div>
          <div class="row">
            <div class="col-3">
              <h4>Kegunaan</h4>
            </div>
            <div class="col-1 text-right">
              :
            </div>
            <div class="col-8">
              <h4><b>{{ $equipment->kegunaan }}</b></h4>
            </div>
          </div>
          <div class="row">
            <div class="col-3">
              <h4>Harga Sewa Perhari</h4>
            </div>
            <div class="col-1 text-right">
              :
            </div>
            <div class="col-8">
              <h4><b>{{ 'Rp. ' . number_format($equipment->harga_sewa_perhari, 2, ",", ".") }}</b></h4>
            </div>
          </div>
          <div class="row">
            <div class="col-3">
              <h4>Harga Sewa Perjam</h4>
            </div>
            <div class="col-1 text-right">
              :
            </div>
            <div class="col-8">
              <h4><b>{{ 'Rp. ' . number_format($equipment->harga_sewa_perjam, 2, ",", ".") }}</b></h4>
            </div>
          </div>
          <div class="row">
            <div class="col-3">
              <h4>Spesifikasi</h4>
            </div>
            <div class="col-1 text-right">
              :
            </div>
            <div class="col-8">
              <h4><b>{{ $equipment->keterangan }}</b></h4>
            </div>
          </div>
          <div class="row">
            <div class="col-3">
              <h4>Kondisi</h4>
            </div>
            <div class="col-1 text-right">
              :
            </div>
            <div class="col-8">
              <h4><b>{{ $equipment->kondisi }}</b></h4>
            </div>
          </div>
        </div>
        <div class="card-footer justify-content-end py-4" style="background-color:#364a76">
        </div>
      </div>
    </div>
  </div>
@endsection
<?php
  $datas = DB::table('schedules')
  ->join('orders', 'orders.id', '=', 'schedules.order_id')
  ->join('detail_orders', 'detail_orders.id', '=', 'schedules.detail_order_id')
  ->join('equipments', 'equipments.id', '=', 'detail_orders.equipment_id')
  ->where('equipments.id', '=', $equipment->id)
  ->select('schedules.tanggal_mulai', 'schedules.tanggal_selesai', 'orders.nama_kegiatan')
  ->get();
  // $tanggal_mulai= Carbon::parse($datas->tanggal_mulai)->isoFormat('YYYY-MM-D');
  // dd(Carbon::parse($datas->tanggal_mulai)->isoFormat('YYYY-MM-D'));
?>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        events: [ 
            <?php
              //melakukan looping
              foreach($datas as $data)
              {
                // $tanggal_mulai= Carbon::parse($data->tanggal_mulai)->isoFormat('YYYY-MM-D');
            ?>
            {
                title: '<?php echo $data->nama_kegiatan . ', Waktu Mulai:' . date('H:i', strtotime($data->tanggal_mulai)) . ', Waktu Selesai:' . date('H:i', strtotime($data->tanggal_selesai)); ?>', //menampilkan title dari tabel
                // start: '<?php echo Carbon::parse($data->tanggal_mulai)->isoFormat('YYYY-MM-D'); ?>',
                start: '<?php echo date('Y-m-d', strtotime($data->tanggal_mulai)); ?>',
                end: '<?php echo date('Y-m-d', strtotime($data->tanggal_selesai)); ?>', //menampilkan tgl selesai dari tabel
            },
            <?php } ?>
            
        ],
        selectOverlap: function (event) {
            return event.rendering === 'background';
        }
    });
    calendar.render();
  });
</script>