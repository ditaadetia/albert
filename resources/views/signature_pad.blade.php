@extends('layouts.headerPrimary')
@section('isicard')
	<div class="container">
		@can('kepala_uptd')
			<div class="row justify-content-center align-items-center mt-5">
				<div class="col-12">
					<div class="card">
						<div class="card-header" style="background-color: #364a76">
							<h3 style="color:white !important;">Dokumen Sewa</h3>
						</div>
						<div class="card-body">
							<embed type="application/pdf" src="{{ asset('storage/dokumen_sewa/' . $order->dokumen_sewa) }}" style="width:100%; height: 600px">
						</div>
					</div>
				</div>
			</div>
		@endcan
		<div class="row justify-content-center align-items-center mt-5">
			<div class="col-6">
				<div class="card shadow">
					<div class="card-header" style="background-color: #364a76">
						<div class="row">
							<div class="col-6">
								<h3 style="color:white !important;">Tanda tangan persetujuan</h3>
							</div>
							<div class="col-6">
								<div class="text-right">
									<button type="button" class="btn btn-default btn-sm" id="undo"><i class="fa fa-undo"></i> Undo</button>
									<button type="button" class="btn btn-danger btn-sm" id="clear"><i class="fa fa-eraser"></i> Clear</button>
								</div>
							</div>
						</div>
					</div>
					@can('kepala_uptd')
						<form method="POST" action="{{ route('ttdKepalaUPTD', ['id' => $order->id]) }}">
							@csrf
							<div class="card-body" style="background: #e9ecef">
								<div class="row justify-content-center align-items-center">
									<div class="wrapper">
										<canvas style="width: 100% !important;" id="signature-pad" class="signature-pad"></canvas>
									</div>
								</div>
							</div>
							<div class="card-footer">
								<button type="button" class="btn btn-primary btn-sm" id="save-png"><i class='fa fa-save'></i> Save</button>
								{{-- <button type="button" class="btn btn-info btn-sm" id="save-jpeg">Save as JPEG</button>
								<button type="button" class="btn btn-default btn-sm" id="save-svg">Save as SVG</button> --}}
							</div>
							<!-- Modal untuk tampil preview tanda tangan-->
							<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
								<div class="modal-dialog modal-dialog-centered">
									<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="exampleModalLabel">Verifikasi pengajuan penyewaan</h5>
										<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
									</div>
										<div class="modal-body">
										</div>
										<div class="modal-footer">
										<button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
										<button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-save"></i> Submit</button>
										</div>
									</div>
								</div>
								</div>
						</form>
					@endcan
					@can('bendahara')
						<form method="POST" action="{{ route('ttdBendahara', ['id' => $order->id]) }}">
							@csrf
							<div class="card-body" style="background: #e9ecef">
								<div class="row justify-content-center align-items-center">
									<div class="wrapper">
										<canvas style="width: 100% !important;" id="signature-pad" class="signature-pad"></canvas>
									</div>
								</div>
							</div>
							<div class="card-footer">
								<button type="button" class="btn btn-primary btn-sm" id="save-png"><i class='fa fa-save'></i> Save</button>
								{{-- <button type="button" class="btn btn-info btn-sm" id="save-jpeg">Save as JPEG</button>
								<button type="button" class="btn btn-default btn-sm" id="save-svg">Save as SVG</button> --}}
							</div>
							<!-- Modal untuk tampil preview tanda tangan-->
							<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
								<div class="modal-dialog modal-dialog-centered">
									<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="exampleModalLabel">Verifikasi pengajuan penyewaan</h5>
										<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
									</div>
										<div class="modal-body">
										</div>
										<div class="modal-footer">
										<button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
										<button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-save"></i> Submit</button>
										</div>
									</div>
								</div>
								</div>
						</form>
					@endcan
				</div>
			</div>
		</div>
	</div>
@endsection