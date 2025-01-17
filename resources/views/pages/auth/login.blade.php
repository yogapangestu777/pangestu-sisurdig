@extends('layouts.auth')
@section('app')
    <div class="nk-app-root">
        <div class="nk-main ">
            <div class="nk-wrap nk-wrap-nosidebar">
                <div class="nk-content"
                    style="background-size: cover; height: 100vh; background-position: center center; background-repeat: no-repeat; background-image: url('/assets/images/auth.jpg'); background-attachment: fixed">
                    <div class="nk-block nk-block-middle nk-auth-body  wide-xs">
                        <div class="brand-logo pb-4 text-center">
                            <a href="html/index.html" class="logo-link">
                                <img class="logo-light logo-img logo-img-lg" src="{{ asset('assets/images/logo/logo.png') }}"
                                    srcset="{{ asset('assets/images/logo/logo2x.png 2x') }}" alt="logo">
                                <img class="logo-dark logo-img logo-img-lg"
                                    src="{{ asset('assets/images/logo/logo-dark.png') }}"
                                    srcset="{{ asset('assets/images/logo/logo-dark2x.png 2x') }}" alt="logo-dark">
                            </a>
                        </div>
                        <div class="card card-bordered">
                            <div class="card-inner card-inner-lg">
                                <div class="nk-block-head">
                                    <div class="nk-block-head-content">
                                        <h4 class="nk-block-title">Masuk Akun</h4>
                                        <div class="nk-block-des">
                                            <p>Akses admin panel menggunakan <b>email</b> atau <b>nama pengguna</b> dan
                                                <b>kata
                                                    sandi
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <form action="{{ route('login.post') }}" class="form-validate is-alter was-validated"
                                    autocomplete="off" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label class="form-label" for="login">Email atau Nama Pengguna</label>
                                        </div>
                                        <div class="form-control-wrap">
                                            <input name="login" type="text"
                                                class="form-control @error('login') is-invalid @enderror form-control-lg"
                                                id="login" placeholder="Masukan email atau nama pengguna">
                                            @error('login')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div><!-- .form-group -->
                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label class="form-label" for="password">Kata Sandi</label>
                                            <a class="link link-primary link-sm" tabindex="-1"
                                                href="html/pages/auths/auth-reset.html">Lupa Kata Sandi?</a>
                                        </div>
                                        <div class="form-control-wrap">
                                            <a tabindex="-1" href="#"
                                                class="form-icon form-icon-right passcode-switch lg" data-target="password">
                                                <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                                <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                            </a>
                                            <input name="password" type="password"
                                                class="form-control @error('password') is-invalid @enderror form-control-lg"
                                                id="password" placeholder="Masukan kata sandi">
                                            @error('password')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div><!-- .form-group -->
                                    <div
                                        class="col-12 d-flex justify-content-center mb-2 @error('g-recaptcha-response') is-invalid
                                @enderror">
                                        <div> {!! htmlFormSnippet() !!} </div>
                                    </div>
                                    @error('g-recaptcha-response')
                                        <dibv class="invalid-feedback d-flex justify-content-center">
                                            {{ $message }}
                                        </dibv>
                                    @enderror
                                    <div class="form-group">
                                        <button class="btn btn-lg btn-primary btn-block disable-button">Masuk</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- wrap @e -->
            </div>
            <!-- content @e -->
        </div>
        <!-- main @e -->
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('assets/admin/js/interactions/disable-button.js?ver=1.0.0') }}"></script>
@endsection
