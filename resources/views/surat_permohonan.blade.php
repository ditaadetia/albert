<?php use Carbon\Carbon; ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Start your development with a Dashboard for Bootstrap 4.">
        <meta name="author" content="Creative Tim">
        <title>SI-ALBERT - UPTD Alat Berat PUPR Kota Pontianak</title>
        <!-- Icons -->
        <link rel="stylesheet" href="assets/vendor/nucleo/css/nucleo.css'" type="text/css">
        <!-- Page plugins -->
        <!-- Argon CSS -->
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/logo_kota_pontianak.png') }}">
        <script type="text/javascript" src="assets/js/terbilang.js"></script>
        <style>
            .p{
                margin-top: -14px;
            }
            .header {
                width: 100%;
                padding: 10px 0;
                border-bottom: 5px double;
                display: inline-block;
            }
            .judul {
                font-size: 14px;
                margin-top: -100px;
                margin-bottom: -10px;
            }
            .text-center {
                text-align: center;
            }
            .font12 {
                font-size: 12px;
            }
            .font24 {
                font-size: 18px;
            }
            table {
                width: 100%;
                color: #212121;
            }
            tr, td {
                padding: 8px!important;
            }
            .row {
                display: flex;

                flex-wrap: wrap;
            }
        </style>
        {{-- <link rel="stylesheet" href="assets/css/argon.css?v=1.2.0" type="text/css"> --}}
    <!-- jquery -->
</head>
<body>
    <p>Perihal &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : Permohonan Penyewaan Alat Berat/Komersil/Rutin/Dinas Lain/ Sosial Masyarakat</p>
    <p class="p">Hari/Tanggal : {{ Carbon::now()->locale('id')->isoFormat('dddd') }}, {{ Carbon::now()->isoFormat('D MMMM YYYY') }}</p>
    <p>Kepada Yth.</p>
    <p class="p">Kepala Dinas Pekerjaan Umum dan Penataan Ruang</p>
    <p class="p">Kota Pontianak</p>
    <p class="p">Cq. UPT Alat Berat</p>
    <p class="p">di-</p>
    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Pontianak</p>
    <p>Dengan Hormat,</p>
    <p class="p">Nama &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : {{$order1->nama}}</p>
    <p class="p">Alamat &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : {{$order1->alamat}}</p>
    <p class="p">Nama Instansi/Perusahaan &nbsp; : {{$order1->nama_instansi}}</p>
    <p class="p">Jabatan &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : {{$order1->jabatan}}</p>
    <p class="p">Alamat Instansi &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : {{$order1->alamat_instansi}}</p>
    <p class="p">No.Hp &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : {{$order1->no_hp}}</p>
    <p class="p">Kontak Darurat &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : {{$order1->kontak_darurat}}</p>
    <br>
    <p>Dengan ini kami mengajukan permohonan untuk menyewa alat berat diantaranya sebagai berikut:</p>
    <?php $no =0?>
    <center>
        <table border="1">
            <thead style="background: lightslategrey; heigh:5px;">
                <tr align="center">
                    <td>No.</td>
                    <td>Id Alat</td>
                    <td>Nama Alat</td>
                </tr>
            </thead>
            @foreach ($detail_orders as $detail_order)
                <?php $no++ ?>
                <tr>
                    <td align="center">{{ $no }}.</td>
                    <td align="center">{{ $detail_order->id}}</td>
                    <td align="center">{{ $detail_order->nama}}</td>
                </tr>
            @endforeach
        </table>
    </center>
    <p>Untuk Keperluan :</p>
    <?php
        if($order1->category_order_id == 1)
        {
            $status = 'Komersil';
        }
        elseif($order1->category_order_id == 2)
        {
            $status = 'Rutin';
        }
        elseif($order1->category_order_id == 3)
        {
            $status = 'Dinas Lain';
        }
        elseif($order1->category_order_id == 4)
        {
            $status = 'Sosial Masyarakat';
        }
    ?>
    <p class="p">{{ $status }}</p>
    <p>Nama Kegiatan :</p>
    <p class="p">{{ $order1->nama_kegiatan }}</p>
    <p>Kami bersedia mengikuti ketentuan yang berlaku sebagai bahan pertimbangan kami lampirkan</p>
    @if($order1->ktp != null || $order1->ktp!= '')
        <table>
            <tr>
                <td style="width: 5%"><img src="img/check.png" alt="" style="width:36px; height:36px;"></td>
                <td style="width: 95%"><p>KTP yang masih berlaku</p></td>
            </tr>
        </table>
    @else
        <table>
            <tr>
                <td style="width: 5%"><img src="img/uncheck.png" alt="" style="width:36px; height:36px;"></td>
                <td style="width: 95%"><p>KTP yang masih berlaku</p></td>
            </tr>
        </table>
    @endif
    @if($order1->akta_notaris != null || $order1->akta_notaris!= '')
        <table>
            <tr>
                <td style="width: 5%"><img src="img/check.png" alt="" style="width:36px; height:36px;margin-top: -20px"></td>
                <td style="width: 95%"><p style="margin-top: -20px">Akta Notaris (bagi yang berbadan hukum)</p></td>
            </tr>
        </table>
    @else
        <table>
            <tr>
                <td style="width: 5%"><img src="img/uncheck.png" alt="" style="width:36px; height:36px;margin-top: -20px"></td>
                <td style="width: 95%"><p style="margin-top: -20px">Akta Notaris (bagi yang berbadan hukum)</p></td>
            </tr>
        </table>
    @endif
    @if($order1->surat_ket != null || $order1->surat_ket!= '')
        <table>
            <tr>
                <td style="width: 5%"><img src="img/check.png" alt="" style="width:36px; height:36px; margin-top: -20px"></td>
                <td style="width: 95%"><p style="margin-top: -20px">Surat Pengantar dari RT/RW/Lurah</p></td>
            </tr>
        </table>
    @else
        <table>
            <tr>
                <td style="width: 5%"><img src="img/uncheck.png" alt="" style="width:36px; height:36px; margin-top: -20px"></td>
                <td style="width: 95%"><p style="margin-top: -20px">Surat Pengantar dari RT/RW/Lurah</p></td>
            </tr>
        </table>
    @endif
    <div class="kepala-uptd" style="margin-left: 35%; margin-top: -32px">
        <p style="text-align: center">Pemohon</p>
        <p style="text-align: center">(Penanggung Jawab Kegiatan)</p>
        @if($order1->ttd_pemohon == null || $order1->ttd_pemohon == '')
            <br><br>
        @else
            <center>
                <?php $path = public_path('storage');
                $pdf=$path . '/' . $order1->ttd_pemohon;?>
                <img src="{{ $pdf }}" alt="" style="width:60px; height:60px;">
            </center>
        @endif
        {{-- <p style="text-align: center">{{$order1->ttd_kepala_uptd}}</p> --}}
        <p style="text-align: center">{{$order1->nama}}</p>
    </div>
</body>
</html>