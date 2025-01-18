@extends('layouts.admin')
@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/weak-password.css?ver=1.0.0') }}">
@endsection

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
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('admin.profile.biography.index') }}">
                                            <em class="icon ni ni-user-check"></em>
                                            <span>Biodata</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('admin.profile.password.index') }}">
                                            <em class="icon ni ni-lock-alt"></em>
                                            <span>Kata Sandi</span>
                                        </a>
                                    </li>
                                </ul>
                                <div class="card-inner">
                                    <div class="nk-block">
                                        <form action="{{ route('admin.profile.password.update', encryptId(auth()->id())) }}"
                                            method="post">
                                            @csrf
                                            @method('put')
                                            <div class="row pb-2">
                                                <label for="current_password" class="col-lg-3 col-form-label">Kata
                                                    Sandi
                                                    Saat
                                                    ini</label>
                                                <div class="col-lg-9">
                                                    <div class="form-group">
                                                        <input type="password" id="current_password" name="current_password"
                                                            class="form-control rounded @error('current_password') is-invalid @enderror"
                                                            spellcheck="false" placeholder="Masukan kata sandi saat ini">
                                                        <a tabindex="-1" href="#"
                                                            class="form-icon form-icon-right passcode-switch"
                                                            data-target="current_password">
                                                            <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                                            <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                                        </a>
                                                        @error('current_password')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row pb-2">
                                                <label for="new_password" class="col-lg-3 col-form-label">Kata
                                                    Sandi
                                                    Baru</label>
                                                <div class="col-lg-9">
                                                    <div class="form-group">
                                                        <input type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                                                            title="Harus berisi setidaknya satu angka dan satu huruf besar dan kecil, dan setidaknya 8 karakter atau lebih"
                                                            id="new_password"
                                                            class="form-control radius-30 @error('new_password') is-invalid @enderror"
                                                            name="new_password" placeholder="Masukan kata sandi baru">
                                                        <a tabindex="-1" href="#"
                                                            class="form-icon form-icon-right passcode-switch"
                                                            data-target="new_password">
                                                            <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                                            <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                                        </a>
                                                        @error('new_password')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                        <div class="alert alert-secondary mt-2 mb-0" role="alert"
                                                            id="new_password_message">
                                                            <p style="font-weight: bold;"> Kata Sandi harus
                                                                terdiri
                                                                dari: </p>
                                                            <p id="length" class="invalid"> Minimal <b> 8
                                                                    karakter
                                                                </b> </p>
                                                            <p id="letter" class="invalid"> Huruf <b> kecil
                                                                    (a-z)</b> </p>
                                                            <p id="capital" class="invalid"> Huruf <b> KAPITAL
                                                                    (A-Z)</b></p>
                                                            <p id="number" class="invalid"> <b>Angka</b>(0-9)
                                                            </p>
                                                            <p id="symbol" class="invalid">
                                                                <b>Symbol</b>(!$#%@)
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row pb-2">
                                                <label for="confirm_new_password" class="col-lg-3 col-form-label">Ulangi
                                                    Kata Sandi
                                                    Baru</label>
                                                <div class="col-lg-9">
                                                    <div class="form-group">
                                                        <input type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                                                            title="Harus berisi setidaknya satu angka dan satu huruf besar dan kecil, dan setidaknya 8 karakter atau lebih"
                                                            id="confirm_new_password"
                                                            class="form-control radius-30 @error('confirm_new_password') is-invalid @enderror"
                                                            name="confirm_new_password"
                                                            placeholder="konfirmasi kata sandi baru">
                                                        <a tabindex="-1" href="#"
                                                            class="form-icon form-icon-right passcode-switch"
                                                            data-target="confirm_new_password">
                                                            <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                                            <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                                        </a>
                                                        @error('confirm_new_password')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                        <div id="feedback" class="mt-2" style="display: none;">
                                                            <div id="confirm_new_password_message"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-primary disable-button">Simpan</button>
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
    <script src="{{ asset('assets/admin/js/interactions/weak-password.js?ver=1.0.0') }}"></script>
@endsection
