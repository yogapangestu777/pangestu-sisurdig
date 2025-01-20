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
                                    @can('account.read')
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('admin.profile.account.index') }}">
                                                <em class="icon ni ni-account-setting-alt"></em>
                                                <span>Akun</span>
                                            </a>
                                        </li>
                                    @endcan
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('admin.profile.biography.index') }}">
                                            <em class="icon ni ni-user-check"></em>
                                            <span>Biodata</span>
                                        </a>
                                    </li>
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
                                        <form
                                            action="{{ route('admin.profile.biography.update', encryptId($biography->id)) }}"
                                            method="post" autocomplete="off">
                                            @csrf
                                            @method('put')
                                            <div class="row g-3">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="full_name">Nama Lengkap</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" name="full_name"
                                                                class="form-control @error('full_name') is-invalid @enderror"
                                                                id="full_name" placeholder="Masukan nama lengkap"
                                                                value="{{ old('full_name', $biography->full_name) }}">
                                                            @error('full_name')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="phone_number">No Telepon</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" name="phone_number"
                                                                class="form-control @error('phone_number') is-invalid @enderror"
                                                                id="phone_number" placeholder="Masukan no telepon"
                                                                value="{{ old('phone_number', $biography->phone_number) }}"
                                                                inputmode="numeric">
                                                            @error('phone_number')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="pob">Tempat Lahir</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" name="pob"
                                                                class="form-control @error('pob') is-invalid @enderror"
                                                                id="pob" placeholder="Masukan tempat lahir"
                                                                value="{{ old('pob', $biography->pob) }}">
                                                            @error('pob')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label class="form-label">Tanggal Lahir</label>
                                                        <div class="form-control-wrap focused">
                                                            <div class="form-icon form-icon-left">
                                                                <em class="icon ni ni-calendar"></em>
                                                            </div>
                                                            <input type="text" name="dob"
                                                                class="form-control date-picker @error('dob') is-invalid @enderror"
                                                                data-date-format="yyyy-mm-dd" value="{{ $biography->dob }}"
                                                                placeholder="Masukan tanggal lahir">
                                                            @error('dob')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="gender" class="form-label">Jenis Kelamin</label>
                                                        <div class="form-control-wrap">
                                                            <ul class="custom-control-group">
                                                                <li>
                                                                    <div
                                                                        class="custom-control custom-radio custom-control-pro no-control">
                                                                        <input type="radio" class="custom-control-input"
                                                                            name="gender" value="1" id="male"
                                                                            @checked(old('gender', $biography->gender) == '1')>
                                                                        <label class="custom-control-label"
                                                                            for="male">Laki-laki</label>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div
                                                                        class="custom-control custom-radio custom-control-pro no-control">
                                                                        <input type="radio" class="custom-control-input"
                                                                            name="gender" value="2" id="female"
                                                                            @checked(old('gender', $biography->gender) == '2')>
                                                                        <label class="custom-control-label"
                                                                            for="female">Perempuan</label>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        @error('gender')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                @can('biography.update')
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
