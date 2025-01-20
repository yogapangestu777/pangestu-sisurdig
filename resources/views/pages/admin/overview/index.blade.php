@extends('layouts.admin')
@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/custom.css?ver=1.0.0') }}">
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
                <div class="nk-block">
                    <div class="row g-gs">
                        <div class="col-lg-8">
                            <div class="card card-bordered h-100">
                                <div class="card-inner">
                                    <div class="card-title-group align-start mb-3">
                                        <div class="card-title">
                                            <h6 class="title">Perhitungan Data</h6>
                                            <p>
                                                Menghitung total jumlah data yang tersimpan dalam aplikasi untuk
                                                memperoleh
                                                informasi akurat mengenai volume data yang dikelola.
                                            </p>
                                        </div>
                                        <div class="card-tools mt-n1 me-n1">
                                            <div class="dropdown">
                                                <a href="#" class="dropdown-toggle btn btn-icon btn-trigger"
                                                    data-bs-toggle="dropdown">
                                                    <em class="icon ni ni-more-h"></em>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-sm dropdown-menu-end">
                                                    <ul class="link-list-opt no-bdr">
                                                        <li>
                                                            <a href="javascript:void(0)"
                                                                data-url="{{ route('admin.overview.getDataByTime', 'month') }}"
                                                                class="filter">
                                                                <span>Bulan Ini</span>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:void(0)"
                                                                data-url="{{ route('admin.overview.getDataByTime', 'year') }}"
                                                                class="filter">
                                                                <span>Tahun Ini</span>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:void(0)"
                                                                data-url="{{ route('admin.overview.getDataByTime', 'all-time') }}"
                                                                class="active filter">
                                                                <span>Semua</span>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- .card-title-group -->
                                    <div class="nk-order-ovwg">
                                        <div class="row g-4 align-end">
                                            <div class="col-xxl-4">
                                                <div class="row g-4" id="forCardsContainer">
                                                    @include('pages.admin.overview.count-data-content')
                                                </div>
                                            </div><!-- .col -->
                                        </div>
                                    </div><!-- .nk-order-ovwg -->
                                </div><!-- .card-inner -->
                            </div><!-- .card -->
                        </div><!-- .col -->
                        <div class="col-lg-4">
                            <div class="card card-bordered">
                                <div class="card-inner-group">
                                    <div class="card-inner card-inner-md">
                                        <div class="card-title-group">
                                            <div class="card-title">
                                                <h6 class="title">Penerima Surat Terbanyak</h6>
                                            </div>
                                        </div>
                                    </div><!-- .card-inner -->
                                    <div id="mostFrequentPartyContainer">
                                        @include('pages.admin.overview.most-frequent-letter-party-content')
                                    </div>
                                </div><!-- .card-inner-group -->
                            </div><!-- .card -->
                        </div><!-- .col -->
                    </div><!-- .row -->
                </div><!-- .nk-block -->
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('assets/admin/js/ajax/overview.js?ver=1.0.0') }}"></script>
@endsection
