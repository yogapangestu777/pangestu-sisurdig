@extends('layouts.admin')
@section('app')
    <div class="nk-content nk-content-fluid">
        <div class="container-xl wide-lg">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        @include('partials.admin._page-title')
                        @can('parties.store')
                            <div class="nk-block-head-content">
                                <div class="toggle-wrap nk-block-tools-toggle">
                                    <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1"
                                        data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                                    <div class="toggle-expand-content" data-content="pageMenu">
                                        <ul class="nk-block-tools g-3">
                                            <li>
                                                <a href="javascript:void(0)" class="btn btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#create-modal" data-title="Tambah"
                                                    data-url="{{ route('admin.master.parties.store') }}" data-method="post">
                                                    <span>Tambah</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div><!-- .nk-block-head-content -->
                        @endcan
                    </div><!-- .nk-block-between -->
                </div><!-- .nk-block-head -->
                <div class="nk-block nk-block-lg">
                    <div class="card card-bordered card-preview">
                        <div class="card-inner">
                            <table class="datatable-init table" data-auto-responsive="true"
                                data-ajax="{{ route('admin.master.parties.index') }}" id="datatable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Penginput</th>
                                        <th>Nama</th>
                                        <th>Tipe</th>
                                        <th>Email</th>
                                        <th>No Telepon</th>
                                        <th>Alamat</th>
                                        <th>Tanggal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div><!-- .card-preview -->
                </div> <!-- nk-block -->
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" id="create-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                    </h5>
                    <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <em class="icon ni ni-cross"></em>
                    </a>
                </div>
                <form action="" method="post" id="form" autocomplete="off">
                    @csrf
                    <input type="hidden" name="_method" id="form-method">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label" for="name">Nama</label>
                                    <div class="form-control-wrap">
                                        <input type="text" name="name"
                                            class="form-control @error('name') is-invalid @enderror" id="name"
                                            placeholder="Masukan nama" value="{{ old('name') }}">
                                        @error('name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="type" class="form-label">Tipe</label>
                                    <div class="form-control-wrap">
                                        <ul class="custom-control-group">
                                            <li>
                                                <div class="custom-control custom-radio custom-control-pro no-control">
                                                    <input type="radio" class="custom-control-input" name="type"
                                                        value="1" id="individu" @checked(old('type') == '1')>
                                                    <label class="custom-control-label" for="individu">Individu</label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="custom-control custom-radio custom-control-pro no-control">
                                                    <input type="radio" class="custom-control-input" name="type"
                                                        value="2" id="organization" @checked(old('type') == '2')>
                                                    <label class="custom-control-label"
                                                        for="organization">Organisasi/Agensi</label>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    @error('type')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label" for="email">Email</label>
                                    <div class="form-control-wrap">
                                        <input type="text" name="email"
                                            class="form-control @error('email') is-invalid @enderror" id="email"
                                            placeholder="Masukan email" value="{{ old('email') }}">
                                        @error('email')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label" for="phone_number">No Telepon</label>
                                    <div class="form-control-wrap">
                                        <input type="text" inputmode="numeric" name="phone_number"
                                            class="form-control @error('phone_number') is-invalid @enderror"
                                            id="phone_number" placeholder="Masukan no telepon"
                                            value="{{ old('phone_number') }}">
                                        @error('phone_number')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label" for="address">Alamat</label>
                                    <div class="form-control-wrap">
                                        <textarea name="address" class="form-control @error('address') is-invalid @enderror" id="address"
                                            placeholder="Masukan alamat">{{ old('address') }}</textarea>
                                        @error('address')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="submit" class="btn btn-primary disable-button">Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        let isVisible = @json($isVisible);
    </script>
    <script src="{{ asset('assets/admin/js/table/party.js?ver=1.0.0') }}"></script>
    <script src="{{ asset('assets/admin/js/interactions/confirmation.js?ver=1.0.0') }}"></script>
    <script src="{{ asset('assets/admin/js/interactions/disable-button.js?ver=1.0.0') }}"></script>
    <script src="{{ asset('assets/admin/js/modals/party.js?ver=1.0.0') }}"></script>
@endsection
