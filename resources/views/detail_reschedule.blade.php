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
              <h2><b>{{ $reschedule->tenant->nama }}</b></h2>
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
              <h5 class="text-right">Kode Reschedule <b>ALB-Res-{{ $reschedule->id }}</b></h5>
            </div>
          </div>
          <div class="row">
            <div class="col-8">
              <h5>Tanggal Pengajuan</h5>
            </div>
            <div class="col-4">
              <h5 class="text-right">{{ Carbon::parse($reschedule->created_at)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</h5>
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
                  <div class="row">
                    <div class="col-12 text-center">
                        @if($reschedule->tenant->foto != '')
                            <img src="{{ asset('storage/' . $reschedule->tenant->foto) }}" style="width:180px; height:180px;" alt="">
                        @else
                            <img src="{{ asset('storage/tenant/no-pict.png') }}" style="width:180px; height:180px;" alt="">
                        @endif
                    </div>
                  </div>
                  <div class="row text-center">
                    <div class="col-12">
                      <div class="col mt-4">
                        <h6 class="text-sm-start">Nama Penyewa:</h6>
                        <h4 class="mt--2">{{ $reschedule->tenant->nama }}</h4>
                      </div>
                      <div class="col mt-3">
                        <h6 class="text-sm-start">Kontak:</h6>
                        <h4 class="mt--2">{{ $reschedule->tenant->no_hp }}</h4>
                      </div>
                      <div class="col mt-3">
                        <h6 class="text-sm-start">Kontak Darurat:</h6>
                        <h4 class="mt--2">{{ $reschedule->tenant->kontak_darurat }}</h4>
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
                <div class="col-md-3">
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
                </div>
                <div class="col-md-4">
                  <h3>Waktu Awal</h3>
                  <hr>
                  <div class="row">
                    <div class="col-md-6">
                      <h4><b>Tanggal</b></h4>
                      <div class="tes">
                        <p class="mt-3">Tanggal Mulai</p>
                        <h4 class="mt--4">{{ Carbon::parse($equipment->tanggal_mulai)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</h4>
                      </div>
                      <div class="tes">
                        <p>Tanggal Selesai</p>
                        <h4 class="mt--4">{{ Carbon::parse($equipment->tanggal_selesai)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</h4>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <h4><b>Jam</b></h4>
                      <div class="tes">
                        <p class="mt-3">Jam Mulai</p>
                        <h4 class="mt--4">{{ \Carbon\Carbon::parse($equipment->tanggal_mulai)->format('H:i') }}                    </h4>
                      </div>
                      <div class="tes">
                        <p>Jam Selesai</p>
                        <h4 class="mt--4">{{ \Carbon\Carbon::parse($equipment->tanggal_selesai)->format('H:i') }}</h4>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <h3>Waktu Reschedule</h3>
                  <hr>
                  <div class="row">
                    <div class="col-md-6">
                      <h4><b>Tanggal</b></h4>
                      <div class="tes">
                        <p class="mt-3">Tanggal Mulai</p>
                        <h4 class="mt--4">{{ Carbon::parse($equipment->waktu_mulai)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</h4>
                      </div>
                      <div class="tes">
                        <p>Tanggal Selesai</p>
                        <h4 class="mt--4">{{ Carbon::parse($equipment->waktu_selesai)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</h4>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <h4><b>Jam</b></h4>
                      <div class="tes">
                        <p class="mt-3">Jam Mulai</p>
                        <h4 class="mt--4">{{ \Carbon\Carbon::parse($equipment->waktu_mulai)->format('H:i') }}                    </h4>
                      </div>
                      <div class="tes">
                        <p>Jam Selesai</p>
                        <h4 class="mt--4">{{ \Carbon\Carbon::parse($equipment->waktu_selesai)->format('H:i') }}</h4>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col-12 text-right">
                  @can('admin')
                    @if($equipment->ket_verif_admin === 'belum')
                      <form action="{{ route('verifRescheduleAdmin', ['id' => $equipment->id]) }}">
                        <button type="submit" name="verifikasi" class="btn btn-success"><span class="ni ni-check-bold"></span> Verifikasi Pengajuan</button>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="Penolakan Pengajuan"><span class="ni ni-fat-remove"></span> Tolak Permohonan</button>
                      </form>
                    @endif
                  @endcan
                  @can('kepala_uptd')
                    @if($equipment->ket_persetujuan_kepala_uptd === 'belum')
                      <form action="{{ route('setujuRescheduleKepalaUPTD', ['id' => $equipment->id]) }}">
                        <button type="submit" name="verifikasi" class="btn btn-success"><span class="ni ni-check-bold"></span> Verifikasi Pengajuan</button>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="Penolakan Pengajuan"><span class="ni ni-fat-remove"></span> Tolak Permohonan</button>
                      </form>
                    @endif
                  @endcan
                  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Penolakan pengajuan reschedule</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        @can('admin')
                          <form action="{{ route('tolakRescheduleAdmin', ['id' => $equipment->id]) }}" method="POST" class="well" id="block-validate">
                        @endcan
                        @can('kepala_uptd')
                          <form action="{{ route('tolakRescheduleKepalaUPTD', ['id' => $equipment->id]) }}" method="POST" class="well" id="block-validate">
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