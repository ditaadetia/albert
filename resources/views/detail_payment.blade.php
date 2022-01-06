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
              <h2><b>{{ $payment->tenant->nama }}</b></h2>
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
              <h5 class="text-right">Kode Penyewaan <b>ALB-Pay-{{ $payment->id }}</b></h5>
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
                      @if($payment->tenant->foto != '')
                        <img src="{{ asset('storage/' . $payment->tenant->foto) }}" style="width:180px; height:180px;" alt="">
                      @else
                        <img src="{{ asset('storage/tenant/no-pict.png') }}" style="width:180px; height:180px;" alt="">
                      @endif
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-6">
                      <div class="col mt-4">
                        <h6 class="text-sm-start">Nama Penyewa:</h6>
                        <h4 class="mt--2">{{ $payment->tenant->nama }}</h4>
                      </div>
                      <div class="col mt-3">
                        <h6 class="text-sm-start">Kontak:</h6>
                        <h4 class="mt--2">{{ $payment->tenant->no_hp }}</h4>
                      </div>
                      <div class="col mt-3">
                        <h6 class="text-sm-start">Kontak Darurat:</h6>
                        <h4 class="mt--2">{{ $payment->tenant->kontak_darurat }}</h4>
                      </div>
                      <div class="col mt-3">
                        <h6 class="text-sm-start">Status:</h6>
                        @if($payment->konfirmasi_pembayaran === 0 and $payment->ket_konfirmasi == '')
                          <h3>Belum diverifikasi</h3>
                        @elseif($payment->konfirmasi_pembayaran === 1)
                          <h3>Pengajuan diterima</h3>
                        @elseif($payment->konfirmasi_pembayaran === 0 and $payment->ket_konfirmasi != '')
                          <h3>Pengajuan ditolak</h3>
                        @endif
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="col mt-4">
                        <h6 class="text-sm-start">Total Pembayaran:</h6>
                        <h4 class="mt--2">{{ 'Rp. ' . number_format($payment->total, 2, ",", ".") }}</h4>
                      </div>
                      <div class="col mt-4">
                        <h6 class="text-sm-start">Metode Pembayaran:</h6>
                        <h4 class="mt--2">{{ $payment->metode_pembayaran }}</h4>
                      </div>
                      <div class="col mt-3">
                        <h6 class="text-sm-start">Bukti Pembayaran:</h6>
                        <a href="{{ route('downloadBuktiPembayaran', ['id' => $payment->id]) }}">
                          <div class="contohgambar" style="position: relative;">
                            <img class="gambar1 mt--2" src="{{ asset('img/folder.png') }}" onmouseover="this.src='{{ asset('img/folder-hover.png') }}';" onmouseout="this.src='{{ asset('img/folder.png') }}';" style="width:180px; height:60px; position: relative; z-index: 1;" alt="">
                            <h5 style="position: absolute; z-index: 2; top: 0px; margin-left:10px;">Download file</h5>
                            <h6 style="position: absolute; z-index: 2; top: 25px; color: #9B9B9B; margin-left:10px;">{{ $payment->bukti_pembayaran }}</h6>
                          </div>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php $total = 0; ?>
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
        <div class="row">
          <div class="col-6">
            <h5>Total yang hasrus dibayar</h5>
          </div>
          <div class="col-6 text-right">
            <h3 style="padding-right:30px"><b>{{ 'Rp. ' . number_format($total, 2, ",", ".") }}</b></h3>
          </div>
        </div>
        <div class="card-footer justify-content-end py-4">
          @if($payment->konfirmasi_pembayaran === 0 and $payment->ket_konfirmasi == '')
            <div class="col-12 text-right">
              <form action="{{ route('verifPembayaran', ['id' => $payment->id]) }}">
                <button type="submit" name="verifikasi" class="btn btn-success"><span class="ni ni-check-bold"></span> Verifikasi Pembayaran</button>
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="Penolakan Pengajuan"><span class="ni ni-fat-remove"></span> Tolak Verifikasi Pembayaran</button>
              </form>
              <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Penolakan konfirmasi pembayaran</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('tolakPembayaran', ['id' => $payment->id]) }}" method="POST" class="well" id="block-validate">
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
          @endif
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