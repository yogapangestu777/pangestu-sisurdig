@extends('layouts.admin')
@section('app')
    <div class="nk-content nk-content-fluid">
        <div class="container-xl wide-lg">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        @include('partials.admin._page-title')
                        @can('outgoingLetters.create')
                            <div class="nk-block-head-content">
                                <div class="toggle-wrap nk-block-tools-toggle">
                                    <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1"
                                        data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                                    <div class="toggle-expand-content" data-content="pageMenu">
                                        <ul class="nk-block-tools g-3">
                                            <li>
                                                <a href="{{ route('admin.manage.outgoingLetters.create') }}"
                                                    class="btn btn-primary">
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
                                data-ajax="{{ route('admin.manage.outgoingLetters.index') }}" id="datatable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Penginput</th>
                                        <th>Pihak Terkait</th>
                                        <th>Kategori</th>
                                        <th>No Referensi</th>
                                        <th>Subjek</th>
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
@endsection
@section('scripts')
    <script>
        let isVisible = @json($isVisible);
    </script>
    <script src="{{ asset('assets/admin/js/table/outgoing-letter.js?ver=1.0.0') }}"></script>
    <script src="{{ asset('assets/admin/js/interactions/confirmation.js?ver=1.0.0') }}"></script>
@endsection
