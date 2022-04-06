@extends('layouts.headerPrimary')
@section('isicard')
<div class="container-fluid mt--6">
  <!-- Dark table -->
  <div class="row">
    <div class="col">
      <div class="card bg-default shadow" style="border-radius:50px !important;">
        <div class="card-header bg-default">
          <div class="row">
            <div class="col-9">
              <form class="navbar-search navbar-search-light form-inline mr-sm-3" id="navbar-search-main" action="/cari-reschedule" method="get">
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
            @can('kepala_uptd')
              <div class="col-3">
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="Export ke Excel">
                  <img src="{{ asset('assets/img/icons/common/excel.png') }}">
                  <span class="nav-link-text">Export ke Excel</span>
                </button>
              </div>
            @endcan
            @can('kepala_dinas')
              <div class="col-3">
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="Export ke Excel">
                  <img src="{{ asset('assets/img/icons/common/excel.png') }}">
                  <span class="nav-link-text">Export ke Excel</span>
                </button>
              </div>
            @endcan
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Rentang Waktu Rekapitulasi Perubahan Jadwal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                    <form action="{{ route('reschedulesExcel') }}" method="POST" class="well" id="block-validate">
                      @csrf
                      @method('PUT')
                      <div class="modal-body">
                        <div class="mb-3">
                          <label for="message-text" class="col-form-label">Masukkan rentang waktu laporan:</label>
                          <div class="form-group">
                            <label>Dari Tanggal</label>
                            <input type="date" class="form-control" name="tanggal_awal" id="tanggal_awal" />
                          </div>
                          <div class="form-group">
                              <label>Sampai dengan tanggal</label>
                              <input type="date" class="form-control" name="tanggal_akhir" id="tanggal_akhir" />
                          </div>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="tolak" class="btn btn-danger"><span class="ni ni-check-bold"></span> Submit</button>
                      </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="table-responsive">
          <table class="table align-items-center table-dark table-hover table-flush">
            <thead class="thead-dark" style="height:80px !important">
              <tr style="text-align:center !important;">
                <th style="color:white !important;" scope="col">No.</th>
                <th style="color:white !important;" scope="col">Nama Kegiatan</th>
                <th style="color:white !important;" scope="col">Nama Penyewa</th>
                <th style="color:white !important;" scope="col">Kategori</th>
                <th style="color:white !important;" scope="col">Pengajuan belum disetujui</th>
                {{-- <th style="color:white !important;" scope="col">Nama Instansi</th>
                <th style="color:white !important;" scope="col">Jabatan</th>
                <th style="color:white !important;" scope="col">Alamat Instansi</th> --}}
                {{-- <th style="color:white !important;" scope="col">Status</th> --}}
                <th style="color:white !important;" scope="col"></th>
              </tr>
            </thead>
            <tbody class="list">
              <?php $no = 0 ?>
              @can('admin')
                <?php
                  $reschedule=DB::table('detail_reschedules')->get();
                ?>
              @endcan
              @can('kepala_uptd')
                <?php
                  $reschedule=DB::table('detail_reschedules')->where('ket_verif_admin', 'verif')->get();
                ?>
              @endcan
              {{-- @can('kepala_dinas')
                <?php
                  $reschedule=DB::table('detail_reschedules')->where('ket_persetujuan_kepala_uptd', 'setuju')->get();
                ?>
              @endcan --}}
              @if($reschedule->count()>0)
                @foreach ($reschedules as $reschedule)
                  <?php $no++ ?>
                  <tr style="text-align:center !important;">
                    <td class="no">
                      {{ $no }}
                    </td>
                    <td>
                      {{ $reschedule->nama_kegiatan }}
                    </td>
                    <td>
                      {{ $reschedule->nama }}
                    </td>
                    <td>
                      @if($reschedule->category_order_id == 1)
                      Penyewa Umum
                      @elseif($reschedule->category_order_id == 2)
                      Penyewa PUPR
                      @elseif($reschedule->category_order_id == 3)
                      Kegiatan Masyarakat
                      @endif
                    </td>
                    @foreach ($details as $detail)
                    <?php
                      if(!auth()->check() || auth()->user()->jabatan === 'admin'){
                        $detail = DB::table('detail_reschedules')
                        ->join('orders', 'orders.id', 'detail_reschedules.order_id')
                        ->where('orders.id', $reschedule->id)
                        ->where('detail_reschedules.ket_verif_admin', '=', 'belum')
                        ->count();
                      }
                      elseif(!auth()->check() || auth()->user()->jabatan === 'kepala uptd'){
                        $detail = DB::table('detail_reschedules')
                        ->join('orders', 'orders.id', 'detail_reschedules.order_id')
                        ->where('orders.id', $reschedule->id)
                        ->where('detail_reschedules.ket_verif_admin', '=', 'verif')
                        ->where('detail_reschedules.ket_persetujuan_kepala_uptd', '=', 'belum')
                        ->count();
                      }
                      ?>
                    @endforeach
                    <td>
                      <b>{{ $detail }}</b> perlu disetujui
                    </td>
                    {{-- <td>
                      @if($refund->detail_refund->ket_verif_admin === 0 and $refund->detail_refund->ket_konfirmasi == '')
                        Belum diverifikasi
                      @elseif($refund->detail_refund->ket_verif_admin === 1)
                        Pengajuan diterima
                      @elseif($refund->detail_refund->ket_verif_admin === 0 and $refund->detail_refund->ket_konfirmasi != '')
                        Pengajuan ditolak
                      @endif
                    </td> --}}
                    <td>
                      <a href="{{ route('rescheduleShow', ['id' => $reschedule->id]) }}">
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
          {{ $reschedules->links() }}
        </div>
      </div>
    </div>
  </div>
@endsection