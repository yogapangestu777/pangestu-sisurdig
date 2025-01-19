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
                                            <a href="{{ route('admin.manage.users.create') }}" class="btn btn-primary">
                                                <span>Tambah</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div><!-- .nk-block-head-content -->
                    </div><!-- .nk-block-between -->
                </div><!-- .nk-block-head -->
                <div class="nk-block nk-block-lg">
                    <div class="card card-bordered card-preview">
                        <div class="card-inner">
                            <table class="datatable-init table" data-auto-responsive="true" id="datatable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Lengkap</th>
                                        <th>Nama Pengguna</th>
                                        <th>Email</th>
                                        <th>No Telepon</th>
                                        <th>Tempat Lahir</th>
                                        <th>Tanggal Lahir</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Status Aktif</th>
                                        <th>Role</th>
                                        <th>Tanggal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $user->full_name }}</td>
                                            <td>{{ $user->username }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->phone_number }}</td>
                                            <td>{{ $user->pob }}</td>
                                            <td>{{ $user->dob }}</td>
                                            <td>{{ $user->gender }}</td>
                                            <td>{!! $user->is_active_badge !!}</td>
                                            <td>{{ $user->role }}</td>
                                            <td>{{ $user->created_at }}</td>
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
                                                                    <li>
                                                                        <form
                                                                            action="{{ route('admin.manage.users.toggleStatus', $user->id) }}"
                                                                            method="post">
                                                                            @csrf
                                                                            @method('put')
                                                                            <input type="hidden" name="status"
                                                                                value="{{ $user->is_active }}">
                                                                            <a href="javascript:void(0)"
                                                                                class="toggle-status">
                                                                                <em
                                                                                    class="icon ni ni-{{ $user->is_active === '0' ? 'check' : 'cross' }}"></em>
                                                                                <span>{{ $user->is_active === '0' ? 'Aktifkan' : 'Non-aktifkan' }}</span>
                                                                            </a>
                                                                        </form>
                                                                    </li>
                                                                    <li>
                                                                        <form
                                                                            action="{{ route('admin.manage.users.resetPassword', $user->id) }}"
                                                                            method="post">
                                                                            @csrf
                                                                            @method('put')
                                                                            <a href="javascript:void(0)"
                                                                                class="reset-password">
                                                                                <em class="icon ni ni-unlock"></em>
                                                                                <span>Reset Kata Sandi</span>
                                                                            </a>
                                                                        </form>
                                                                    </li>
                                                                    <li>
                                                                        <a
                                                                            href="{{ route('admin.manage.users.edit', $user->id) }}">
                                                                            <em class="icon ni ni-edit"></em>
                                                                            <span>Edit</span>
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <form
                                                                            action="{{ route('admin.manage.users.destroy', $user->id) }}"
                                                                            method="post">
                                                                            @csrf
                                                                            @method('delete')
                                                                            <a href="javascript:void(0)" class="delete">
                                                                                <em class="icon ni ni-trash"></em>
                                                                                <span>Hapus</span>
                                                                            </a>
                                                                        </form>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </td>
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
@endsection
@section('scripts')
    <script src="{{ asset('assets/admin/js/table/client-side.js?ver=1.0.0') }}"></script>
    <script src="{{ asset('assets/admin/js/interactions/confirmation.js?ver=1.0.0') }}"></script>
@endsection
