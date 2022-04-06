@extends('layouts.headerPrimary')
@section('isicard')
<?php
  setlocale(LC_TIME, 'id_ID');
  \Carbon\Carbon::setLocale('id');
  \Carbon\Carbon::now()->formatLocalized("%A, %d %B %Y");
?>
<div class="container-fluid mt--6">
  <!-- Dark table -->
  <div class="row justify-content-center align-items-centers">
    <div class="col-12">
      <div class="card shadow" style="border-radius:50px !important;">
        <div class="card-header">
          <div class="row">
            <div class="col-10">
              <h2><b>{{ $skr->nama }}</b></h2>
            </div>
            <div class="col-2">
              <img src="{{ asset('img/logo_pupr.jpeg') }}" style="float:right; width:70px; height:70px;" alt="">
            </div>
          </div>
        </div>
        <div class="card-body border-0">
          <div class="row">
            <div class="col-8">
              <h5>Receipt</h5>
            </div>
            <div class="col-4">
              <h5 class="text-right">Kode Penyewaan <b>ALB-Pay-{{ $skr->id }}</b></h5>
            </div>
          </div>
          <div class="row justify-content-center align-items-center">
            <div class="col-8">
              <div class="card">
                <div class="card-header" style="background-color: #364a76">
                  <h3 style="color:white !important;">Profil Penyewa</h3>
                </div>
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col-12 align-items-center text-center">
                      @if($skr->foto != '')
                        <img src="{{ asset('storage/' . $skr->foto) }}" style="width:180px; height:180px;" alt="">
                      @else
                        <img src="{{ asset('storage/tenant/no-pict.png') }}" style="width:180px; height:180px;" alt="">
                      @endif
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-6">
                      <div class="col mt-3">
                        <h6 class="text-sm-start">Nama Penyewa:</h6>
                        <h4 class="mt--2">{{ $skr->nama }}</h4>
                      </div>
                      <div class="col mt-5">
                        <h6 class="text-sm-start">Kontak:</h6>
                        <h4 class="mt--2">{{ $skr->no_hp }}</h4>
                      </div>
                      <div class="col mt-5">
                        <h6 class="text-sm-start">Kontak Darurat:</h6>
                        <h4 class="mt--2">{{ $skr->kontak_darurat }}</h4>
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="col mt-3">
                        <h6 class="text-sm-start">Status:</h6>
                        <?php
                          $nota = DB::table('skr')
                          ->where('order_id' , '=', $skr->id)
                          ->first();
                        ?>
                        @if( $nota == null)
                          <h4>Belum diterbitkan SKR</h4>
                        @else
                          <h4>Telah diterbitkan SKR</h4>
                        @endif
                      </div>
                      <div class="col mt-3">
                        <h6 class="text-sm-start">Total Pembayaran:</h6>
                        <?php $total = 0;
                          $equipment = DB::table('orders')
                          ->join('detail_orders', 'detail_orders.order_id', '=', 'orders.id')
                          ->join('equipments', 'detail_orders.equipment_id', '=', 'equipments.id')
                          ->where('orders.id', $skr->id)
                          ->select('orders.id', 'equipments.nama', 'equipments.foto', 'orders.tanggal_mulai', 'orders.tanggal_selesai', 'equipments.harga_sewa_perhari', 'equipments.harga_sewa_perjam')
                          // $detail_refund = DB::table('refunds')->join('detail_refunds', 'detail_refunds.refund_id', '=', 'refunds.id')->get();
                          ->get();
                        ?>
                          @foreach ($equipment as $equipment)
                            <?php
                            // use Carbon\Carbon;
                            setlocale(LC_TIME, 'id_ID');
                            \Carbon\Carbon::setLocale('id');
                            \Carbon\Carbon::now()->formatLocalized("%A, %d %B %Y");
                            $tanggal_mulai = new DateTime($equipment->tanggal_mulai);
                            $tanggal_selesai = new DateTime($equipment->tanggal_selesai);
                            $total_waktu = $tanggal_selesai->diff($tanggal_mulai);
                            $jumlah = ($total_waktu->days * $equipment->harga_sewa_perhari) + ($total_waktu->h * $equipment->harga_sewa_perjam);
                            $total = $total + $jumlah
                          ?>
                          @endforeach
                        <h4>{{ 'Rp. ' . number_format($total, 2, ",", ".") }}</h4>
                      </div>
                      <?php
                        $nota = DB::table('skr')
                        ->where('order_id' , '=', $skr->id)
                        ->first();
                      ?>
                      @if( $nota != null)
                        <div class="col mt-3">
                          <h6 class="text-sm-start">SKR:</h6>
                          <a href="{{ route('downloadBuktiPembayaran', ['id' => $skr->id]) }}">
                            <div class="contohgambar" style="position: relative;">
                              <img class="gambar1 mt--2" src="{{ asset('img/folder.png') }}" onmouseover="this.src='{{ asset('img/folder-hover.png') }}';" onmouseout="this.src='{{ asset('img/folder.png') }}';" style="width:180px; height:60px; position: relative; z-index: 1;" alt="">
                              <h5 style="position: absolute; z-index: 2; top: 0px; margin-left:10px;">Download file</h5>
                              <h6 style="position: absolute; z-index: 2; top: 25px; color: #9B9B9B; margin-left:10px;">{{ $nota->skr }}</h6>
                            </div>
                          </a>
                        </div>
                      @endif
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php $total = 0;
            $equipment = DB::table('orders')
            ->join('detail_orders', 'detail_orders.order_id', '=', 'orders.id')
            ->join('equipments', 'detail_orders.equipment_id', '=', 'equipments.id')
            ->where('orders.id', $skr->id)
            ->select('orders.id', 'equipments.nama', 'equipments.foto', 'orders.tanggal_mulai', 'orders.tanggal_selesai', 'equipments.harga_sewa_perhari', 'equipments.harga_sewa_perjam')
            // $detail_refund = DB::table('refunds')->join('detail_refunds', 'detail_refunds.refund_id', '=', 'refunds.id')->get();
            ->get();
          ?>
          @foreach ($equipment as $equipment)
            <div class="card" style="padding:16px;">
              <div class="row">
                <div class="col-md-4">
                  @if($equipment->foto != '')
                    <img src="{{ asset('storage/' . $equipment->foto) }}" style="width:120px; height:120px;">
                  @else
                    <img src="{{ asset('storage/equipments/no-pict.png') }}" style="width:120px; height:120px;">
                  @endif
                  <h5>{{ $equipment->nama }}</h5>
                </div>
                <?php
                  // use Carbon\Carbon;
                  setlocale(LC_TIME, 'id_ID');
                  \Carbon\Carbon::setLocale('id');
                  \Carbon\Carbon::now()->formatLocalized("%A, %d %B %Y");
                  $tanggal_mulai = new DateTime($equipment->tanggal_mulai);
                  $tanggal_selesai = new DateTime($equipment->tanggal_selesai);
                  $total_waktu = $tanggal_selesai->diff($tanggal_mulai);
                ?>
                <div class="col-md-4">
                  <h4><b>Jumlah</b></h4>
                  <div class="tes">
                    <p class="mt-3">Jumlah hari sewa</p>
                    <h4 class="mt--4">{{ $total_waktu->days }} X {{ 'Rp. ' . number_format($equipment->harga_sewa_perhari, 2, ",", ".") }}</h4>
                  </div>
                  <div class="tes">
                    <p>Jumlah jam sewa</p>
                    <h4 class="mt--4">{{ $total_waktu->h }} X {{ 'Rp. ' . number_format($equipment->harga_sewa_perjam, 2, ",", ".") }}</h4>
                  </div>
                </div>
                <div class="col-md-4 text-right" style="padding-right:30px">
                  <h4><b>Total</b></h4>
                  <div class="tes">
                    <h4 class="mt-4">{{ 'Rp. ' . number_format($total_waktu->days * $equipment->harga_sewa_perhari, 2, ",", ".") }}</h4>
                  </div>
                  <div class="tes">
                    <h4 class="mt-4">{{ 'Rp. ' . number_format($total_waktu->h * $equipment->harga_sewa_perjam, 2, ",", ".") }}</h4>
                  </div>
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col-6">
                  <h5>Total</h5>
                </div>
                <div class="col-6 text-right" style="padding-right:30px">
                  <?php
                    $jumlah = ($total_waktu->days * $equipment->harga_sewa_perhari) + ($total_waktu->h * $equipment->harga_sewa_perjam);
                    $total = $total + $jumlah
                  ?>
                  <h3>{{ 'Rp. ' . number_format($jumlah, 2, ",", ".") }}</h3>
                </div>
              </div>
            </div>
          @endforeach
        <div class="row">
          <div class="col-6">
            <h5>Total yang hasrus dibayar</h5>
          </div>
          <div class="col-6 text-right">
            <h3 style="padding-right:30px"><b>{{ 'Rp. ' . number_format($total, 2, ",", ".") }}</b></h3>
          </div>
        </div>
        <div class="card-footer justify-content-end py-4">
          <?php
            $nota = DB::table('skr')
            ->where('order_id' , '=', $skr->id)
            ->first();
          ?>
          @if( $nota == null)
            <div class="col-12 text-right">
              <form action="{{ route('setujuBendahara', ['id' => $skr->id]) }}">
                <button type="submit" name="setujuBendahara" class="btn btn-success"><span class="ni ni-check-bold"></span> Terbit SKR</button>
              </form>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
@endsection