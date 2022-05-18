<?php use Carbon\Carbon; ?>
@extends('layouts.headerPrimary')
@section('isicard')
<div class="container-fluid mt--6">
  <!-- Dark table -->
  <div class="row">
    <div class="col">
      <div class="card bg-default shadow">
        <div class="card-header bg-default border-0">
          <div class="row">
            <div class="col-9">
              <form class="navbar-search navbar-search-light form-inline mr-sm-3 nav-link" id="navbar-search-main" action="{{ route('search') }}" method="get">
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
            <div class="col-3">
              <a href="{{ route('equipments.create') }}" class="btn btn-primary btn-icon">
                  <i class="ni ni-fat-add"></i>
                  <span class="nav-link-text">Tambah Alat Berat</span>
              </a>
            </div>
          </div>
          {{-- <form class="navbar-search navbar-search-light form-inline mr-sm-3" id="navbar-search-main">
              <div class="form-group mb-0">
              <div class="input-group input-group-alternative input-group-merge">
                  <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-search"></i></span>
                  </div>
                  <input class="form-control" placeholder="Search" type="text" id="input" onkeyup="searchTable()">
              </div>
              </div>
              <button type="button" class="close" data-action="search-close" data-target="#navbar-search-main" aria-label="Close">
              <span aria-hidden="true">×</span>
              </button>
          </form> --}}
        </div>
        <div class="table-responsive">
          <table class="table align-items-center table-dark table-hover table-flush">
            <thead class="thead-dark" style="height:80px !important">
              <tr style="text-align:center !important;">
                <th style="color:white !important;" scope="col">No.</th>
                <th style="color:white !important;" scope="col">Nama</th>
                {{-- <th style="color:white !important;" scope="col">Jumlah Alat Tersedia</th> --}}
                <th style="color:white !important;" scope="col">Harga Sewa Perjam</th>
                <th style="color:white !important;" scope="col">Harga Sewa Perhari</th>
                <th style="color:white !important;" scope="col">Spesifikasi</th>
                <th style="color:white !important;" scope="col">Status</th>
                <th></th>
              </tr>
            </thead>
            <tbody class="list">
              <?php $no = 0 ?>
              @if($equipments->count()>0)
                @foreach ($equipments as $equipment)
                  <?php $no++ ?>
                  <tr style="text-align:center !important;">
                    <td class="no">
                        {{ $no }}
                    </td>
                    <td>
                      {{ $equipment->nama }}
                    </td>
                    {{-- <td>
                      {{ $equipment->jumlah_tersedia }}
                    </td> --}}
                    {{-- <td>
                        <img src="{{ asset('storage/' . $equipment->foto) }}" width="200%;">
                    </td> --}}
                    <td>
                      {{ 'Rp. ' . number_format($equipment->harga_sewa_perjam, 2, ",", ".") }}
                    </td>
                    <td>
                      {{ 'Rp. ' . number_format($equipment->harga_sewa_perhari, 2, ",", ".") }}
                    </td>
                    <td>{{ $equipment->keterangan }}</td>
                    <?php
                    // dd($equipment->id);
                      $schedules= DB::table('schedules')
                      ->join('detail_orders', 'detail_orders.id', '=', 'schedules.detail_order_id')
                      ->join('equipments', 'equipments.id', '=', 'detail_orders.equipment_id')
                      ->where('equipments.id', '=', $equipment->id)
                      // ->whereBetween(['schedules.tanggal_mulai', 'schedules.tanggal_selesai'], Carbon::now())
                      ->get()
                    ?>
                    <?php $count=0 ?>
                      <td>
                        @foreach($schedules as $schedule)
                          <?php
                            $currentDate = date('Y-m-d H:i:s', strtotime(Carbon::now()));
                            $startDate = $schedule->tanggal_mulai;
                            $endDate = $schedule->tanggal_selesai;
                            if (($currentDate >= $startDate) && ($currentDate <= $endDate)){
                              // echo "Current date is not between two dates";
                              $count++;
                              // $tes= $count+1
                            }
                          ?>
                        @endforeach
                        @if($count > 0)
                          Alat sedang dipakai
                        @else
                          Alat tidak sedang dipakai
                        @endif
                      </td>
                      {{-- <td>{{ $count }}</td> --}}
                    <?php
                    // $currentDate = date('Y-m-d');
                    $currentDate = date('Y-m-d', strtotime("05/14/2022"));
                    $startDate = date('Y-m-d', strtotime("05/10/2022"));
                    $endDate = date('Y-m-d', strtotime("05/20/2022"));
                    // dd($currentDate, $startDate, $endDate)
                    ?>
                    {{-- @if($schedule > 0)
                      <td>
                        {{ $schedule }}
                      </td>
                    @endif --}}
                    <td class="text-right">
                      <div class="dropdown">
                        <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="fas fa-ellipsis-v"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                          <a class="dropdown-item" href="{{ route('equipments.show', ['equipment' => $equipment->id]) }}">
                            <button class="btn btn-link border-0">
                              <i class="fas fa-search text-primary"></i>
                              <span>Lihat Detail</span>
                            </button>
                          </a>
                          <a class="dropdown-item" href="{{ route('equipments.edit', ['equipment' => $equipment->id]) }}">
                            <button class="btn btn-link border-0">
                              <i class="fa fa-edit text-success"></i>
                              <span>Edit Alat</span>
                            </button>
                          </a>
                          <form action="{{ route('equipments.destroy', ['equipment' => $equipment->id]) }}" method="POST" class="d-inline">
                            @method('delete')
                            @csrf
                            <a class="dropdown-item">
                              <button class="btn btn-link border-0" onclick="return confirm('Apakah Anda yakin ingin menghapus data {{ $equipment->nama }}?')">
                                <i class="fas fa-eraser text-danger"></i>
                                <span>Hapus Alat</span>
                              </button>
                            </a>
                          </form>
                        </div>
                      </div>
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
          {{ $equipments->links() }}
        </div>
      </div>
    </div>
  </div>
@endsection