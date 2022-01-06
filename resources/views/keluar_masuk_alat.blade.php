@extends('layouts.headerPrimary')
@section('isicard')
<?php use App\Models\DetailOrder; ?>
<div class="container-fluid mt--6">
  <!-- Dark table -->
  <div class="row">
    <div class="col">
      <div class="card bg-default shadow" style="border-radius:50px !important;">
        <div class="card-header bg-default">
          <form class="navbar-search navbar-search-light form-inline mr-sm-3" id="navbar-search-main" action="/cari-keluar-masuk" method="get">
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
                {{-- <th style="color:white !important;" scope="col">Total Pembayaran</th> --}}
                <th style="color:white !important;" scope="col">Kategori</th>
                <th style="color:white !important;" scope="col">Status</th>
                {{-- <th style="color:white !important;" scope="col">Nama Instansi</th>
                <th style="color:white !important;" scope="col">Jabatan</th>
                <th style="color:white !important;" scope="col">Alamat Instansi</th> --}}
                {{-- <th style="color:white !important;" scope="col">Status</th> --}}
                <th style="color:white !important;" scope="col"></th>
              </tr>
            </thead>
            <tbody class="list">
              <?php $no = 0 ?>
              @if($keluar_masuk_alats->count()>0)
                @foreach ($keluar_masuk_alats as $keluar_masuk_alat)
                  <?php $no++ ?>
                  <tr style="text-align:center !important;">
                    <td class="no">
                      {{ $no }}
                    </td>
                    <td>
                      {{ $keluar_masuk_alat->nama_instansi }}
                    </td>
                    <td>
                      {{ $keluar_masuk_alat->nama_kegiatan }}
                    </td>
                    <td>
                      @if($keluar_masuk_alat->category_order_id == 1)
                        Penyewa Umum
                      @elseif($keluar_masuk_alat->category_order_id == 2)
                        Penyewa PUPR
                      @elseif($keluar_masuk_alat->category_order_id == 3)
                        Kegiatan Masyarakat
                      @endif
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
                    <td>
                      <?php $total = DetailOrder::all();?>
                      <?php if($keluar_masuk_alat->belum_diambil->count() > 0) { ?>
                        <b>{{ $keluar_masuk_alat->belum_diambil->count() }}</b> Belum Diambil
                      <?php } ?>
                      <?php if($keluar_masuk_alat->belum_kembali->count() > 0) { ?>
                        <b>{{ $keluar_masuk_alat->belum_kembali->count() }}</b> Sedang Dipakai
                      <?php } ?>
                      <?php if($keluar_masuk_alat->belum_diambil->count() == 0 and $keluar_masuk_alat->belum_kembali->count() == 0) { ?>
                        Selesai
                      <?php } ?>
                    </td>
                    <td>
                      <a href="{{ route('keluar-masuk-alat.show', ['keluar_masuk_alat' => $keluar_masuk_alat->id]) }}">
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
          {{ $keluar_masuk_alats->links() }}
        </div>
      </div>
    </div>
  </div>
@endsection