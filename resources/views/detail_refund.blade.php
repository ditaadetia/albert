@extends('layouts.headerPrimary')
@section('isicard')
<?php
  use Carbon\Carbon;
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
              <h2><b>{{ $refund->tenant->nama }}</b></h2>
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
              <h5 class="text-right">Kode Refund <b>ALB-Ref-{{ $refund->id }}</b></h5>
            </div>
          </div>
          <div class="row">
            <div class="col-8">
              <h5>Tanggal Pengajuan</h5>
            </div>
            <div class="col-4">
              <h5 class="text-right">{{ Carbon::parse($refund->created_at)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</h5>
            </div>
          </div>
          <br>
          <div class="row justify-content-center align-items-center">
            <div class="col-8">
              <div class="card">
                <div class="card-header" style="background-color: #364a76">
                  <h3 style="color:white !important;">Profil Penyewa</h3>
                </div>
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col-12 align-items-center text-center">
                      @if($refund->tenant->foto != '')
                        <img src="{{ asset('storage/' . $refund->tenant->foto) }}" style="width:180px; height:180px;" alt="">
                      @else
                        <img src="{{ asset('storage/tenant/no-pict.png') }}" style="width:180px; height:180px;" alt="">
                      @endif
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-6">
                      <div class="col mt-4">
                        <h6 class="text-sm-start">Nama Penyewa:</h6>
                        <h4 class="mt--2">{{ $refund->tenant->nama }}</h4>
                      </div>
                      <div class="col mt-3">
                        <h6 class="text-sm-start">Kontak:</h6>
                        <h4 class="mt--2">{{ $refund->tenant->no_hp }}</h4>
                      </div>
                      <div class="col mt-3">
                        <h6 class="text-sm-start">Kontak Darurat:</h6>
                        <h4 class="mt--2">{{ $refund->tenant->kontak_darurat }}</h4>
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="col mt-4">
                        <h6 class="text-sm-start">Metode Pembayaran:</h6>
                        <h4 class="mt--2">{{ $refund->metode_refund }}</h4>
                      </div>
                      <div class="col mt-3">
                        <h6 class="text-sm-start">Surat Permohonan Refund:</h6>
                        <a href="{{ route('downloadPermohonanRefund', ['id' => $refund->id]) }}">
                          <div class="contohgambar" style="position: relative;">
                            <img class="gambar1 mt--2" src="{{ asset('img/folder.png') }}" onmouseover="this.src='{{ asset('img/folder-hover.png') }}';" onmouseout="this.src='{{ asset('img/folder.png') }}';" style="width:180px; height:60px; position: relative; z-index: 1;" alt="">
                            <h5 style="position: absolute; z-index: 2; top: 0px; margin-left:10px;">Download file</h5>
                            <h6 style="position: absolute; z-index: 2; top: 25px; color: #9B9B9B; margin-left:10px;">{{ $refund->surat_permohonan_refund }}</h6>
                          </div>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php $total = 0 ?>
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
                  @can('admin')
                    @if($equipment->ket_verif_admin === 'belum')
                      <h3>Belum diverifikasi</h3>
                    @elseif($equipment->ket_verif_admin === 'verif')
                      <h3>Pengajuan diterima</h3>
                    @elseif($equipment->ket_verif_admin === 'tolak')
                      <h3>Pengajuan ditolak</h3>
                    @endif
                  @endcan
                  @can('kepala_uptd')
                    @if($equipment->ket_persetujuan_kepala_uptd === 'belum')
                      <h3>Belum diverifikasi</h3>
                    @elseif($equipment->ket_persetujuan_kepala_uptd === 'setuju')
                      <h3>Pengajuan diterima</h3>
                    @elseif($equipment->ket_persetujuan_kepala_uptd === 'tolak')
                      <h3>Pengajuan ditolak</h3>
                    @endif
                  @endcan
                  @can('kepala_dinas')
                  @if($equipment->ket_persetujuan_kepala_dinas === 'belum')
                    <h3>Belum diverifikasi</h3>
                  @elseif($equipment->ket_persetujuan_kepala_dinas === 'setuju')
                    <h3>Pengajuan diterima</h3>
                  @elseif($equipment->ket_persetujuan_kepala_dinas === 'tolak')
                    <h3>Pengajuan ditolak</h3>
                  @endif
                @endcan
                </div>
                <div class="col-md-4">
                  <h4><b>Jumlah</b></h4>
                  <div class="tes">
                    <p class="mt-3">Jumlah hari refund</p>
                    <h4 class="mt--4">{{ $equipment->jumlah_hari_refund }} X {{ 'Rp. ' . number_format($equipment->harga_sewa_perhari, 2, ",", ".") }}</h4>
                  </div>
                  <div class="tes">
                    <p>Jumlah jam refund</p>
                    <h4 class="mt--4">{{ $equipment->jumlah_jam_refund }} X {{ 'Rp. ' . number_format($equipment->harga_sewa_perjam, 2, ",", ".") }}</h4>
                  </div>
                </div>
                <div class="col-md-4 text-right" style="padding-right:30px">
                  <h4><b>Total</b></h4>
                  <div class="tes">
                    <h4 class="mt-4">{{ 'Rp. ' . number_format($equipment->jumlah_hari_refund * $equipment->harga_sewa_perhari, 2, ",", ".") }}</h4>
                  </div>
                  <div class="tes">
                    <h4 class="mt-4">{{ 'Rp. ' . number_format($equipment->jumlah_jam_refund * $equipment->harga_sewa_perjam, 2, ",", ".") }}</h4>
                  </div>
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col-6">
                  <h4><b>Total Pengembalian Dana</b></h4>
                </div>
                <div class="col-6 text-right" style="padding-right:30px">
                    <?php
                      $jumlah = ($equipment->jumlah_hari_refund * $equipment->harga_sewa_perhari) + ($equipment->jumlah_jam_refund* $equipment->harga_sewa_perjam);
                    ?>
                  <h3><b>{{ 'Rp. ' . number_format($jumlah, 2, ",", ".") }}</b></h3>
                </div>
                <div class="col-12 text-right">
                  @can('admin')
                    @if($equipment->ket_verif_admin === 'belum')
                      <form action="{{ route('verifRefundAdmin', ['id' => $equipment->id]) }}">
                        <button type="submit" name="verifikasi" class="btn btn-success"><span class="ni ni-check-bold"></span> Verifikasi Pengajuan</button>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="Penolakan Pengajuan"><span class="ni ni-fat-remove"></span> Tolak Permohonan</button>
                      </form>
                    @endif
                  @endcan
                  @can('kepala_uptd')
                    @if($equipment->ket_persetujuan_kepala_uptd === 'belum')
                      <form action="{{ route('setujuRefundKepalaUPTD', ['id' => $equipment->id]) }}">
                        <button type="submit" name="verifikasi" class="btn btn-success"><span class="ni ni-check-bold"></span> Verifikasi Pengajuan</button>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="Penolakan Pengajuan"><span class="ni ni-fat-remove"></span> Tolak Permohonan</button>
                      </form>
                    @endif
                  @endcan
                  @can('kepala_dinas')
                    @if($equipment->ket_persetujuan_kepala_dinas === 'belum')
                      <form action="{{ route('setujuRefundKepalaDinas', ['id' => $equipment->id]) }}">
                        <button type="submit" name="verifikasi" class="btn btn-success"><span class="ni ni-check-bold"></span> Verifikasi Pengajuan</button>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="Penolakan Pengajuan"><span class="ni ni-fat-remove"></span> Tolak Permohonan</button>
                      </form>
                    @endif
                  @endcan
                  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Penolakan pengajuan refund</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        @can('admin')
                          <form action="{{ route('tolakRefundAdmin', ['id' => $equipment->id]) }}" method="POST" class="well" id="block-validate">
                        @endcan
                        @can('kepala_uptd')
                          <form action="{{ route('tolakRefundKepalaUPTD', ['id' => $equipment->id]) }}" method="POST" class="well" id="block-validate">
                        @endcan
                        @can('kepala_dinas')
                          <form action="{{ route('tolakRefundKepalaDinas', ['id' => $equipment->id]) }}" method="POST" class="well" id="block-validate">
                        @endcan
                          @csrf
                          @method('PUT')
                          <div class="modal-body">
                            <div class="mb-3">
                              <label for="message-text" class="col-form-label">Alasan:</label>
                              <textarea class="form-control" name="alasan" id="message-text"></textarea>
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
            </div>
          @endforeach
        {{-- @if($refund->detail_refund->ket_verif_admin === 0 and $refund->detail_refund->ket_konfirmasi == '')
          <div class="card-footer justify-content-end py-4">
            <div class="col-12 text-right">
              <form action="{{ route('verifAdmin', ['id' => $refund->id]) }}">
                <button type="submit" name="verifikasi" class="btn btn-success"><span class="ni ni-check-bold"></span> Verifikasi Berkas</button>
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="Penolakan Pengajuan"><span class="ni ni-fat-remove"></span> Tolak Permohonan</button>
              </form>
              <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Penolakan pengajuan penyewaan</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('tolakAdmin', ['id' => $refund->id]) }}" method="POST" class="well" id="block-validate">
                      @csrf
                      @method('PUT')
                      <div class="modal-body">
                        <div class="mb-3">
                          <label for="message-text" class="col-form-label">Alasan:</label>
                          <textarea class="form-control" name="alasan" id="message-text"></textarea>
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
        @endif --}}
      </div>
    </div>
  </div>
@endsection
{{-- <script>
  var exampleModal = document.getElementById('exampleModal')
exampleModal.addEventListener('show.bs.modal', function (event) {
  // Button that triggered the modal
  var button = event.relatedTarget
  // Extract info from data-bs-* attributes
  var recipient = button.getAttribute('data-bs-whatever')
  // If necessary, you could initiate an AJAX request here
  // and then do the updating in a callback.
  //
  // Update the modal's content.
  var modalTitle = exampleModal.querySelector('.modal-title')
  var modalBodyInput = exampleModal.querySelector('.modal-body input')

  modalTitle.textContent = 'New message to ' + recipient
  modalBodyInput.value = recipient
})
</script> --}}