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
      {{-- <div class="card-header" style="padding-left: 280px; padding-right:280px"> --}}
        <div class="card-header">
          <div class="row">
            <div class="col-10">
              <h2><b>{{ $order->tenant->nama }}</b></h2>
            </div>
            <div class="col-2">
              <img src="{{ asset('img/logo_kota_pontianak.png') }}" style="float:right; width:70px; height:70px;" alt="">
            </div>
          </div>
        </div>
        <div class="card-body border-0">
        {{-- <div class="row" style="padding-left: 280px; padding-right:280px"> --}}
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
                  <div class="row align-items-center">
                    <div class="col-12 align-items-center text-center mb-3">
                      @if($order->tenant->foto != '')
                        <img src="{{ asset('storage/' . $order->tenant->foto) }}" style="width:180px; height:180px;" alt="">
                      @else
                        <img src="{{ asset('storage/tenant/no-pict.png') }}" style="width:180px; height:180px;" alt="">
                      @endif
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-6">
                      <div class="col mt-4">
                        <h6 class="text-sm-start">Nama Penyewa:</h6>
                        <h4 class="mt--2">{{ $order->tenant->nama }}</h4>
                      </div>
                      <div class="col mt-4">
                        <h6 class="text-sm-start">No. HP:</h6>
                        <h4 class="mt--2">{{ $order->tenant->no_hp }}</h4>
                      </div>
                      <div class="col mt-4">
                        <h6 class="text-sm-start">Kontak Darurat:</h6>
                        <h4 class="mt--2">{{ $order->tenant->kontak_darurat }}</h4>
                      </div>
                      <div class="col mt-4">
                        <h6 class="text-sm-start">Alamat:</h6>
                        <h4 class="mt--2">{{ $order->tenant->alamat }}</h4>
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
                      {{-- <div class="col mt-3">
                        <h6 class="text-sm-start">KTP:</h6>
                        <?php $ktp = trim($order->ktp, "ktp/"); ?>
                        <a href="#" class="pop" style="position: relative;">
                          <img class="rounded" src="{{ asset('storage/ktp/' . $ktp) }}" style="width:180px; height:120px; z-index:1; position: relative;" alt="">
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
                      </div> --}}
                      <div class="col mt-2">
                        <h6 class="text-sm-start">KTP:</h6>
                        <a href="{{ route('downloadKtp', ['id' => $order->id]) }}">
                          <div class="contohgambar" style="position: relative;">
                            <img class="gambar1 mt--2" src="{{ asset('img/folder.png') }}" onmouseover="this.src='{{ asset('img/folder-hover.png') }}';" onmouseout="this.src='{{ asset('img/folder.png') }}';" style="width:300px; height:60px; position: relative; z-index: 1;" alt="">
                            <h5 style="position: absolute; z-index: 2; top: 0px; margin-left:10px;">Download file</h5>
                            <?php $ktp = trim($order->ktp, 'ktp/'); ?>
                            <h6 style="position: absolute; z-index: 2; top: 25px; color: #9B9B9B; margin-left:10px;">{{ $ktp }}</h6>
                          </div>
                        </a>
                      </div>
                      <div class="col mt-3">
                        <h6 class="text-sm-start">Surat Permohonan Penyewaan:</h6>
                        <a href="{{ route('downloadPermohonan', ['id' => $order->id]) }}">
                          <div class="contohgambar" style="position: relative;">
                            <img class="gambar1 mt--2" src="{{ asset('img/folder.png') }}" onmouseover="this.src='{{ asset('img/folder-hover.png') }}';" onmouseout="this.src='{{ asset('img/folder.png') }}';" style="width:300px; height:60px; position: relative; z-index: 1;" alt="">
                            <h5 style="position: absolute; z-index: 2; top: 0px; margin-left:10px;">Download file</h5>
                            <?php $surat_permohonan = trim($order->surat_permohonan, 'surat_permohonan/'); ?>
                            <h6 style="position: absolute; z-index: 2; top: 25px; color: #9B9B9B; margin-left:10px;">{{ $surat_permohonan }}</h6>
                          </div>
                        </a>
                      </div>
                      @if($order->category_order_id =='1')
                        <div class="col mt-3">
                          <h6 class="text-sm-start">Akta Notaris:</h6>
                          <a href="{{ route('downloadAkta', ['id' => $order->id]) }}">
                            <div class="contohgambar" style="position: relative;">
                              <img class="gambar1 mt--2" src="{{ asset('img/folder.png') }}" onmouseover="this.src='{{ asset('img/folder-hover.png') }}';" onmouseout="this.src='{{ asset('img/folder.png') }}';" style="width:300px; height:60px; position: relative; z-index: 1;" alt="">
                              <h5 style="position: absolute; z-index: 2; top: 0px; margin-left:10px;">Download file</h5>
                              <?php $akta_notaris = trim($order->akta_notaris, 'akta_notaris/'); ?>
                              <h6 style="position: absolute; z-index: 2; top: 25px; color: #9B9B9B; margin-left:10px;">{{ $akta_notaris }}</h6>
                            </div>
                          </a>
                        </div>
                      @endif
                      @if($order->category_order_id =='4')
                        <div class="col mt-3">
                          <h6 class="text-sm-start">Surat Pengantar dari RT/RW/Lurah:</h6>
                          <a href="{{ route('downloadSuratPengantar', ['id' => $order->id]) }}">
                            <div class="contohgambar" style="position: relative;">
                              <img class="gambar1 mt--2" src="{{ asset('img/folder.png') }}" onmouseover="this.src='{{ asset('img/folder-hover.png') }}';" onmouseout="this.src='{{ asset('img/folder.png') }}';" style="width:300px; height:60px; position: relative; z-index: 1;" alt="">
                              <h5 style="position: absolute; z-index: 2; top: 0px; margin-left:10px;">Download file</h5>
                              <?php $surat_ket = trim($order->surat_ket, 'surat_ket/'); ?>
                              <h6 style="position: absolute; z-index: 2; top: 25px; color: #9B9B9B; margin-left:10px;">{{ $surat_ket }}</h6>
                            </div>
                          </a>
                        </div>
                      @endif
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
                <div class="col-md-4 mt-5">
                  <h4><b>Jumlah</b></h4>
                  @if( $total_waktu->days)
                    <div class="tes">
                      <p class="mt-3">Jumlah hari sewa</p>
                      <h4 class="mt--4">{{ $total_waktu->days }} X {{ 'Rp. ' . number_format($detail->harga_sewa_perhari, 2, ",", ".") }}</h4>
                    </div>
                  @else
                    <div class="tes">
                      <p>Jumlah jam sewa</p>
                      <h4 class="mt--4">{{ $total_waktu->h }} X {{ 'Rp. ' . number_format($detail->harga_sewa_perjam, 2, ",", ".") }}</h4>
                    </div>
                  @endif
                </div>
                <div class="col-md-4 text-right mt-5" style="padding-right:30px">
                  <h4><b>Total</b></h4>
                  @if($total_waktu->days)
                    <div class="tes">
                      <h4 class="mt-4">{{ 'Rp. ' . number_format($total_waktu->days * $detail->harga_sewa_perhari, 2, ",", ".") }}</h4>
                    </div>
                  @else
                    <div class="tes">
                      <h4 class="mt-4">{{ 'Rp. ' . number_format($total_waktu->h * $detail->harga_sewa_perjam, 2, ",", ".") }}</h4>
                    </div>
                  @endif
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col-6">
                  <h5>Total</h5>
                </div>
                <div class="col-6 text-right mt-5" style="padding-right:30px">
                  <?php
                    if($total_waktu->days){
                      $jumlah = $total_waktu->days * $detail->harga_sewa_perhari;
                    }else{
                      $jumlah = $total_waktu->h * $detail->harga_sewa_perjam;
                    }
                    $total = $jumlah + $total;
                  ?>
                  <h3><b>{{ 'Rp. ' . number_format($jumlah, 2, ",", ".") }}</b></h3>
                </div>
              </div>
            </div>
          @endforeach
          <div class="row">
            <div class="col-6">
              <h5>Total yang harus dibayar</h5>
            </div>
            <div class="col-6 text-right">
              <h3 style="padding-right:30px"><b>{{ 'Rp. ' . number_format($total, 2, ",", ".") }}</b></h3>
            </div>
          </div>
        <div class="card-footer justify-content-end py-4">
          <div class="col-12 text-right">
            @can('admin')
              @if($order->ket_verif_admin === 'belum')
                <form action="{{ route('verifAdmin', ['id' => $order->id]) }}">
                  <button type="submit" name="verifikasi" class="btn btn-success"><span class="ni ni-check-bold"></span> Setujui Permohonan</button>
                  <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="Penolakan Pengajuan"><span class="ni ni-fat-remove"></span> Tolak Permohonan</button>
                </form>
              @endif
            @endcan
            @can('kepala_uptd')
              @if($order->ket_persetujuan_kepala_uptd === 'belum')
                <form action="{{ route('setujuKepalaUPTD', ['id' => $order->id]) }}">
                  <button type="submit" class="btn btn-success"><span class="ni ni-check-bold"></span> Setujui Permohonan</button>
                  <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="Penolakan Pengajuan"><span class="ni ni-fat-remove"></span> Tolak Permohonan</button>
                </form>
              @endif
            @endcan
            @can('kepala_dinas')
              @if($order->ket_persetujuan_kepala_dinas === 'belum')
                <form action="{{ route('setujuKepalaDinas', ['id' => $order->id]) }}">
                  <button type="submit" class="btn btn-success"><span class="ni ni-check-bold"></span> Verifikasi Pengajuan</button>
                  <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="Penolakan Pengajuan"><span class="ni ni-fat-remove"></span> Tolak Permohonan</button>
                </form>
              @endif
            @endcan
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Penolakan pengajuan penyewaan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  @can('admin')
                    <form action="{{ route('tolakAdmin', ['id' => $order->id]) }}" method="POST" class="well" id="block-validate">
                  @endcan
                  @can('kepala_uptd')
                    <form action="{{ route('tolakKepalaUPTD', ['id' => $order->id]) }}" method="POST" class="well" id="block-validate">
                  @endcan
                  @can('kepala_dinas')
                    <form action="{{ route('tolakKepalaDinas', ['id' => $order->id]) }}" method="POST" class="well" id="block-validate">
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