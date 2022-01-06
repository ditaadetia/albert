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
              <h2><b>{{ $order->tenant->nama }}</b></h2>
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
              <h5 class="text-right">Kode Pemesanan <b>ALB-{{ $order->id }}</b></h5>
            </div>
          </div>
          <div class="row justify-content-center align-items-center">
            <div class="col-8">
              <div class="card">
                <div class="card-header" style="background-color: #364a76">
                  <h3 style="color:white !important;">Jangka Waktu Penyewaan</h3>
                </div>
                <?php
                  use Carbon\Carbon;
                  setlocale(LC_TIME, 'id_ID');
                  \Carbon\Carbon::setLocale('id');
                  \Carbon\Carbon::now()->formatLocalized("%A, %d %B %Y");
                  $tanggal_mulai = new DateTime($order->tanggal_mulai);
                  $tanggal_selesai = new DateTime($order->tanggal_selesai);
                  // $tanggal_kembali = new DateTime($detail->tanggal_kembali);
                  $tanggal_sekarang= Carbon::now();
                  $jam_sekarang= Carbon::now()->format('H:i');
                  $sisa_waktu = $tanggal_selesai->diff($tanggal_sekarang);
                  // $terlambat = $tanggal_sekarang->diff($tanggal_kembali);
                  $total_waktu = $tanggal_selesai->diff($tanggal_mulai);
                ?>
                @if($total_waktu->days >= 1)
                  <div class="card-body">
                    <div class="row">
                      <div class="col-6">
                        <h5>Tanggal Mulai :</h5>
                      </div>
                      <div class="col-6">
                        <h5>{{ Carbon::parse($order->tanggal_mulai)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</h5>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-6">
                        <h5>Tanggal Selesai :</h5>
                      </div>
                      <div class="col-6">
                        <h5>{{ Carbon::parse($order->tanggal_selesai)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</h5>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-6">
                        <h5>Jumlah Hari :</h5>
                      </div>
                      <div class="col-6">
                        <h5>{{ $total_waktu->days }} Hari</h5>
                      </div>
                    </div>
                  </div>
                @elseif($total_waktu->days < 1)
                  <div class="card-body">
                    <div class="row">
                      <div class="col-6">
                        <h5>Jam Mulai :</h5>
                      </div>
                      <div class="col-6">
                        <h5>{{ $tanggal_mulai->format('H.i') }} WIB</h5>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-6">
                        <h5>Jam Selesai :</h5>
                      </div>
                      <div class="col-6">
                        <h5>{{ $tanggal_selesai->format('H.i') }} WIB</h5>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-6">
                        <h5>Jumlah Jam :</h5>
                      </div>
                      <div class="col-6">
                        <h5>{{ $total_waktu->h }} Jam</h5>
                      </div>
                    </div>
                  </div>
                @endif
              </div>
            </div>
          </div>
          <div class="row justify-content-center align-items-center">
            <div class="col-8">
              <div class="card">
                <div class="card-header" style="background-color: #364a76">
                  <h3 style="color:white !important;">Profil Penyewa</h3>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-6">
                      <div class="align-items-center">
                        @if($order->tenant->foto != '')
                          <img src="{{ asset('storage/' . $order->tenant->foto) }}" style="width:180px; height:180px;" alt="">
                        @else
                          <img src="{{ asset('storage/tenant/no-pict.png') }}" style="width:180px; height:180px;" alt="">
                        @endif
                      </div>
                      <div class="col mt-4">
                        <h6 class="text-sm-start">Nama Penyewa:</h6>
                        <h4 class="mt--2">{{ $order->tenant->nama }}</h4>
                      </div>
                      <div class="col mt-3">
                        <h6 class="text-sm-start">Kontak:</h6>
                        <h4 class="mt--2">{{ $order->tenant->no_hp }}</h4>
                      </div>
                      <div class="col mt-3">
                        <h6 class="text-sm-start">Kontak Darurat:</h6>
                        <h4 class="mt--2">{{ $order->tenant->kontak_darurat }}</h4>
                      </div>
                    </div>
                    <div class="col-6">
                      <script>
                        $(function() {
                          $('.pop').on('click', function() {
                            $('.ktp-preview').attr('src',$(this).find('img').attr('src'));
                            $('#imagemodal').modal('show');
                            });
                        });
                      </script>
                      <div class="col mt-3">
                        <h6 class="text-sm-start">KTP:</h6>
                        <a href="#" class="pop" style="position: relative;">
                          <img class="rounded" src="{{ asset('file/ktp/' . $order->ktp) }}" style="width:180px; height:120px; z-index:1; position: relative;" alt="">
                          <div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow" style="width:60px; height:60px; z-index:2; position: absolute; top:-15px; right:60px">
                            <i class="ni ni-camera-compact"></i>
                          </div>
                        </a>
                        <div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                             <div class="modal-body">
                               <button type="button" class="close" data-dismiss="modal">
                                  <span aria-hidden="true">&times;</span>
                                  <span class="sr-only">Close</span>
                              </button>
                              <img src="" class="ktp-preview rounded" style="width: 100%;">
                             </div>
                           </div>
                          </div>
                        </div>
                      </div>
                      <div class="col mt-3">
                        <h6 class="text-sm-start">Surat Permohonan Penyewaan:</h6>
                        <a href="{{ route('downloadPermohonan', ['id' => $order->id]) }}">
                          <div class="contohgambar" style="position: relative;">
                            <img class="gambar1 mt--2" src="{{ asset('img/folder.png') }}" onmouseover="this.src='{{ asset('img/folder-hover.png') }}';" onmouseout="this.src='{{ asset('img/folder.png') }}';" style="width:180px; height:60px; position: relative; z-index: 1;" alt="">
                            <h5 style="position: absolute; z-index: 2; top: 0px; margin-left:10px;">Download file</h5>
                            <h6 style="position: absolute; z-index: 2; top: 25px; color: #9B9B9B; margin-left:10px;">{{ $order->surat_permohonan }}</h6>
                          </div>
                        </a>
                      </div>
                      <div class="col mt-3">
                        <h6 class="text-sm-start">Akta Notaris:</h6>
                        <a href="{{ route('downloadAkta', ['id' => $order->id]) }}">
                          <div class="contohgambar" style="position: relative;">
                            <img class="gambar1 mt--2" src="{{ asset('img/folder.png') }}" onmouseover="this.src='{{ asset('img/folder-hover.png') }}';" onmouseout="this.src='{{ asset('img/folder.png') }}';" style="width:180px; height:60px; position: relative; z-index: 1;" alt="">
                            <h5 style="position: absolute; z-index: 2; top: 0px; margin-left:10px;">Download file</h5>
                            <h6 style="position: absolute; z-index: 2; top: 25px; color: #9B9B9B; margin-left:10px;">{{ $order->akta_notaris }}</h6>
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
          @foreach ($detail as $detail)
            <div class="card" style="padding:16px;">
              <div class="row">
                <div class="col-md-4">
                  @if($detail->foto != '')
                    <img src="{{ asset('storage/' . $detail->foto) }}" style="width:120px; height:120px;">
                  @else
                    <img src="{{ asset('storage/equipments/no-pict.png') }}" style="width:120px; height:120px;">
                  @endif
                  <h5>{{ $detail->nama }}</h5>
                </div>
                <div class="col-md-4">
                    <h4><b>Tanggal</b></h4>
                    <div class="tes">
                      <p class="mt-3">Tanggal Mulai</p>
                      <h4 class="mt--4">{{ Carbon::parse($order->tanggal_mulai)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</h4>
                    </div>
                    <div class="tes">
                      <p>Tanggal Selesai</p>
                      <h4 class="mt--4">{{ Carbon::parse($order->tanggal_selesai)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</h4>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <h4><b>Jam</b></h4>
                    <div class="tes">
                      <p class="mt-3">Jam Mulai</p>
                      <h4 class="mt--4">{{ \Carbon\Carbon::parse($detail->tanggal_mulai)->format('H:i') }}                    </h4>
                    </div>
                    <div class="tes">
                      <p>Jam Selesai</p>
                      <h4 class="mt--4">{{ \Carbon\Carbon::parse($detail->tanggal_selesai)->format('H:i') }}</h4>
                    </div>
                  </div>
              </div>
              <?php
                  setlocale(LC_TIME, 'id_ID');
                  \Carbon\Carbon::setLocale('id');
                  \Carbon\Carbon::now()->formatLocalized("%A, %d %B %Y");
                  $tanggal_mulai = new DateTime($order->tanggal_mulai);
                  $tanggal_selesai = new DateTime($order->tanggal_selesai);
                  $harian = $tanggal_selesai->diff($tanggal_mulai);
                  $tanggal_kembali = new DateTime($detail->tanggal_kembali);
                  $tanggal_sekarang= Carbon::now();
                  $jam_sekarang= Carbon::now()->format('H:i');
                  $sisa_waktu = $tanggal_selesai->diff($tanggal_sekarang);
                  $terlambat = $tanggal_kembali->diff($tanggal_selesai);
                  $terlambat_belum_ambil = $tanggal_sekarang->diff($tanggal_selesai);
                  $total_waktu = $tanggal_selesai->diff($tanggal_mulai);
                ?>
              <script>
                function myFunction() {
                  var x;
                  var r = confirm("Kontrak Sudah Habis!");
                  if (r == true) {
                      x = "You pressed OK!";
                  }
                  else {
                      x = "You pressed Cancel!";
                  }
                  document.getElementById("demo").innerHTML = x;
                }
              </script>
              <div class="card-footer justify-content-end py-4">
                @if($detail->status === 'Belum Diambil')
                  <div class="col-12 text-right">
                    @if($tanggal_sekarang < $detail->tanggal_selesai)
                      <form action="{{ route('alatKeluar', ['id' => $detail->id]) }}">
                        <input type="hidden" name="tanggal_keluar" id="tanggal_keluar" value="{{ Carbon::now() }}">
                        <button type="submit" name="verifikasi" class="btn btn-success"><span class="ni ni-check-bold"></span>Alat Keluar</button>
                      </form>
                    @elseif($tanggal_sekarang >= $detail->tanggal_selesai)
                      <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal"><span class="ni ni-check-bold"></span>Alat Keluar</button>
                    @endif
                  </div>
                @elseif($detail->status === 'Sedang Dipakai')
                  <div class="col-12 text-right">
                    <h5>Diambil Pada: <b>{{ Carbon::parse($detail->tanggal_ambil)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</b> pukul <b>{{ Carbon::parse($detail->tanggal_ambil)->format('H:i:s') }}</b></h5>
                    @if($tanggal_sekarang < $detail->tanggal_selesai)
                      <h3 style="color: #ffd100">Sisa {{ $sisa_waktu->days }} hari {{ $sisa_waktu->h }} jam {{ $sisa_waktu->i }} menit</h3>
                      {{-- @if($total_waktu->days >= 1)
                        <h3>Sisa {{ $sisa_waktu->days }} hari</h3>
                      @elseif($total_waktu->days < 1)
                        <h3>Sisa {{ $sisa_waktu->h }} jam {{ $sisa_waktu->i }} menit</h3>
                      @endif --}}
                    @elseif($tanggal_sekarang > $detail->tanggal_selesai)
                      {{-- <h3 style="color: red">Terlambat {{ $terlambat_belum_ambil->days }} hari {{ $terlambat_belum_ambil->h }} jam</h3> --}}
                      @if($terlambat_belum_ambil->days >= 1)
                        <h3 style="color: red">Terlambat {{ $terlambat_belum_ambil->days }} hari</h3>
                      @elseif($terlambat_belum_ambil->h >= 1)
                        <h3 style="color: red">Terlambat {{ $terlambat_belum_ambil->h }} jam</h3>
                      @endif
                    @endif
                    <form action="{{ route('alatMasuk', ['id' => $detail->id]) }}">
                      <input type="hidden" name="tanggal_masuk" id="tanggal_masuk">
                      <button type="submit" name="verifikasi" class="btn btn-success"><span class="ni ni-check-bold"></span> Alat Kembali</button>
                    </form>
                  </div>
                @elseif($detail->status === 'Selesai')
                  <div class="col-12 text-right">
                    <h5>Diambil Pada: <b>{{ Carbon::parse($detail->tanggal_ambil)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</b> pukul <b>{{ Carbon::parse($detail->tanggal_ambil)->format('H:i:s') }}</b></h5>
                    <h5>Dikembalikan Pada: <b>{{ Carbon::parse($detail->tanggal_kembali)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</b> pukul <b>{{ Carbon::parse($detail->tanggal_kembali)->format('H:i:s') }}</b></h5>
                    @if($detail->tanggal_kembali > $detail->tanggal_selesai)
                      @if($harian->days >= 0)
                        @if($terlambat->days >= 1)
                          <h3 style="color: red">Terlambat {{ $terlambat->days }} hari {{ $terlambat->h }} jam</h3>
                        @elseif($terlambat->h >= 1)
                          <h3 style="color: red">Terlambat {{ $terlambat->h }} jam</h3>
                        @endif
                      @endif
                    @endif
                  </div>
                @endif
            </div>
            </div>
          @endforeach
      </div>
    </div>
  </div>
@endsection
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Kontrak sudah tidak berlaku!</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Masa kontrak telah habis.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
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