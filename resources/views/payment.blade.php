@extends('layouts.headerPrimary')
@section('isicard')
<div class="container-fluid mt--6">
  <!-- Dark table -->
  <div class="row">
    <div class="col">
      <div class="card bg-default shadow" style="border-radius:50px !important;">
        <div class="card-header bg-default">
          <form class="navbar-search navbar-search-light form-inline mr-sm-3" id="navbar-search-main" action="/cari-payment" method="get">
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
                <th style="color:white !important;" scope="col">Nama Kegiatan</th>
                <th style="color:white !important;" scope="col">Nama Penyewa</th>
                <th style="color:white !important;" scope="col">Tanggal Pembayaran</th>
                <th style="color:white !important;" scope="col">Metode Pembayaran</th>
                {{-- <th style="color:white !important;" scope="col">Total Pembayaran</th> --}}
                <th style="color:white !important;" scope="col">Status Pembayaran</th>
                {{-- <th style="color:white !important;" scope="col">Nama Instansi</th>
                <th style="color:white !important;" scope="col">Jabatan</th>
                <th style="color:white !important;" scope="col">Alamat Instansi</th> --}}
                {{-- <th style="color:white !important;" scope="col">Status</th> --}}
                <th style="color:white !important;" scope="col"></th>
              </tr>
            </thead>
            <tbody class="list">
              <?php $no = 0 ?>
              @if($payments->count()>0)
                @foreach ($payments as $payment)
                  <?php $no++ ?>
                  <tr style="text-align:center !important;">
                    <td class="no">
                      {{ $no }}
                    </td>
                    <td>
                      {{ $payment->order->nama_kegiatan }}
                    </td>
                    <td>
                      {{ $payment->tenant->nama }}
                    </td>
                    <td>
                        {{ $payment->created_at }}
                    </td>
                    <td>
                        {{ $payment->metode_pembayaran }}
                      </td>
                    {{-- <td>
                      {{ $payment->total }}
                    </td> --}}
                    <td>
                      @if($payment->konfirmasi_pembayaran === 0 and $payment->ket_konfirmasi == '')
                        Belum diverifikasi
                      @elseif($payment->konfirmasi_pembayaran === 1)
                        Pengajuan diterima
                      @elseif($payment->konfirmasi_pembayaran === 0 and $payment->konfirmasi_pembayaran != '')
                        Pengajuan ditolak
                      @endif
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
                      <a href="{{ route('payments.show', ['payment' => $payment->id]) }}">
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
          {{ $payments->links() }}
        </div>
      </div>
    </div>
  </div>
@endsection