@extends('layouts.admin')

@section('app')
    <div class="nk-content nk-content-fluid">
        <div class="container-xl wide-lg">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        @include('partials.admin._page-title')
                    </div><!-- .nk-block-between -->
                </div><!-- .nk-block-head -->
                <div class="nk-block nk-block-lg">
                    <div class="card card-bordered">
                        <div class="card-aside-wrap">
                            <div class="card-content">
                                <ul class="nav nav-tabs nav-tabs-mb-icon nav-tabs-card">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('admin.profile.account.index') }}">
                                            <em class="icon ni ni-account-setting-alt"></em>
                                            <span>Akun</span>
                                        </a>
                                    </li>
                                    @can('biography.read')
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('admin.profile.biography.index') }}">
                                                <em class="icon ni ni-user-check"></em>
                                                <span>Biodata</span>
                                            </a>
                                        </li>
                                    @endcan
                                    @can('password.read')
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('admin.profile.password.index') }}">
                                                <em class="icon ni ni-lock-alt"></em>
                                                <span>Kata Sandi</span>
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                                <div class="card-inner">
                                    <div class="nk-block">
                                        <form action="{{ route('admin.profile.account.update', encryptId($account->id)) }}"
                                            method="post" autocomplete="off">
                                            @csrf
                                            @method('put')
                                            <div class="row g-3">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="email">Email</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" name="email"
                                                                class="form-control @error('email') is-invalid @enderror"
                                                                id="email" placeholder="Masukan email"
                                                                value="{{ old('email', $account->email) }}">
                                                            @error('email')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="username">Nama
                                                            Pengguna</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" name="username"
                                                                class="form-control @error('username') is-invalid @enderror"
                                                                id="username" placeholder="Masukan nama pengguna"
                                                                value="{{ old('username', $account->username) }}">
                                                            @error('username')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="role">Hak Akses</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" name="role"
                                                                class="form-control @error('role') is-invalid @enderror"
                                                                id="role" placeholder="Masukan hak akses"
                                                                value="{{ old('role', $account->roles->first()->name) }}"
                                                                disabled>
                                                            @error('role')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="status">Status</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" name="status"
                                                                class="form-control @error('status') is-invalid @enderror"
                                                                id="status" placeholder="Masukan status"
                                                                value="{{ old('status', $account->is_active === '1' ? 'Aktif' : 'Non-aktif') }}"
                                                                disabled>
                                                            @error('status')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                @can('account.update')
                                                    <div class="form-group">
                                                        <button type="submit"
                                                            class="btn btn-primary disable-button">Simpan</button>
                                                    </div>
                                                @endcan
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- .nk-block -->
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('assets/admin/js/interactions/disable-button.js?ver=1.0.0') }}"></script>
@endsection
