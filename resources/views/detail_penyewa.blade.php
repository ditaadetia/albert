@extends('layouts.headerPrimary')
@section('isicard')
<div class="container-fluid mt--6">
  <!-- Dark table -->
  <div class="row">
    <div class="col-md-12">
      <div class="card shadow" style="border-radius:50px !important;">
        <div class="card-header" style="background-color:#364a76">
            <div class="row align-items-center">
                <div class="col-md-10">
                  <h3 class="mb-0 text-white">Detail Penyewa</h3>
                </div>
                <div class="col-md-2">
                  <a href="{{ route('tenants.index') }}" class="btn btn-success btn-icon">
                    <i class="fa fas fa-arrow-left"></i>
                    <span class="nav-link-text">Kembali</span>
                  </a>
                </div>
            </div>
        </div>
        <div class="card-body border-0" style="background-color:white">
            <div class="row justify-content-center align-item-center">
              @if($tenant->foto != '')
              <img src="{{ asset('storage/' . $tenant->foto) }}" style="width:300px; height:300px">
            @else
              <img src="{{ asset('storage/tenant/no-pict.png') }}" style="width:300px; height:300px">
            @endif
            </div>
            <div class="row mt-5">
              <div class="col-3">
                <h4>Nama Penyewa</h4>
              </div>
              <div class="col-1 text-right">
                :
              </div>
              <div class="col-8">
                <h4><b>{{ $tenant->nama }}</b></h4>
              </div>
            </div>
            <div class="row">
              <div class="col-3">
                <h4>Username</h4>
              </div>
              <div class="col-1 text-right">
                :
              </div>
              <div class="col-8">
                <h4><b>{{ $tenant->username }}</b></h4>
              </div>
            </div>
            <div class="row">
              <div class="col-3">
                <h4>Email</h4>
              </div>
              <div class="col-1 text-right">
                :
              </div>
              <div class="col-8">
                <h4><b>{{ $tenant->email }}</b></h4>
              </div>
            </div>
            <div class="row">
              <div class="col-3">
                <h4>Nama Bidang Hukum</h4>
              </div>
              <div class="col-1 text-right">
                :
              </div>
              <div class="col-8">
                <h4><b>{{ $tenant->nama_instansi }}</b></h4>
              </div>
            </div>
            <div class="row">
              <div class="col-3">
                <h4>No. HP</h4>
              </div>
              <div class="col-1 text-right">
                :
              </div>
              <div class="col-8">
                <h4><b>{{ $tenant->no_hp }}</b></h4>
              </div>
            </div>
            <div class="row">
              <div class="col-3">
                <h4>Kontak Darurat</h4>
              </div>
              <div class="col-1 text-right">
                :
              </div>
              <div class="col-8">
                <h4><b>{{ $tenant->kontak }}</b></h4>
              </div>
            </div>
            <div class="row">
              <div class="col-3">
                <h4>Alamat</h4>
              </div>
              <div class="col-1 text-right">
                :
              </div>
              <div class="col-8">
                <h4><b>{{ $tenant->alamat }}</b></h4>
              </div>
            </div>
          </div>
        <div class="card-footer justify-content-end py-4" style="background-color:#364a76">
        </div>
      </div>
    </div>
  </div>
@endsection