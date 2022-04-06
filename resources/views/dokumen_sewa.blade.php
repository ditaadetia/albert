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
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/logo_pupr.jpeg') }}">
        <script type="text/javascript" src="assets/js/terbilang.js"></script>
        <style>
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

                margin-right: -15px;
                margin-left: -15px;

                flex-wrap: wrap;
            }
        </style>
        {{-- <link rel="stylesheet" href="assets/css/argon.css?v=1.2.0" type="text/css"> --}}
    <!-- jquery -->
</head>
<body>
    {{-- <script>window.open('#', '_blank');</script> --}}
    <div class="container"  style="border: 10px double rgb(49, 48, 48); border-radius:80px; padding: 30px 60px 30px 60px">
        <center>
            <img src="img/Logo-Kota-Pontianak-Hitam.jpg" alt="" style="width:140px; height:130px;">
            <h2><b>PEMERINTAH KOTA PONTIANAK</b>&nbsp; <b>DINAS PEKERJAAN UMUM DAN PENATAAN RUANG</b></h2>
            <div class="line" style="border-bottom: 3px double;"></div>
            <br>
            <br>
            <div class="line" style="border-bottom: 3px double;"></div>
            <h5><b>Alamat Jalan Achmad Yani Pontianak 78121 Telp. (0561)732300 Fax. (0561) 747329</b></h5>
            <h2 style="text-decoration: underline; margin-top:40px;"><b>DRAF SURAT PERJANJIAN PENYEWAAN PERALATAN</b></h2>
            <h3>Nomor : <b style="color: slategray">{{ $order->id }}/SPPP/D.PUPR-UPT/2021</b></h3>
            <h3>Tanggal: <b style="color: slategray">{{ Carbon::now()->isoFormat('D MMMM YYYY') }}</b></h3>
            <h3><b>ANTARA :</b></h3>
            <h2><b>DINAS PEKERJAAN UMUM DAN PENATAAN RUANG</b></h2>
            <h3><b>DENGAN :</b></h3>
            <h2>CV. <b style="color: slategray">{{ $order->nama_instansi }}</b></h2>
            <h3><b>PEKERJAAN :</b></h3>
            <h2>Jalan <b style="color: slategray">{{ $order->nama_kegiatan }}</b></h2>
            <h2>NILAI SEWA / KONTRAK ALAT BERAT</h2>
            <?php $no =0; $total = 0 ?>
            <?php
                $tanggal_mulai = new DateTime($order->tanggal_mulai);
                $tanggal_selesai = new DateTime($order->tanggal_selesai);
                $total_waktu = $tanggal_selesai->diff($tanggal_mulai);
            ?>
            @foreach ($detail_orders as $detail_order)
                <?php $no++ ?>
                <?php
                    $harga_hari = $total_waktu->days * $detail_order->harga_sewa_perhari;
                    $harga_jam = $total_waktu->h * $detail_order->harga_sewa_perjam;
                    $jumlah = $harga_hari + $harga_jam;
                    $total = $total + $jumlah;

                ?>
            @endforeach
            <textarea><h2><b>{{ 'Rp. ' . number_format($total, 2, ",", ".") }}</b></h2></textarea>
        </center>
    </div>
    <div class="page2" style="padding-left: 30px; text-align:justify;">
        <div class="row">
            <div class="header">
                <img src="img/Logo-Kota-Pontianak.jpg" alt="" style="width:100px; height:90px;">
                <h5 class="judul text-center">PEMERINTAH KOTA PONTIANAK<br><b><span class="font24">DINAS PEKERJAAN UMUM DAN PENATAAN RUANG</span></b><br><small>Alamat Jalan A. Yani Telpon : +62561-732300 Fax : +62561-747329</small><br><span class="font12"><b>PONTIANAK - KALBAR</b><span></h5>
            </div>
        </div>
        <center>
            <div class="col-6" style="border-bottom: 5px double; margin:0px 70px 0px 70px;">
                <h3><b>SURAT PERJANJIAN PENYEWAAN PERALATAN</b></h3>
            </div>
            <p>Nomor : <b style="color: slategray">{{ $order->id }}/SPPP/D.PUPR-UPT/2021</b></p>
            <p style="margin-top:-10px">Tanggal: <b style="color: slategray">{{ Carbon::now()->isoFormat('D MMMM YYYY') }}</b></p>
            <h4><b>T E N T A N G</b></h4>
            <h3><b>PENYEWAAN</b></h3>
        </center>
        <p>Pada hari ini, <b>{{ Carbon::now()->locale('id')->isoFormat('dddd') }},</b> Tanggal <b>{{ Carbon::now()->format('d') }}</b> Bulan <b>{{ Carbon::now()->isoFormat('MMMM') }}</b> Tahun <b>{{ Carbon::now()->format('Y') }}</b>, kami yang bertanda tangan dibawah ini :</p>
        &nbsp;
        <ol>
            <li>
                <p style="margin-top: -1px">Nama &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp; : <b> {{ $kepala_uptd->name }} </b></p>
                <p>Jabatan &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : Kepala UPT Alat Berat Dinas PUPR Kota Pontianak </p>
                <p>Alamat &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : Jl. A. Yani Telp (0561) 732300 Pontianak. <br>
            </li>
            <p>Yang dalam hal ini bertindak dan atas nama Pemerintah Kota Pontianak (Dinas Pekerjaan Umum Dan Penataan Ruang Kota Pontianak ), selanjutnya dalam perjanjian ini disebut <b>PIHAK PERTAMA</b><p>
            <br>
            <li>
                <p style="margin-top: -1px">Nama &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp; : <b>{{ $order1->nama }} </b></p>
                <p>Nama Bidang Hukum &nbsp; &nbsp; &nbsp; &nbsp;: {{ $order->nama_instansi }} </p>
                <p>Alamat &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : Jl. A. Yani Telp (0561) 732300 Pontianak. <br>
            </li>
            <p>Yang didirikan dengan Akte Notaris : <br>Dalam hal ini bertindak atas nama Direktur CV. {{ $order->nama_instansi }} yang selanjutnya dalam perjanjian ini disebut sebagai <b>PIHAK KEDUA.</b></p>
        </ol>
        <br>
        <p>Kedua belah pihak telah sepakat untuk melaksanakan ikatan perjanjian dengan berdasarkan : </p>
        &nbsp;<ol>
            <li>
                <p style="margin-top: -1px">Surat Permohonan CV. {{ $order->nama_instansi }} Nomor. / CV-TG / V/ 2021 Tanggal {{ $order->created_at->format('d F Y') }} perihal Permohonan Pinjam Pakai Alat Berat (Sewa menyewa).</p>
            </li>
            <li>
                <p style="margin-top: -1px">Surat Kepala Dinas Pekerjaan Umum dan Penataan Ruang Kota Pontianak No. / / D-PUPR.UPT Tanggal Perihal Persetujuan Pinjam Pakai Alat Berat (Sewa menyewa)</p>
            </li>
        </ol>
    </div>
    <div class="page3" style="padding-left: 30px; text-align:justify;">
        <center>
            <P><b>Telah sepakat untuk melaksanakan ikatan perjanjian dengan ketentuan-ketenruan sebagai-berikut :</b></P>
            <p><b>Pasal 1<br>JENIS, JUMLAH JANGKA WAKTU, DAN BIAYA PENYEWAN PERALATAN</b></p>
        </center>
        <ol style="margin-top: 20px">
            <li>
                <p style="margin-top: -1px"><b>PIHAK PERTAMA</b> menyewakan kepada <b>PIHAK KEDUA,</b> dan <b>PIHAK KEDUA</b> menyewa dari <b>PIHAK PERTAMA</b> peralatan dengan jenis, jumlah, jangka waktu, dan biaya penyewaan peralatan sebagai berikut :</p>
            </li>
            <table border="1" style="margin-left: -30px;">
                <thead style="background: lightslategrey; heigh:5px;">
                    <tr align="center">
                        <td rowspan="2"><h6><b>NO.</b></h6></td>
                        <td rowspan="2"><h6><b>JENIS PERALATAN</b></h6></td>
                        <td rowspan="2"><h6><b>MERK/TYPE</b></h6></td>
                        <td rowspan="2"><h6><b>KODE ALAT</b></h6></td>
                        <td rowspan="2"><h6><b>K.U.P</b></h6></td>
                        <td rowspan="2"><h6><b>JANGKA WAKTU HARI</b></h6></td>
                        <td rowspan="2"><h6><b>JANGKA WAKTU JAM</b></h6></td>
                        <td colspan="3"><h6><b>TOTAL BIAYA PENYEWAAN</b></h6></td>
                    </tr>
                    <tr align="center">
                        <td><h6><b>TARIF PERHARI</b></h6></td>
                        <td><h6><b>TARIF PERJAM</b></h6></td>
                        <td><h6><b>Total</b></h6></td>
                    </tr>
                </thead>
                <?php $no =0; $total = 0 ?>
                <?php
                    $tanggal_mulai = new DateTime($order->tanggal_mulai);
                    $tanggal_selesai = new DateTime($order->tanggal_selesai);
                    $total_waktu = $tanggal_selesai->diff($tanggal_mulai);
                ?>
                @foreach ($detail_orders as $detail_order)
                    <?php $no++ ?>
                    <tr>
                        <td>{{ $no }}</td>
                        <td>{{ $detail_order->nama }}</td>
                        <td>{{ $detail_order->jenis }}</td>
                        <td>{{ $detail_order->id }}</td>
                        <td></td>
                        <td>{{ $total_waktu->days }}</td>
                        <td>{{ $total_waktu->h }}</td>
                        <td><h6>{{ 'Rp. ' . number_format($detail_order->harga_sewa_perhari, 2, ",", ".") }}</h6></td>
                        <td><h6>{{ 'Rp. ' . number_format($detail_order->harga_sewa_perjam, 2, ",", ".") }}</h6></td>
                        <?php
                            $harga_hari = $total_waktu->days * $detail_order->harga_sewa_perhari;
                            $harga_jam = $total_waktu->h * $detail_order->harga_sewa_perjam;
                            $jumlah = $harga_hari + $harga_jam;
                            $total = $total + $jumlah;

                        ?>
                        <td><h6>{{ 'Rp. ' . number_format($jumlah, 2, ",", ".") }}</h6></td>
                    </tr>
                @endforeach
                <tr>
                    <td></td>
                    <td colspan="6"><h5><b>JUMLAH</b></h5></td>
                    <td colspan="3" align="center"><h3><b>{{ 'Rp. ' . number_format($total, 2, ",", ".") }}</b></h3></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="1"><h5><b>TERBILANG</b></h5></td>
                    <td colspan="8"><h3 align="center"><b><?php $terbilang = new Nasution\Terbilang(); echo $terbilang->convert($total) ?> rupiah</b></h3></td>
                </tr>
            </table>
            @if($total_waktu->days >= 1)
                <li style="margin-top:30px;">
                    <p style="margin-top:-1px">Jangka Waktu Penyewaan Peralatan untuk Kegiatan Pekerjaan {{ $order->nama }} selama <b>{{ $total_waktu->days }} HARI</b> Penggunaan Alat Berat Tanggal <b>{{ $tanggal_mulai->format('d F Y') }}</b> Sampai Dengan <b>{{ $tanggal_selesai->format('d F Y') }}</b></p>
                </li>
            @elseif($total_waktu->days < 1)
                <li style="margin-top:30px;">
                    <p style="margin-top:-1px">Jangka Waktu Penyewaan Peralatan untuk Kegiatan Pekerjaan {{ $order->nama }} selama <b>{{ $total_waktu->h }} JAM</b> Penggunaan Alat Berat Tanggal <b>{{ $tanggal_mulai->format('d F Y') }}</b> Jam {{ $tanggal_mulai->format('H.i') }} Sampai Dengan <b>{{ $tanggal_selesai->format('H.i') }}</b></p>
                </li>
            @endif
            <li>
                <p style="margin-top: -1px;">Biaya Penyewaan Peralatan sesuai dengan tabel diatas atau sebesar <b>{{ 'Rp. ' . number_format($total, 2, ",", ".") }} ( <?php $terbilang = new Nasution\Terbilang(); echo $terbilang->convert($total) ?> rupiah).</b></p>
            </li>
            <li>
                <p style="margin-top: -1px">Perubahan jangka waktu penyerahan, perubahan dalam jumlah jenis, merk / type peralatan serta penyempurnaan - penyempurnaan lainnya hanya dapat dilakukan dengan Amandemen / Addendum terhadap surat perjanjian ini.</p>
            </li>
        </ol>
        <div class="page4" style="padding:20px; text-align:justify;">
            <center>
                <p style="margin-top: 30px"><b>Pasal 2<br>REFERENSI SURAT PERJANJIAN PENYEWAAN PERALATAN</b></p>
            </center>
            <p>Penyewaan Peralatan tersebut dalam Pasal 1 diatas dilaksanakan oleh <b>PIHAK KEDUA</b> atas referensi sebagaimana tersebut dibawah ini, yang merupakan bagian yang tidak terpisahkan dari Perjanjian ini yaitu :</p>
            <ol>
                <li>
                    <p style="margin-top: -1px">Undang - undang No. 27 Tahun 1959 tentang penetapan Undang - undang Darurat No. 3 Tahun 1953 Tentang Pembentukan Daerah Tingkat II di Kalimantan ( lembaran Negara Tahun 1953 No. 9 ) sebagai Undang - undang ( Lembaran Negara Tahun 1959 No. 72 , Tambahan Lembaran Negara No. 1820);</p>
                </li>
                <li>
                    <p style="margin-top: -1px">Undang - undang No. 18 Tahun 1997 tentang Pajak Daerah dan Retribusi Daerah (Lembaran Negara Republik Indonesia Tahun 1997 Nomor 41, Tambahan Lembaran Negara Republik Indonesia Nomor 3480) sebagaimana telah diubah dengan Undang-undang Nomor 34 Tahun 2000 (Lembaran Negara Republik Indonesia Tahun 2000 Nomor 246, Tambahan Lembaran Negara Republik Indonesia Nomor 4048);</p>
                </li>
                <li>
                    <p style="margin-top: -1px"><p>Peraturan Pemerintah Nomor 66 Thun 2001 tentang Retribusi Daerah ( Lembaran Negara Republik Indonesia Tahun 2001 Nomor 119, Tambahan Lembaran Negara Republik Indonesia Nomor 4139);</p></p>
                </li>
                <li>
                    <p style="margin-top: -1px">Peraturan Pemerintah Nomor 6Tahun 2006 tentang pengelolaan barang milik negara/daerah;</p>
                </li>
                <li>
                    <p style="margin-top: -1px">Peraturan Menteri Dalam Negeri Nomor 17 Tahun 2007 tentang Pedoman Teknis Pengelolaan Barang Milik Daerah;</p>
                </li>
                <li>
                    <p style="margin-top: -1px">Peraturan Daerah Nomor 11 Tahun 2010 tanggal 28 Desember 2010 tentang Pedoman Teknis Pengelolaan Barang Milik Daerah;</p>
                </li>
                <li>
                    <p style="margin-top: -1px">Peraturan Walikota Pontianak Nomor 56 Tahun 2010 tanggal 30 Desember 2010 tentang Penjabaran Anggaran Pendapatan dan Belanja Daerah (APBD) Kota Pontianak Tahun Anggaran 2011;</p>
                </li>
                <li>
                    <p style="margin-top: -1px">Peraturan Daerah Kota Pontianak Nomor 9 Tahun 2009 tanggal 29 September 2009 Tentang Perubahan Kedua Atas Peraturan daerah Nomor 15 Tahun 2001 Tentang Retribusi Pemakaian Kekayaan Daerah;</p>
                </li>
                <li>
                    <p style="margin-top: -1px">Keputusan Walikota Pontianak Nomor 11 Tahun 2011 tentang Pejabat yang ditunjuk sebagai Bendahara Penerima, Bendahara Pengeluaran SKPD dan SKPKD serta Atasan Langsung dilingkungan Pemerintah Kota Pontianak Tahun Anggaran 2011;</p>
                </li>
                <li>
                    <p style="margin-top: -1px">Surat Permohonan CV. {{ $order->nama_instansi }} Nomor  / CV_TG / V / 2021 tanggal perihal Permohonan Pinjam Pakai Alat Berat (Sewa Menyewa)</p>
                </li>
                <li>
                    <p style="margin-top: -1px">Surat Kepala Dinas Pekerjaan Umum dan Penataan Ruang Kota Pontianak No. / / D-PUPR.UPT Tanggal . Perihal Persetujuan Pinjam Pakai Alat Berat (Sewa Menyewa).</p>
                </li>
                <li>
                    <p style="margin-top: -1px">Untuk melaksanakan penggunaan, Pemeliharaan peralatan dan lain-lain secara terperinci, Pihak Kedua berpedoman pada ketentuan-ketentuan yang telah ditetapkan oleh Pihak Pertama / petunjuk tertulis yang diberikan oleh Pihak Pertama.</p>
                </li>
            </ol>
            <center>
                <p style="margin-top: 30px"><b>Pasal 3<br>PENYERAHAN DAN PENGEMBALIAN PERALATAN</b></p>
            </center>
            <ol>
                <li>
                    <p style="margin-top: -1px">Pihak Pertama kan menyerahkan peralatan tersebut dalam pasal I kepada Pihak Kedua dan Pihak Kedua menerima peralatan tersebut dari Pihak Pertama dalam keadaan baik, lengkap, dan siap pakai.</p>
                </li>
                <li>
                    <p style="margin-top: -1px">Setelah habis jangka waktu penyewaan peralatan harus segera mengembalikan peralatan bersangkutan kepada pihak Pertama dalam keadaan baik, lengkap dan siap pakai kembali.</p>
                </li>
                <li>
                    <p style="margin-top: -1px">Apabila pihak kedua mengembalikan peralatan dalam keadaan rusak kepada Pihak Pertama, maka Pihak Kedua berkewajiban melaksanakan perbaikan peralatan dalam jangka waktu 30 (tiga puluh) hari kalender.</p>
                </li>
            </ol>
            <center>
                <p style="margin-top: 30px"><b>Pasal 4<br>BIAYA OPERASI DAN BIAYA PEMELIHARAAN</b></p>
            </center>
            <ol>
                <li>
                    <p style="margin-top: -1px">Selama jangka waktu penyewaan peralatan, biaya operasi dan biaya pemeliharaan (perawatan dan perbaikan) tingkat I (PTK I) tingkat II (PTK II) tingkat IV (PTK) s/d Tingkat IV (Ptk IV) menjadi tanggung jawab Pihak Kedua.
                </li>
                <li>
                    <p style="margin-top: -1px">Ketentuan atau penyerahan dalam pemeliharaan (perawatan dan perbaikan), pemakaian bahan bakar, bahan pelumas, dan minyak hidrolik harus sesuai dengan petunjuk Pihak Pertama.</p>
                </li>
                <li>
                    <p style="margin-top: -1px">Biaya perbaikan terhadap kerusakan berat ataupun kehilangan yang diakibatkan oleh kelalaian Pihak kedua, seluruhnya menjadi tanggung jawab Pihak Kedua.</p>
                </li>
            </ol>
            <center>
                <p style="margin-top: 30px"><b>Pasal 5<br>PEMBAYARAN PENYEWAAN PERALATAN KE KAS DAERAH</b></p>
            </center>
            <ol>
                <li>
                    <p style="margin-top: -1px">Biaya Penyewaan peralatan sesuai dengan pasal 1 ayat 1, 2, dan 3 ditetapkan dengan Surat Ketetapan Retribusi (SKR) yang diterbitkan sejak Surat Perjanjian Penyewaan Peralatan ini ditandatangani.</p>
                </li>
                <li>
                    <p style="margin-top: -1px">Pembayaran Penyewaan Peralatan sesuai dengan ayat 1 pasal ini adalah sebesar <b>{{ 'Rp. ' . number_format($total, 2, ",", ".") }} ( <?php $terbilang = new Nasution\Terbilang(); echo $terbilang->convert($total) ?> rupiah).</b></p>
                </li>
                <li>
                    <p style="margin-top: -1px">Pihak Kedua harus sudah membayar seluruh jumlah biaya penyewaan peralatan tersebut dalam ayat 2 pasal ini ke Kas Daerah sebagai penerimaan Daerah melalui Bendahara Penerimaan Dinas Pekerjaan Umum Dan Penataan Ruang Kota Pontianak.</p>
                </li>
                <li>
                    <p style="margin-top: -1px">Apabila pembayaran Surat Ketetapan Retribusi (SKR) ini tidak atau kurang dibayar lewat paling lama 30 hari setelah SKR diterima (tanggal jatuh tempo) dikenakan sanksi administrasi berupa bunga sebesar 2% per bulan.</p>
                </li>
            </ol>
            <center>
                <p style="margin-top: 30px"><b>Pasal 6<br>PENGGUNAAN DAN PEMELIHARAAN PERALATAN</b></p>
            </center>
            <ol>
                <li>
                    <p style="margin-top: -1px">Pihak Kedua dilarang menggunakan peralatan tersebut dalam Pasal I untuk pekerjaan diluar ketentuan yang tersebut dalam surat perjanjian peralatan diatas.</p>
                </li>
                <li>
                    <p style="margin-top: -1px">Pihak Kedua dilarang memindah tangankan hak penyewaan peralatan tersebut dalam Pasal I kepada Pihak Lain kecuali dengan persetujuan tertulis dari Pihak Pertama.</p>
                </li>
                <li>
                    <p style="margin-top: -1px">Pihak Kedua dilarang mengubah bentuk peralatan dan atau fungsi penggunaan peralatan tersebut dalam Pasal I kecuali dengan persetujuan tertulis Pihak Pertama.</p>
                </li>
                <li>
                    <p style="margin-top: -1px">Pihak Kedua wajib melakukan pemeliharaan peralatan sesuai petunjuk Pihak Pertama.</p>
                </li>
            </ol>
            <center>
                <p style="margin-top: 30px"><b>Pasal 7<br>OPERATOR DAN MEKANIK</b></p>
            </center>
            <ol>
                <li>
                    <p style="margin-top: -1px">Operator dan Mekanik untuk peralatan tersebut pada Pasal I diutamakan menggunakan Operator dan Mekanik Pihak Pertama</p>
                </li>
                <li>
                    <p style="margin-top: -1px">Operator dan Mekanik Pihak Pertama yang diperbantukan kepada Pihak Kedua menjadi tanggung jawab Pihak Kedua.</p>
                </li>
                <li>
                    <p style="margin-top: -1px">Operator dan Mekanik untuk peralatan dalam Pasal I yang disediakan Pihak Kedua harus berkemampuan baik / mempunyai SIMP yang diperoleh dari Dinas Pekerjaan Umum Dan Penataan Ruang Provinsi Kalbar atau dari instansi yang berwenang.</p>
                </li>
                <li>
                    <p style="margin-top: -1px">Pihak Pertama berhak menarik kembali persetujuan tersebut dalam Pasal I apabila terbukti bahwa operator dan mekanik Pihak Kedua melakukan kesalahan yang menurut Pihak Pertama merusak peralatan / mengurangi nilai peralatan tersebut.</p>
                </li>
                <li>
                    <p style="margin-top: -1px">Apabila Kedua belah Pihak bersepakat bahwa sebagian atau seluruhnya operator dan mekanik disediakan oleh Pihak Pertama, maka Pihak Pertama akan menyediakan operator dan mekanik bersangkutan sesuai peraturan dan prosedur yang berlaku.</p>
                </li>
                <li>
                    <p style="margin-top: -1px">Biaya Operator dan mekanik menjadi tanggung jawab Pihak Kedua.</p>
                </li>
            </ol>
            <center>
                <p style="margin-top: 30px"><b>Pasal 8<br>KESELAMATAN KERJA</b></p>
            </center>
            <ol>
                <li>
                    <p style="margin-top: -1px">Pihak Kedua wajib melakukan usaha - usaha agar terjamin keselamatan kerja dilingkungannya dengan menyediakan fasilitas tabung pemadam kebakaran, dan obat - obatan P3K.</p>
                </li>
                <li>
                    <p style="margin-top: -1px">Pihak Kedua wajib bertanggung jawab atas kecelakaan yang dialami para personil yang dipekerjakan, dengan memberikan tuntutan ganti rugi yang disebabkan cacat atau kematian dan sebab lainnya sesuai dengan peraturan perundang - undangan yang berlaku.</p>
                </li>
            </ol>
            <center>
                <p style="margin-top: 30px"><b>Pasal 9<br>PENGAWASAN</b></p>
            </center>
            <ol>
                <li>
                    <p style="margin-top: -1px"><b>Pihak Pertama</b> menempatkan wakil ditempat yang cakap dan mampu serta berkuasa penuh atas persetujuan <b>Pihak Perrtama</b> untuk melakukan pengawasan penggunaan, pemeliharaan, dan pengadministrasian peralatan tersebut pada Pasal I.</p>
                </li>
                <li>
                    <p style="margin-top: -1px">Biaya yang ditimbulkan akibat pelaksanaan pengawasan menjadi Tanggung Jawab Pihak Pertama.</p>
                </li>
            </ol>
            <center>
                <p style="margin-top: 30px"><b>Pasal 10<br>KEADAAN MEMAKSA (FORCE MEJEURE)</b></p>
            </center>
            <ol>
                <li>
                    <p style="margin-top: -1px">Yang dimaksud dalam keadaan memaksa adalah keadaan atau peristiwa yang nyata - nyata ada diluar kekuasaan <b>Pihak Kedua</b> seperti: Banjir, Gempa Bumi, tanah longsor dan banjir, kebakaran yang bukan diakibatkan oleh kecerobohan <b>Pihak Kedua</b>, perang, huru - hara, pemogokan, dan pemberontakan epidemi.</p>
                </li>
            </ol>
            <center>
                <p style="margin-top: 30px"><b>Pasal 11<br>SANKSI DAN DENDA</b></p>
            </center>
            <ol>
                <li>
                    <p style="margin-top: -1px">Jika dalam waktu yang telah ditetapkan pada perjanjian ini, seperti tersebut dalam pasal 1 maka untuk keterlambatan setiap harinya Pihak Kedua dikenakan Denda sebesar tarip sewa perhari dari harga sewa peralatan yang belum dikembalikan.</p>
                </li>
                <li>
                    <p style="margin-top: -1px">Apabila Pihak Kedua lalai atau dipandang tidak dapat memenuhi syarat - syarat yang ditentukan / ditetapkan dalam surat perjanjian ini, serta tidak mengindahkan ketentuan dan petunjuk  Pihak Pertama, Pihak Pertama berhak membatalkan Surat Perjanjian ini secara sebelah Pihak.</p>
                </li>
            </ol>
            <center>
                <p style="margin-top: 30px"><b>Pasal 12<br>TEMPAT KEDUDUKAN</b></p>
            </center>
            <p>Segala akibat yang terjadi dari pelaksanaan Surat Perjanjian ini, Kedua Belah Pihak telah memilih tempat kedudukan (domisili) yang tetap dan sah salam kantor kepaniteraan Pengadilan Negeri Pontianak.</p>
            <center>
                <p style="margin-top: 30px"><b>Pasal 13<br>LAIN LAIN</b></p>
            </center>
            <ol>
                <li>
                    <p style="margin-top: -1px">Segala sesuatu yang belum diatur dalam Surat Perjanjian Kerja ini akan diatur dalam Surat Perjanjian tambahan (Addendum) yang menjadi kesatuan dalam perjanjian ini.</p>
                </li>
                <li>
                    <p style="margin-top: -1px">Surat Perjanjian ini dibuat dalam rangkap 2 (dua) asli bermaterai cukup yang mempunyai kekuatan hukum yang sama untuk Pihak Pertama dan Pihak Kedua, selebihnya diberikan kepada Pihak - pihak yang berkepentingan dan ada hubungan pekerjaan ini.</p>
                </li>
            </ol>
            <center>
                <p style="margin-top: 30px"><b>Pasal 14<br>PENUTUP</b></p>
            </center>
            <ol>
                <li>
                    <p style="margin-top: -1px">Surat Perjanjian ini ditandatangani oleh kedua belah pihak di Pontianak, pada hari dan tanggan tersebut diatas dan ditandatangani oleh pejabat yang berwenang.</p>
                </li>
                <li>
                    <p style="margin-top: -1px">Surat Perjanjian ini dinyatakan berlaku sejak ditandatangani.</p>
                </li>
            </ol>
            <p>Demikian Surat Perjanjian Penyewaan Peralatan ini dibuat untuk dipergunakan sebagaimana mestinya.</p>
            <br>
            <div class="ttd-atas" style="margin-left:8%; margin-right:8%;">
                <div class="penyewa" style="float: left">
                    <p style="text-decoration: underline"><b>PIHAK KEDUA</b><br><p style="margin-top: -12px">CV. {{ $order->nama_instansi }}</p></p>
                        <br><br><br><br><br>
                    <p style="text-decoration: underline"><b>{{ $order1->nama }}</b><br><p style="margin-top: -12px">Direktur</p></p>
                </div>
                <div class="kepala-uptd" style="float: right">
                    <p style="text-decoration: underline" align="center"><b>PIHAK PERTAMA</b><br><p align="center" style="margin-top: -12px">KEPALA UPT ALAT BERAT <br> DINAS PEKERJAAN UMUM DAN PENATAAN <br> RUANG KOTA PONTIANAK</p></p>
                    @if($order1->ket_persetujuan_kepala_uptd == 'belum' OR $order1->ket_persetujuan_kepala_uptd == 'tolak' OR $order1->ttd_kepala_uptd =='')
                        <br><br><br>
                    @else
                        <center>
                            <?php $path = public_path('storage');
                            $pdf=$path . '/' . $order1->ttd_kepala_uptd;?>
                            <img src="{{ $pdf }}" alt="" style="width:60px; height:60px;">
                        </center>
                    @endif
                    <p style="text-decoration: underline" align="center"><b>{{ $kepala_uptd->name }}</b><br><p align="center" style="margin-top: -12px">{{ $kepala_uptd->pangkat }}</p><p style="margin-top: -12px" align="center">NIP. {{ $kepala_uptd->nip }}</p></p>
                </div>
            </div>
            <br><br><br><br><br><br><br><br><br><br><br><br><br><br>
            <div class="bawah">
                <center>
                    <div class="kepala-dinas">
                        <p>Mengetahui : </p><p style="text-decoration: underline; margin-top:-12px"><b>KEPALA DINAS PEKERJAAN UMUM DAN PENATAAN RUANG KOTA PONTIANAK</b></p>
                        @if($order1->ket_persetujuan_kepala_dinas == 'belum' OR $order1->ket_persetujuan_kepala_dinas == 'tolak' OR $order1->ttd_kepala_dinas =='')
                            <br><br><br>
                        @else
                            <center>
                                <?php $path = public_path('storage');
                                $pdf=$path . '/' . $order1->ttd_kepala_dinas;?>
                                <img src="{{ $pdf }}" alt="" style="width:60px; height:60px;">
                            </center>
                        @endif
                        <p style="text-decoration: underline"><b style="margin-top: -12px">{{ $kepala_dinas->name }}</b><br><p style="margin-top: -12px">{{ $kepala_dinas->pangkat }}</p><p style="margin-top: -12px">{{ $kepala_dinas->nip }}</p></p>
                    </div>
                </center>
            </div>
        </div>
    </div>
    <div class="page4" style="padding:40px">
        <div class="header">
            <img src="img/Logo-Kota-Pontianak.jpg" alt="" style="width:100px; height:90px;">
            <h5 class="judul text-center">PEMERINTAH KOTA PONTIANAK<br><b><span class="font24">DINAS PEKERJAAN UMUM DAN PENATAAN RUANG</span></b><br><small>Alamat Jalan A. Yani Telpon : +62561-732300 Fax : +62561-747329</small><br><span class="font12"><b>PONTIANAK - KALBAR</b><span></h5>
        </div>
        <p class="p" style="text-align: right">Pontianak, {{ Carbon::now()->isoFormat('D MMMM YYYY') }}</p>
        <div class="col-4" style="float: right">
            <p class="p" style="text-align: center;">Kepada</p>
            <p class="p">Yth, <b style="font-style: italic; font-weight:bold">Direktur CV. {{ $order1->nama_instansi }}</b></p>
            <p class="p" style="text-align:center; margin-left:-5cm"> di -</p>
            <p class="p" style="text-decoration: underline; font-weight: bold; text-align:center">Pontianak</p>
        </div>
        <p class="p">Nomor &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ $order1->id }} / {{ Carbon::now()->isoFormat('M') }} / D-PUPR.UPT</p>
        <p class="p">Lampiran &nbsp;: -</p>
        <p class="p">Perihal &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <b>Persetujuan Pinjam Pakai Alat Berat</b></p>
        <br><br><br>
        <div class="row offset-1">
            <p class="p">Sehubungan dengan Surat Saudara <b style="font-weight:bold">{{ $order1->nama }}</b> atas nama CV <b style="font-weight:bold">{{ $order1->nama_instansi }}</b> Nomor : Tanggal : Perihal Permohonan Penyewaan 
            @foreach($detail_orders as $detail_order)
                <b style="font-weight:bold"> {{ $detail_order->nama }}, </b>
            @endforeach
            untuk Pekerjaan <b style="font-weight:bold">{{ $order1->nama_kegiatan }}</b>, maka prinsipnya kami tidak keberatan selama permohonan Saudara tetap berpedoman pada peraturan dan syarat-syarat yang telah ditentukan oleh Pemerintah Kota Pontianak UP. Dinas Pekerjaan Umum dan Penataan Ruang Kota Pontianak.
            </p>
            <br><br>
            <p class="p" style="margin-top: 100px">Demikian Surat Persetujuan ini kami buat agar dapat dipergunakan sebagaimana mestinya.</p>
        </div>
        <br>
        <div class="col-5" style="float: right;">
            <p class="p" style="text-align: center;">KEPALA DINAS PEKERJAAN UMUM DAN PENATAAN RUANG KOTA PONTIANAK</p>
            @if($order1->ket_persetujuan_kepala_dinas == 'belum' OR $order1->ket_persetujuan_kepala_dinas == 'tolak' OR $order1->ttd_kepala_dinas =='')
            <br><br><br>
        @else
            <center>
                <?php $path = public_path('storage');
                $pdf=$path . '/' . $order1->ttd_kepala_dinas;?>
                <img src="{{ $pdf }}" alt="" style="width:60px; height:60px;">
                {{-- <?php dd($pdf) ?> --}}
            </center>
        @endif
        <p class="p" style="text-decoration: underline; text-align:center"><b style="margin-top: -12px; font-weight:bold">{{ $kepala_dinas->name }}</b><br>
            <p class="p" style="margin-top: -12px; text-align:center">{{ $kepala_dinas->pangkat }}</p>
            <p class="p" style="margin-top: -12px; text-align:center">{{ $kepala_dinas->nip }}</p>
        </p>
        </div>
    </div>
</body>
</html>