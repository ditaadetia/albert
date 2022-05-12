@extends('layouts.headerPrimary')
@section('isicard')
<?php use App\Models\DetailOrder; ?>
<div class="container-fluid mt--6">
  <!-- Dark table -->
  <div class="row">
    <div class="col">
      <div class="card bg-default shadow" style="border-radius:50px !important;">
        <div class="card-header bg-default">
          <form class="navbar-search navbar-search-light form-inline mr-sm-3" id="navbar-search-main" action="/cari-fine" method="get">
            <div class="form-group mb-0">
            <div class="input-group input-group-alternative input-group-merge">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-search"></i></span>
                </div>
                <input class="form-control" placeholder="Cari" type="search" name="keyword" id="search" onkeyup="searchTable()" value="{{ request('keyword') }}">
              </div>
            </div>
            <button type="button" class="close" data-action="search-close" data-target="#navbar-search-main" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
          </form>
        </div>
        <div class="table-responsive">
          <table class="table align-items-center table-dark table-hover table-flush">
            <thead class="thead-dark" style="height:80px !important">
              <tr style="text-align:center !important;">
                <th style="color:white !important;" scope="col">No.</th>
                <th style="color:white !important;" scope="col">Nama Instansi</th>
                <th style="color:white !important;" scope="col">Nama Kegiatan</th>
                <th style="color:white !important;" scope="col">Nama Penyewa</th>
                {{-- <th style="color:white !important;" scope="col">Total Pembayaran</th> --}}
                {{-- <th style="color:white !important;" scope="col">Status</th> --}}
                {{-- <th style="color:white !important;" scope="col">Nama Instansi</th>
                <th style="color:white !important;" scope="col">Jabatan</th>
                <th style="color:white !important;" scope="col">Alamat Instansi</th> --}}
                {{-- <th style="color:white !important;" scope="col">Status</th> --}}
                <th style="color:white !important;" scope="col"></th>
              </tr>
            </thead>
            <tbody class="list">
              <?php $no = 0 ?>
              @if($dendas->count()>0)
                @foreach ($dendas as $denda)
                  <?php $no++ ?>
                  <tr style="text-align:center !important;">
                    <td class="no">
                      {{ $no }}
                    </td>
                    <td>
                      {{ $denda->nama_instansi }}
                    </td>
                    <td>
                      {{ $denda->nama_kegiatan }}
                    </td>
                    <td>
                      {{ $denda->tenant->nama }}
                    </td>
                    {{-- <td>
                      @if($keluar_masuk_alat->status === 'Belum Diambil')
                        Belum Diambil
                      @elseif($keluar_masuk_alat->status === 'Sedang Dipakai')
                        Sedang Dipakai
                      @elseif($keluar_masuk_alat->status === 'selesai')
                        Selesai
                      @endif
                    </td> --}}
                    {{-- <td>
                      <?php $total =DB::table('detail_orders')->where('order_id', '=', $denda->id)->where('tanggal_kembali', '>', $denda->tanggal_selesai)?>
                      <b>{{ $total->count() }}</b> alat didenda
                    </td> --}}
                    <td>
                      <a href="{{ route('detailDenda', ['id' => $denda->id]) }}">
                        <i class="fa fa-search"></i>
                        <span class="nav-link-text">Detail</span>
                      </a>
                    </td>
                  </tr>
                @endforeach
              @else
                <tr>
                  <td>
                    <p>Tidak ada data!</p>
                  </td>
                </tr>
              @endif
            </tbody>
          </table>
        </div>
        <div class="card-footer justify-content-end py-4">
          {{ $dendas->links() }}
        </div>
      </div>
    </div>
  </div>
@endsection