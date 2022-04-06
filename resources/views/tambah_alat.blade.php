@extends('layouts.headerPrimary')
@section('isicard')
<div class="container-fluid mt--6">
    <div class="row">
      <div class="col-md-12 ">
            <div class="card shadow">
                <div class="card-header" style="background-color:#364a76">
                    <div class="row align-items-center">
                        <div class="col-xl-10">
                            <h3 class="mb-0 text-white">Tambah Alat </h3>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('equipments.index') }}" class="btn btn-success btn-icon">
                                <i class="fa fas fa-arrow-left"></i>
                                <span class="nav-link-text">Kembali</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body" style="background-color:white">
                    <form action="{{ route('equipments.store') }}" method="POST" class="well" id="block-validate" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <h6 class="heading-small text-muted mb-4">Detail Alat</h6>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-control-label" for="input-nama">Nama</label>
                                <input type="text" id="nama" name="nama" class="form-control" placeholder="Nama" value="{{ old('nama') }}" required>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-control-label" for="input-nama">Total Alat</label>
                                <input type="number" id="total" name="total" class="form-control" placeholder="Total Alat" value="{{ old('total') }}" required>
                                {{-- <input type="hidden" id="jumlah_tersedia" name="total" class="form-control" value="{{ old('total') }}" required> --}}
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label for="foto" class="form-label">Foto</label>
                                <img class="img-preview img-fluid mb-3 col-sm-5">
                                <input class="form-control @error('foto') is-invalid @enderror" type="file" id="foto" name="foto" onchange="previewImage()">
                                @error('foto')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-control-label" for="input-jenis">Jenis</label>
                                <input type="text" id="jenis" name="jenis" class="form-control" placeholder="Jenis" value="{{ old('jenis') }}" required>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-control-label" for="input-kegunaan">Kegunaan</label>
                                <input type="text" id="kegunaan" name="kegunaan" class="form-control" placeholder="Kegunaan" value="{{ old('kegunaan') }}" required>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-control-label" for="input-harga-sewa-perjam">Harga Sewa Perjam</label>
                                <input type="number" id="harga_sewa_perjam" name="harga_sewa_perjam" class="form-control" placeholder="Harga Sewa Perjam" value="{{ old('harga_sewa_perjam') }}" required>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-control-label" for="input-harga-sewa-perhari">Harga Sewa Perhari</label>
                                <input type="number" id="harga_sewa_perhari" name="harga_sewa_perhari" class="form-control" placeholder="Harga Sewa Perhari" value="{{ old('harga_sewa_perhari') }}" required>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-control-label" for="input-keterangan">Spesifikasi</label>
                                <input type="text" id="keterangan" name="keterangan" class="form-control" placeholder="Spesifikasi" value="{{ old('keterangan') }}" required>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-control-label" for="input-keterangan">Kondisi</label>
                                <input type="text" id="kondisi" name="kondisi" class="form-control" placeholder="Kondisi" value="{{ old('kondisi') }}" required>
                            </div>
                        </div>
                        <div class="col-12 text-right">
                            <button type="submit" name="tambah" class="btn btn-warning"><span class="fa fa-save"></span> Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
