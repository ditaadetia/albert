@extends('layouts.headerPrimary')
@section('isicard')
<?php 
  setlocale(LC_TIME, 'id_ID');
  \Carbon\Carbon::setLocale('id');
  \Carbon\Carbon::now()->formatLocalized("%A, %d %B %Y");
  use Carbon\Carbon;
                  setlocale(LC_TIME, 'id_ID');
                  \Carbon\Carbon::setLocale('id');
                  \Carbon\Carbon::now()->formatLocalized("%A, %d %B %Y");
                  $tanggal_refund = new DateTime($refund->created_at);
                  $tanggal_harus_kembali = new DateTime($order->tanggal_selesai);
                  $total_waktu = $tanggal_harus_kembali->diff($tanggal_refund);
?>
<div class="container-fluid mt--6">
  <!-- Dark table -->
  <div class="row justify-content-center align-items-centers">
    <div class="col-12">
      <div class="card shadow" style="border-radius:50px !important;">
        <div class="card-header">
          <div class="row">
            <div class="col-10">
              <h2><b>{{ $refund->nama }}</b></h2>
            </div>
            <div class="col-2">
              <img src="{{ asset('img/logo_kota_pontianak.png') }}" style="float:right; width:70px; height:70px;" alt="">
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
                      @if($refund->foto != '')
                        <img src="{{ asset('storage/' . $refund->foto) }}" style="width:180px; height:180px;" alt="">
                      @else
                        <img src="{{ asset('storage/tenant/no-pict.png') }}" style="width:180px; height:180px;" alt="">
                      @endif
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-6">
                      <div class="col mt-4">
                        <h6 class="text-sm-start">Nama Penyewa:</h6>
                        <h4 class="mt--2">{{ $refund->nama }}</h4>
                      </div>
                      <div class="col mt-3">
                        <h6 class="text-sm-start">Kontak:</h6>
                        <h4 class="mt--2">{{ $refund->no_hp }}</h4>
                      </div>
                      <div class="col mt-3">
                        <h6 class="text-sm-start">Kontak Darurat:</h6>
                        <h4 class="mt--2">{{ $refund->kontak_darurat }}</h4>
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="col mt-4">
                        <h6 class="text-sm-start">Metode Pembayaran:</h6>
                        <h4 class="mt--2">{{ $refund->metode_refund }}</h4>
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
                <div class="col-md-4 mt-5">
                  <h4><b>Jumlah</b></h4>
                  @if($total_waktu->days)
                    <div class="tes">
                      <p class="mt-3">Jumlah hari refund</p>
                      <h4 class="mt--4">{{ $total_waktu->days }} X {{ 'Rp. ' . number_format($equipment->harga_sewa_perhari, 2, ",", ".") }}</h4>
                    </div>
                  @else
                    <div class="tes">
                      <p>Jumlah jam refund</p>
                      <h4 class="mt--4">{{ $total_waktu->h }} X {{ 'Rp. ' . number_format($equipment->harga_sewa_perjam, 2, ",", ".") }}</h4>
                    </div>
                  @endif
                </div>
                <div class="col-md-4 text-right mt-5" style="padding-right:30px">
                  <h4><b>Total</b></h4>
                  @if($total_waktu->days)
                    <div class="tes">
                      <h4 class="mt-4">{{ 'Rp. ' . number_format($total_waktu->days * $equipment->harga_sewa_perhari, 2, ",", ".") }}</h4>
                    </div>
                  @else
                    <div class="tes">
                      <h4 class="mt-4">{{ 'Rp. ' . number_format($total_waktu->h * $equipment->harga_sewa_perjam, 2, ",", ".") }}</h4>
                    </div>
                  @endif
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col-6">
                  <h4><b>Jumlah</b></h4>
                </div>
                <div class="col-6 text-right" style="padding-right:30px">
                    <?php
                    if($total_waktu->days){
                      $jumlah = $total_waktu->days * $equipment->harga_sewa_perhari;
                    }else{
                      $jumlah = $total_waktu->h* $equipment->harga_sewa_perjam;
                    }
                    ?>
                  <h3><b>{{ 'Rp. ' . number_format($jumlah, 2, ",", ".") }}</b></h3>
                </div>
              </div>
            </div>
            <?php $total =$jumlah + $total ?>
          @endforeach
          <div class="row">
            <div class="col-6">
              <h4><b>Total Pengembalian Dana</b></h4>
            </div>
            <div class="col-6 text-right" style="padding-right:30px">
              <h3><b>{{ 'Rp. ' . number_format($total, 2, ",", ".") }}</b></h3>
            </div>
          </div>
        </div>
          <div class="col-12 text-right">
            @can('admin')
              @if($equipment->ket_verif_admin === 'belum')
                <form action="{{ route('verifRefundAdmin', ['id' => $equipment->id]) }}" style="margin: 16px">
                  <button type="submit" name="verifikasi" class="btn btn-success"><span class="ni ni-check-bold"></span> Verifikasi Pengajuan</button>
                  <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="Penolakan Pengajuan"><span class="ni ni-fat-remove"></span> Tolak Permohonan</button>
                </form>
              @endif
            @endcan
            @can('kepala_uptd')
              @if($equipment->ket_persetujuan_kepala_uptd === 'belum')
                <form action="{{ route('setujuRefundKepalaUPTD', ['id' => $equipment->id]) }}" style="margin: 16px">
                  <button type="submit" name="verifikasi" class="btn btn-success"><span class="ni ni-check-bold"></span> Verifikasi Pengajuan</button>
                  <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="Penolakan Pengajuan"><span class="ni ni-fat-remove"></span> Tolak Permohonan</button>
                </form>
              @endif
            @endcan
            @can('kepala_dinas')
              @if($equipment->ket_persetujuan_kepala_dinas === 'belum')
                <form action="{{ route('setujuRefundKepalaDinas', ['id' => $equipment->id]) }}" style="margin: 16px">
                  <button type="submit" name="verifikasi" class="btn btn-success"><span class="ni ni-check-bold"></span> Verifikasi Pengajuan</button>
                  <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="Penolakan Pengajuan"><span class="ni ni-fat-remove"></span> Tolak Permohonan</button>
                </form>
              @endif
            @endcan
            @can('bendahara')
              @if($equipment->ket_persetujuan_kepala_dinas === 'setuju')
                <form action="{{ route('refundBendahara', ['id' => $equipment->id]) }}" style="margin: 16px">
                  <button type="button" name="verifikasi" class="btn btn-success"><span class="ni ni-check-bold" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="Kembalikan Dana"></span> Kembalikan Dana</button>
                  <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="Penolakan Pengajuan"><span class="ni ni-fat-remove"></span> Kembalikan Dana</button>
                </form>
              @endif
            @endcan
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    @can('admin')
                      <form action="{{ route('tolakRefundAdmin', ['id' => $equipment->id]) }}" method="post" class="well" id="block-validate" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Penolakan pengajuan reschedule</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
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
                    @endcan
                    @can('kepala_uptd')
                      <form action="{{ route('tolakRefundKepalaUPTD', ['id' => $equipment->id]) }}" method="post" class="well" id="block-validate" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Penolakan pengajuan reschedule</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
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
                    @endcan
                    @can('kepala_dinas')
                      <form action="{{ route('tolakRefundKepalaDinas', ['id' => $equipment->id]) }}" method="post" class="well" id="block-validate" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Penolakan pengajuan reschedule</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
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
                    @endcan
                    @can('bendahara')
                      <h5 class="modal-title" id="exampleModalLabel">Pengembalian Dana</h5>
                    @endcan
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
                  @can('bendahara')
                    <form action="{{ route('refundBendahara', ['id' => $equipment->id]) }}" method="post" class="well" id="block-validate" enctype="multipart/form-data">
                      @csrf
                      @method('PUT')
                      <div class="pl-lg-4">
                        <div class="row">
                          <div class="col-md-9">
                            <div class="form-group">
                              <img class="img-preview img-fluid mb-3 col-sm-5">
                              <input class="form-control @error('bukti_refund') is-invalid @enderror" type="file" id="foto" name="bukti_refund" onchange="previewImage()" style="margin-top:16px;">
                              @error('bukti_refund')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                              @enderror
                            </div>
                          </div>
                          <span class="help-block" style="margin-left: 16px">Silahkan upload bukti pengembalian dana.</span>
                        </div>
                      </div>
                      <div class="col-12 text-right">
                        <button type="submit" name="update" class="btn btn-warning"><span class="fa fa-save"></span> Simpan</button>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="tolak" class="btn btn-success"><span class="ni ni-check-bold"></span> Submit</button>
                      </div>
                    </form>
                  @endcan
                </div>
              </div>
            </div>
          </div>
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