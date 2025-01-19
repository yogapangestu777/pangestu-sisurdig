@extends('layouts.admin')
@section('app')
    <div class="nk-content nk-content-fluid">
        <div class="container-xl wide-lg">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        @include('partials.admin._page-title')
                        <div class="nk-block-head-content">
                            <div class="toggle-wrap nk-block-tools-toggle">
                                <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1"
                                    data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                                <div class="toggle-expand-content" data-content="pageMenu">
                                    <ul class="nk-block-tools g-3">
                                        <li>
                                            <a href="{{ route('admin.manage.users.index') }}" class="btn btn-secondary">
                                                <span>Kembali</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div><!-- .nk-block-head-content -->
                    </div><!-- .nk-block-between -->
                </div><!-- .nk-block-head -->
                <div class="nk-block nk-block-lg">
                    <form action="{{ route('admin.manage.users.update', $user->id) }}" method="post">
                        @csrf
                        @method('put')
                        <div class="card card-bordered">
                            <div class="card-inner">
                                <div class="row g-3">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label" for="full-name">Nama Lengkap</label>
                                            <div class="form-control-wrap">
                                                <input type="text" name="full_name"
                                                    class="form-control @error('full_name') is-invalid @enderror"
                                                    id="full-name" placeholder="Masukan nama lengkap"
                                                    value="{{ old('full_name', $user->full_name) }}">
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
                                            <label class="form-label" for="username">Nama Pengguna</label>
                                            <div class="form-control-wrap">
                                                <input type="text" name="username"
                                                    class="form-control @error('username') is-invalid @enderror"
                                                    id="username" placeholder="Masukan nama pengguna"
                                                    value="{{ old('username', $user->username) }}">
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
                                            <label class="form-label" for="email">Email</label>
                                            <div class="form-control-wrap">
                                                <input type="text" name="email"
                                                    class="form-control @error('email') is-invalid @enderror" id="email"
                                                    placeholder="Masukan email" value="{{ old('email', $user->email) }}">
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
                                            <label class="form-label" for="phone_number">No Telepon</label>
                                            <div class="form-control-wrap">
                                                <input type="text" inputmode="numeric" name="phone_number"
                                                    class="form-control @error('phone_number') is-invalid @enderror"
                                                    id="phone_number" placeholder="Masukan no telepon"
                                                    value="{{ old('phone_number', $user->phone_number) }}">
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
                                                    class="form-control @error('pob') is-invalid @enderror" id="pob"
                                                    placeholder="Masukan tempat lahir"
                                                    value="{{ old('pob', $user->pob) }}">
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
                                                    data-date-format="yyyy-mm-dd" value="{{ old('dob', $user->dob) }}"
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
                                                                @checked($user->gender == '1')>
                                                            <label class="custom-control-label"
                                                                for="male">Laki-laki</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div
                                                            class="custom-control custom-radio custom-control-pro no-control">
                                                            <input type="radio" class="custom-control-input"
                                                                name="gender" value="2" id="female"
                                                                @checked($user->gender == '2')>
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
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label" for="role">Role</label>
                                            <div class="form-control-wrap">
                                                <div class="form-control-wrap">
                                                    <ul class="custom-control-group">
                                                        @foreach ($roles as $role)
                                                            <li>
                                                                <div
                                                                    class="custom-control custom-radio custom-control-pro no-control">
                                                                    <input type="radio" class="custom-control-input"
                                                                        name="role" value="{{ $role->id }}"
                                                                        id="role{{ $role->id }}"
                                                                        @checked($user->role == $role->id)>
                                                                    <label class="custom-control-label"
                                                                        for="role{{ $role->id }}">{{ $role->name }}</label>
                                                                </div>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                                @error('role')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-primary disable-button">Simpan</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div><!-- .nk-block -->
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('assets/admin/js/interactions/disable-button.js?ver=1.0.0') }}"></script>
@endsection
