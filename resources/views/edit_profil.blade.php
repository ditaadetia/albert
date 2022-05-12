@extends('layouts.headerDefault')
@section('isicardDefault')
<div class="container-fluid mt--6">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                      <div class="col-md-10">
                        <h3 class="mb-0">Edit Profil</h3>
                      </div>
                      <div class="col-md-2">
                        <a href="{{ route('dashboard') }}" class="btn btn-success btn-icon">
                          <i class="fa fas fa-arrow-left"></i>
                          <span class="nav-link-text">Kembali</span>
                        </a>
                      </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('users.update', ['user' => $user->id]) }}" method="post" class="well" id="block-validate" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <h6 class="heading-small text-muted mb-4">Foto Profil</h6>
                        <div class="pl-lg-4">
                          <div class="row">
                            <div class="col-md-12">
                              <div class="form-group">
                                {{-- @if(auth()->user()->foto != '')
                                  <img src="{{ asset('storage/' . auth()->user()->foto) }}" style="width:120px; height:120px; border-radius: 50%" class="user-image" alt="User Image">
                                @else
                                <img src="{{ asset('storage/users/no-pict.png') }}" style="width:120px; height:120px; border-radius: 50%" class="user-image" alt="User Image">
                                @endif --}}
                                <img class="img-preview img-fluid mb-3 col-sm-5">
                                <input class="form-control @error('foto') is-invalid @enderror" type="file" id="foto" name="foto" onchange="previewImage()" style="margin-top:16px;">
                                {{-- <input type="file" name="foto" id="foto" class="form-control" style="margin-top:16px;"/> --}}
                                @error('foto')
                                  <div class="invalid-feedback">
                                    {{ $message }}
                                  </div>
                                @enderror
                                <span class="help-block">Silahkan upload foto untuk update.</span>
                              </div>
                            </div>
                          </div>
                        </div>
                        <h6 class="heading-small text-muted mb-4">Profil</h6>
                        <div class="pl-lg-4">
                        <div class="row">
                          <div class="col-lg-6">
                            <div class="form-group">
                              <label class="form-control-label" for="input-nama">Nama</label>
                              <input type="text" id="name" name="name" class="form-control" placeholder="Nama" value="{{ auth()->user()->name }}">
                            </div>
                          </div>
                          <div class="col-lg-6">
                            <div class="form-group">
                              <label class="form-control-label" for="input-username">Username</label>
                              <input type="text" id="username" name="username" class="form-control" placeholder="Username" value="{{ auth()->user()->username }}">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-lg-6">
                            <div class="form-group">
                              <label class="form-control-label" for="input-email">Email</label>
                              <input type="email" id="email" name="email" class="form-control" placeholder="Email" value="{{ auth()->user()->email }}">
                            </div>
                          </div>
                          <div class="col-lg-6">
                            <div class="form-group">
                              <label class="form-control-label" for="input-number">No. Handphone</label>
                              <input id="kontak" name="kontak" class="form-control" placeholder="No. Handphone" value="{{ auth()->user()->kontak }}" type="number">
                            </div>
                          </div>
                        </div>
                      </div>
                      <hr class="my-4" />
                      <!-- Address -->
                      <h6 class="heading-small text-muted mb-4">Informasi Pegawai</h6>
                      <div class="pl-lg-4">
                        <div class="row">
                          <div class="col-lg-4">
                            <div class="form-group">
                              <label class="form-control-label" for="input-jabatan">Jabatan</label>
                              <input type="text" id="jabatan" name="jabatan" class="form-control" placeholder="Jabatan" value="{{ auth()->user()->nama_jabatan }}" readonly>
                            </div>
                          </div>
                          <div class="col-lg-4">
                            <div class="form-group">
                              <label class="form-control-label" for="input-pangkat">Pangkat</label>
                              <input id="pangkat" name="pangkat" class="form-control" placeholder="Pangkat" value="{{ auth()->user()->pangkat }}" type="text">
                            </div>
                          </div>
                          <div class="col-lg-4">
                            <div class="form-group">
                              <label class="form-control-label" for="input-nip">NIP</label>
                              <input type="text" id="nip" name="nip" class="form-control" placeholder="NIP" value="{{ auth()->user()->nip }}">
                            </div>
                          </div>
                        </div>
                      </div>
                      <hr class="my-4" />
                      <!-- Description -->
                      <h6 class="heading-small text-muted mb-4">Alamat</h6>
                      <div class="pl-lg-4">
                        <div class="form-group">
                          <label class="form-control-label">Alamat</label>
                          <textarea class="form-control" id="alamat" name="alamat" rows=4 placeholder="Alamat" value="{{ auth()->user()->alamat }}">{{ auth()->user()->alamat }}</textarea>
                        </div>
                      </div>
                      <div class="col-12 text-right">
                        <button type="submit" name="update" class="btn btn-warning"><span class="fa fa-save"></span> Simpan</button>
                      </div>
                    </form>
                  </div>
            </div>
        </div>
    </div>
</div>
@endsection