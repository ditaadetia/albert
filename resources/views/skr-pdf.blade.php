<?php use Carbon\Carbon; ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="assets/vendor/nucleo/css/nucleo.css'" type="text/css">
	<title>skr-pdf</title>
</head>
<body style="font-family: Tahoma !important; font-size: 10px">
	<table width="100%" style="border: 2px solid #000000" style="font-family: font-family: Tahoma; font-size: 10px; width:100%">
		<tr align="center" style="border-bottom: 1px solid #000000">
			<td style="padding-left: 50px; padding-right: 50px; border-right: 1px solid #000000; border-bottom: 1px solid #000000" colspan="10"><p>PEMERINTAH KOTA PONTIANAK </p><p style="margin-top: -10px;"> DINAS PEKERJAAN UMUM</p></td>
			<td style="padding-left: 50px; padding-right: 50px; border-bottom: 1px solid #000000" colspan="14"><p style="font-size: 14px !important"><b>SURAT KETETAPAN RETRIBUSI</b></p><p style="margin-top: -10px; font-size: 14px !important"><b>(SKR)</b></p></td>
		</tr>
		<tr>
			<td colspan="24" style="transform:translate(35%);">
				<p>No. URUT : {{ $skr->id }}/PTP/1.03.0.00.0.00.01.0000/41020201006/{{ Carbon::now()->isoFormat('M/YYYY') }}</p>
				<p style="margin-top: -10px">MASA : </p>
				<p style="margin-top: -10px"><b>TAHUN : {{ Carbon::now()->isoFormat('YYYY') }}</b></p>
			</td>
		</tr>
		<tr>
			<td colspan="24">
				<p style="margin-left: 5%">NAMA &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;&nbsp; : {{ $skr->nama }}</p>
				<p style="margin-left: 5%; margin-top: -10px">ALAMAT &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;&nbsp;   : {{ $skr->alamat }}</p>
				<p style="margin-left: 5%; margin-top: -10px">NOMOR POKOK WAJIB RETRIBUSI : -</p>
				<?php $jatuh_tempo=Carbon::now()->addDays(30); ?>
				<p style="margin-left: 5%; margin-top: -10px">TANGGAL JATUH TEMPO &emsp;&emsp;&emsp;&emsp;&nbsp;&nbsp;: {{ Carbon::parse($jatuh_tempo)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</p>
			</td>
		</tr>
		<tr>
			<td colspan="1" style="border: 1px solid #000000"><b>No.</b></td>
			<td colspan="11" style="border: 1px solid #000000"><b>KODE REKENING</b></td>
			<td colspan="9" style="border: 1px solid #000000"><b>URAIAN RETRIBUSI</b></td>
			<td colspan="1" style="border: 1px solid #000000"><b>JUMLAH (Rp.)</b></td>
		</tr>
		{{-- <tr></tr> --}}
		<tr>
				<td style="border: 1px solid #000000">1.</td>
				<td style="border: 1px solid #000000">4</td>
				<td style="border: 1px solid #000000">1</td>
				<td style="border: 1px solid #000000">0</td>
				<td style="border: 1px solid #000000">2</td>
				<td style="border: 1px solid #000000">0</td>
				<td style="border: 1px solid #000000">2</td>
				<td style="border: 1px solid #000000">0</td>
				<td style="border: 1px solid #000000">1</td>
				<td style="border: 1px solid #000000">0</td>
				<td style="border: 1px solid #000000">0</td>
				<td style="border: 1px solid #000000">6</td>
			<td colspan="9" style="border: 1px solid #000000"><b>- Penyewaan alat berat</b></td>
			<td style="border: 1px solid #000000">
				<?php $total = 0;
					$equipment = DB::table('orders')
					->join('detail_orders', 'detail_orders.order_id', '=', 'orders.id')
					->join('equipments', 'detail_orders.equipment_id', '=', 'equipments.id')
					->where('orders.id', $skr->id)
					->select('orders.id', 'equipments.nama', 'equipments.foto', 'orders.tanggal_mulai', 'orders.tanggal_selesai', 'equipments.harga_sewa_perhari', 'equipments.harga_sewa_perjam')
					// $detail_refund = DB::table('refunds')->join('detail_refunds', 'detail_refunds.refund_id', '=', 'refunds.id')->get();
					->get();
				?>
				@foreach ($equipment as $equipment)
				<?php
				// use Carbon\Carbon;
				setlocale(LC_TIME, 'id_ID');
				\Carbon\Carbon::setLocale('id');
				\Carbon\Carbon::now()->formatLocalized("%A, %d %B %Y");
				$tanggal_mulai = new DateTime($equipment->tanggal_mulai);
				$tanggal_selesai = new DateTime($equipment->tanggal_selesai);
				$total_waktu = $tanggal_selesai->diff($tanggal_mulai);
				$jumlah = ($total_waktu->days * $equipment->harga_sewa_perhari) + ($total_waktu->h * $equipment->harga_sewa_perjam);
				$total = $total + $jumlah
				?>
				@endforeach
				{{ 'Rp. ' . number_format($total, 2, ",", ".") }}
			</td>
		</tr>
		<tr style="height: 20px">
			<td style="border: 1px solid #000000"></td>
			<td style="border: 1px solid #000000"></td>
			<td style="border: 1px solid #000000"></td>
			<td style="border: 1px solid #000000"></td>
			<td style="border: 1px solid #000000"></td>
			<td style="border: 1px solid #000000"></td>
			<td style="border: 1px solid #000000"></td>
			<td style="border: 1px solid #000000"></td>
			<td style="border: 1px solid #000000"></td>
			<td style="border: 1px solid #000000"></td>
			<td style="border: 1px solid #000000"></td>
			<td style="border: 1px solid #000000"></td>
			<td colspan="9" style="border: 1px solid #1a1818"> Penyewaan alat berat pekerjaan {{ $skr->nama_kegiatan }}</td>
			<td style="border: 1px solid #000000"></td>
		</tr>
		<tr style="height: 20px">
			<td style="border: 1px solid #000000; height: 10px"></td>
			<td style="border: 1px solid #000000"></td>
			<td style="border: 1px solid #000000"></td>
			<td style="border: 1px solid #000000"></td>
			<td style="border: 1px solid #000000"></td>
			<td style="border: 1px solid #000000"></td>
			<td style="border: 1px solid #000000"></td>
			<td style="border: 1px solid #000000"></td>
			<td style="border: 1px solid #000000"></td>
			<td style="border: 1px solid #000000"></td>
			<td style="border: 1px solid #000000"></td>
			<td style="border: 1px solid #000000"></td>
			<td colspan="9" style="border: 1px solid #1a1818"></td>
			<td style="border: 1px solid #000000"></td>
		</tr>
		<tr style="height: 20px">
			<td style="border: 1px solid #000000; height: 10px"></td>
			<td style="border: 1px solid #000000"></td>
			<td style="border: 1px solid #000000"></td>
			<td style="border: 1px solid #000000"></td>
			<td style="border: 1px solid #000000"></td>
			<td style="border: 1px solid #000000"></td>
			<td style="border: 1px solid #000000"></td>
			<td style="border: 1px solid #000000"></td>
			<td style="border: 1px solid #000000"></td>
			<td style="border: 1px solid #000000"></td>
			<td style="border: 1px solid #000000"></td>
			<td style="border: 1px solid #000000"></td>
			<td colspan="9" style="border: 1px solid #1a1818"></td>
			<td style="border: 1px solid #000000"></td>
		</tr>
		<tr style="height: 20px">
			<td style="border: 1px solid #000000; height: 10px"></td>
			<td style="border: 1px solid #000000"></td>
			<td style="border: 1px solid #000000"></td>
			<td style="border: 1px solid #000000"></td>
			<td style="border: 1px solid #000000"></td>
			<td style="border: 1px solid #000000"></td>
			<td style="border: 1px solid #000000"></td>
			<td style="border: 1px solid #000000"></td>
			<td style="border: 1px solid #000000"></td>
			<td style="border: 1px solid #000000"></td>
			<td style="border: 1px solid #000000"></td>
			<td style="border: 1px solid #000000"></td>
			<td colspan="9" style="border: 1px solid #1a1818"></td>
			<td style="border: 1px solid #000000"></td>
		</tr>
		<tr style="height: 20px">
			<td style="border: 1px solid #000000; height: 10px"></td>
			<td style="border: 1px solid #000000"></td>
			<td style="border: 1px solid #000000"></td>
			<td style="border: 1px solid #000000"></td>
			<td style="border: 1px solid #000000"></td>
			<td style="border: 1px solid #000000"></td>
			<td style="border: 1px solid #000000"></td>
			<td style="border: 1px solid #000000"></td>
			<td style="border: 1px solid #000000"></td>
			<td style="border: 1px solid #000000"></td>
			<td style="border: 1px solid #000000"></td>
			<td style="border: 1px solid #000000"></td>
			<td colspan="9" style="border: 1px solid #1a1818"></td>
			<td style="border: 1px solid #000000"></td>
		</tr>
		<tr style="height: 20px">
			<td style="border: 1px solid #000000; height: 10px"></td>
			<td style="border: 1px solid #000000"></td>
			<td style="border: 1px solid #000000"></td>
			<td style="border: 1px solid #000000"></td>
			<td style="border: 1px solid #000000"></td>
			<td style="border: 1px solid #000000"></td>
			<td style="border: 1px solid #000000"></td>
			<td style="border: 1px solid #000000"></td>
			<td style="border: 1px solid #000000"></td>
			<td style="border: 1px solid #000000"></td>
			<td style="border: 1px solid #000000"></td>
			<td style="border: 1px solid #000000"></td>
			<td colspan="9" style="border: 1px solid #1a1818"></td>
			<td style="border: 1px solid #000000"></td>
		</tr>
		<tr style="height: 20px">
			<td style="border: 1px solid #000000; height: 10px"></td>
			<td style="border: 1px solid #000000"></td>
			<td style="border: 1px solid #000000"></td>
			<td style="border: 1px solid #000000"></td>
			<td style="border: 1px solid #000000"></td>
			<td style="border: 1px solid #000000"></td>
			<td style="border: 1px solid #000000"></td>
			<td style="border: 1px solid #000000"></td>
			<td style="border: 1px solid #000000"></td>
			<td style="border: 1px solid #000000"></td>
			<td style="border: 1px solid #000000"></td>
			<td style="border: 1px solid #000000"></td>
			<td colspan="9" style="border: 1px solid #1a1818"></td>
			<td style="border: 1px solid #000000"></td>
		</tr>
		<tr style="transform:translate(40%);">
			<td></td>
			<td colspan="24">
				<p>Jumlah Ketetapan Pokok Retribusi</p>
				<p>Jumlah Sanksi &emsp;&emsp;&emsp;&emsp; a. Bunga</p>
				<p style="transform:translate(9%);">b. kenaikan</p>
			</td>
		</tr>
		<tr style="border-bottom: 2px solid #000000; height:20px">
			<td colspan="12">
				<p style="text-align:right;"> Jumlah Keseluruhan</p>
			</td>
			<td colspan="12">
				<p style="background: lightslategrey;"><b>Rp.</b> <b style="text-align: right; align-items:flex-end; float:right;">{{'' . number_format($total, 2, ",", ".") }}</b></p>
			</td>
		</tr>
		<tr>
			<td colspan="24" style="border-bottom: 1px solid #000000"></td>
		</tr>
		{{-- <tr style="border-bottom: 2px solid #000000"></tr> --}}
		<tr>
			<td colspan="24">
				<p>Dengan Huruf :</p>
				<p style="text-decoration: underline">PERHATIAN :</p>
				<ol style="margin-left: -2%">
					<li>
						Harap penyetoran dilakukan pada Bank / Bendahara Penerimaan .
					</li>
					<li>
						Apabila SKR ini tidak atau kurang dibayar lewat paling lama 30 hari setelah SKR diterima
					</li>
					(tanggal jatuh tempo) dikenakan sanksi administrasi berupa bunga sebesar 2% per bulan.
				</ol>
			</td>
		</tr>
		<tr>
			<td align="center" colspan="24" style="transform:translate(20%);">
				<p style="align-items: center">Pontianak, {{ Carbon::now()->isoFormat('D MMMM YYYY') }}</p>
				<p>Mengetahui, </p>
				<p style="margin-top: -10px"><b>Kepala Dinas Pekerjaan Umum dan Penataan Ruang</b></p>
				<p style="margin-top: -10px"><b>Kota Pontianak</b></p>
				<?php $path = public_path('storage');
				$pdf=$path . '/' . $skr->ttd_kepala_dinas;?>
				<img src="{{ $pdf }}" alt="" style="width:60px; height:60px;">
				<p style="text-decoration: underline;"><b>{{ $kepala_dinas->name }}</b></p>
				<p style="margin-top: -10px"><b>NIP. {{ $kepala_dinas->nip }}</b></p>
			</td>
		</tr>
		<tr><td colspan="24" style="border-bottom: 1px solid #000000"></td></tr>
		<tr>
			<td colspan="24" align="center">
				<p style="margin-top: -3px">............................................................potong disini............................................................</p>
			</td>
		</tr>
		<tr>
			<td align="center" colspan="24" style="transform:translate(20%);">
				<p>No. Urut &emsp;&emsp; {{ $skr->id }}/PTP/1.03.0.00.0.00.01.0000/41020201006/{{ Carbon::now()->isoFormat('M/YYYY') }}</p>
			</td>
		</tr>
		<tr>
			<td colspan="24">TANDA TERIMA</td>
		</tr>
		<tr>
			<td align="center" colspan="24" style="transform:translate(25%);">
				<p style="align-items: center; margin-top: -10px">Pontianak, {{ Carbon::now()->isoFormat('D MMMM YYYY') }}</p>
			</td>
		</tr>
		<tr>
			<td colspan="12">
				<p style="margin-top: -5%">NAMA &emsp;&emsp;&emsp; : &emsp;&emsp;&emsp;&emsp; <b>{{ $skr->nama }}</b></p>
				<p style="margin-top: -5%">ALAMAT &emsp;&emsp; : &emsp;&emsp;&emsp;&emsp; {{ $skr->alamat }}</p>
				<p>NPWP &emsp;&emsp;&emsp; : &emsp;&emsp;&emsp;&emsp; -</p>
			</td>
			<td align="center" colspan="12" style="transform:translate(-10%);">
				<p style="align-items: center;">Yang Menerima,</p>
				<p>
					<?php
						$skr = DB::table('skr')
						->join('orders', 'skr.order_id', '=', 'orders.id')
						->join('tenants', 'orders.tenant_id', '=', 'tenants.id')
						->select('skr.id', 'tenants.nama', 'tenants.alamat', 'orders.nama_kegiatan', 'orders.ttd_kepala_dinas', 'skr.ttd_bendahara')
						->first();
					?>
					<?php $path = public_path('storage');
					$pdf=$path . '/' . $skr->ttd_bendahara;?>
					<img src="{{ $pdf }}" alt="" style="width:60px; height:60px; margin-top: -10px">
					<p style="text-decoration: underline; margin-top: -5px"><b>{{ $bendahara->name }}</b></p>
					<p style="margin-top: -10px"><b>NIP. {{ $bendahara->nip }}</b></p>
				</p>
			</td>
		</tr>
	</table>
</body>
</html>