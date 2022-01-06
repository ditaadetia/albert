@extends('layouts.headerDefault')
@section('isicardDefault')
<div class="container-fluid mt--6">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                      <div class="col-md-10">
                        <h3 class="mb-0">Ubah Password</h3>
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
                    <form method="POST" action="{{ route('password.update', ['password' => auth()->user()->id]) }}">
                        @method('patch')
                        @csrf
                        <h6 class="heading-small text-muted mb-4">Password</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="current_password">{{ __('Password Lama') }}</label>
                                        <input id="current_password" type="password" class="form-control @error('current_password') is-invalid @enderror" name="current_password" required autocomplete="current_password">
                                        @error('current_password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="password" class="col-form-label text-md-right">{{ __('Password') }}</label>
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="password-confirm" class="col-form-label text-md-right">{{ __('Konfirmasi Password') }}</label>
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="my-4" />
                        <div class="col-12 text-right">
                            <button type="submit" name="submit" value="Submit" class="btn btn-warning"><span class="fa fa-save"></span> Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection