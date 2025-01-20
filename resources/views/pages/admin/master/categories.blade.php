@extends('layouts.admin')
@section('app')
    <div class="nk-content nk-content-fluid">
        <div class="container-xl wide-lg">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        @include('partials.admin._page-title')
                        @can('categories.store')
                            <div class="nk-block-head-content">
                                <div class="toggle-wrap nk-block-tools-toggle">
                                    <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1"
                                        data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                                    <div class="toggle-expand-content" data-content="pageMenu">
                                        <ul class="nk-block-tools g-3">
                                            <li>
                                                <a href="javascript:void(0)" class="btn btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#create-modal" data-title="Tambah"
                                                    data-url="{{ route('admin.master.categories.store') }}" data-method="post">
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
                            <table class="datatable-init table" data-auto-responsive="true" id="datatable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Penginput</th>
                                        <th>Nama</th>
                                        <th>Tanggal</th>
                                        @can(['categories.update', 'categories.delete'])
                                            <th>Aksi</th>
                                        @endcan
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categories as $category)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $category->enhancer }}</td>
                                            <td>{{ $category->name }}</td>
                                            <td>{{ $category->created_at }}</td>
                                            @canany(['categories.update', 'categories.delete'])
                                                <td class="nk-tb-col nk-tb-col-tools">
                                                    <ul class="gx-1">
                                                        <li>
                                                            <div class="drodown">
                                                                <a href="#"
                                                                    class="dropdown-toggle btn btn-icon btn-trigger"
                                                                    data-bs-toggle="dropdown">
                                                                    <em class="icon ni ni-more-h"></em>
                                                                </a>
                                                                <div class="dropdown-menu dropdown-menu">
                                                                    <ul class="link-list-opt no-bdr">
                                                                        @can('categories.update')
                                                                            <li>
                                                                                <a href="javascript:void(0)" data-bs-toggle="modal"
                                                                                    data-bs-target="#create-modal" data-title="Edit"
                                                                                    data-url="{{ route('admin.master.categories.update', $category->id) }}"
                                                                                    data-method="put"
                                                                                    data-name="{{ $category->name }}">
                                                                                    <em class="icon ni ni-edit"></em>
                                                                                    <span>Edit</span>
                                                                                </a>
                                                                            </li>
                                                                        @endcan
                                                                        @can('categories.delete')
                                                                            <li>
                                                                                <form
                                                                                    action="{{ route('admin.master.categories.destroy', $category->id) }}"
                                                                                    method="post">
                                                                                    @csrf
                                                                                    @method('delete')
                                                                                    <a href="javascript:void(0)" class="delete">
                                                                                        <em class="icon ni ni-trash"></em>
                                                                                        <span>Hapus</span>
                                                                                    </a>
                                                                                </form>
                                                                            </li>
                                                                        @endcan
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </td>
                                            @endcan
                                        </tr>
                                    @endforeach
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
                <form action="" method="post" id="form">
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
    <script src="{{ asset('assets/admin/js/table/client-side.js?ver=1.0.0') }}"></script>
    <script src="{{ asset('assets/admin/js/interactions/confirmation.js?ver=1.0.0') }}"></script>
    <script src="{{ asset('assets/admin/js/interactions/disable-button.js?ver=1.0.0') }}"></script>
    <script src="{{ asset('assets/admin/js/modals/category.js?ver=1.0.0') }}"></script>
@endsection
