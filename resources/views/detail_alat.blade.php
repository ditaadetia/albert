@extends('layouts.headerPrimary')
@section('isicard')
<div class="container-fluid mt--6">
  <!-- Dark table -->
  <div class="row">
    <div class="col-md-12">
      <div class="card shadow">
        <div class="card-header" style="background-color:#364a76">
          <div class="row align-items-center">
            <div class="col-md-10">
              <h3 class="mb-0 text-white">Detail Alat</h3>
            </div>
            <div class="col-md-2">
              <a href="{{ route('equipments.index') }}" class="btn btn-success btn-icon">
                <i class="fa fas fa-arrow-left"></i>
                <span class="nav-link-text">Kembali</span>
              </a>
            </div>
          </div>
        </div>
        <div class="card-body border-0" style="background-color:white">
          <div class="row justify-content-center align-item-center">
            @if($equipment->foto != '')
              <img src="{{ asset('storage/' . $equipment->foto) }}" style="width:300px; height:300px">
            @else
              <img src="{{ asset('storage/equipments/no-pict.png') }}" style="width:300px; height:300px">
            @endif
          </div>
          <div class="row">
            <div class="col-3">
              <h4>Nama Alat</h4>
            </div>
            <div class="col-1 text-right">
              :
            </div>
            <div class="col-8">
              <h4><b>{{ $equipment->nama }}</b></h4>
            </div>
          </div>
          <div class="row">
            <div class="col-3">
              <h4>Total Alat</h4>
            </div>
            <div class="col-1 text-right">
              :
            </div>
            <div class="col-8">
              <h4><b>{{ $equipment->total }}</b></h4>
            </div>
          </div>
          <div class="row">
            <div class="col-3">
              <h4>Jumlah Tersedia</h4>
            </div>
            <div class="col-1 text-right">
              :
            </div>
            <div class="col-8">
              <h4><b>{{ $equipment->jumlah_tersedia }}</b></h4>
            </div>
          </div>
          <div class="row">
            <div class="col-3">
              <h4>Model</h4>
            </div>
            <div class="col-1 text-right">
              :
            </div>
            <div class="col-8">
              <h4><b>{{ $equipment->jenis }}</b></h4>
            </div>
          </div>
          <div class="row">
            <div class="col-3">
              <h4>Kegunaan</h4>
            </div>
            <div class="col-1 text-right">
              :
            </div>
            <div class="col-8">
              <h4><b>{{ $equipment->kegunaan }}</b></h4>
            </div>
          </div>
          <div class="row">
            <div class="col-3">
              <h4>Harga Sewa Perhari</h4>
            </div>
            <div class="col-1 text-right">
              :
            </div>
            <div class="col-8">
              <h4><b>{{ 'Rp. ' . number_format($equipment->harga_sewa_perhari, 2, ",", ".") }}</b></h4>
            </div>
          </div>
          <div class="row">
            <div class="col-3">
              <h4>Harga Sewa Perjam</h4>
            </div>
            <div class="col-1 text-right">
              :
            </div>
            <div class="col-8">
              <h4><b>{{ 'Rp. ' . number_format($equipment->harga_sewa_perjam, 2, ",", ".") }}</b></h4>
            </div>
          </div>
          <div class="row">
            <div class="col-3">
              <h4>Spesifikasi</h4>
            </div>
            <div class="col-1 text-right">
              :
            </div>
            <div class="col-8">
              <h4><b>{{ $equipment->keterangan }}</b></h4>
            </div>
          </div>
          <div class="row">
            <div class="col-3">
              <h4>Kondisi</h4>
            </div>
            <div class="col-1 text-right">
              :
            </div>
            <div class="col-8">
              <h4><b>{{ $equipment->kondisi }}</b></h4>
            </div>
          </div>
        </div>
        <div class="card-footer justify-content-end py-4" style="background-color:#364a76">
        </div>
      </div>
    </div>
  </div>
@endsection