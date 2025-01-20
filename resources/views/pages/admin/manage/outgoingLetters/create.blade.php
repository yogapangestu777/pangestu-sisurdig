@extends('layouts.admin')
@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/libs/dropzone.css?ver=1.0.0') }}">
@endsection
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
                                            <a href="{{ route('admin.manage.outgoingLetters.index') }}"
                                                class="btn btn-secondary">
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
                    <form action="{{ route('admin.manage.outgoingLetters.store') }}" method="post" autocomplete="off">
                        @csrf
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="card card-bordered">
                                    <div class="card-inner">
                                        <div class="row g-3">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="form-label" for="reference_number">No Referensi</label>
                                                    <div class="form-control-wrap">
                                                        <input type="text" name="reference_number"
                                                            class="form-control @error('reference_number') is-invalid @enderror"
                                                            id="reference_number" placeholder="Masukan no referensi"
                                                            value="{{ old('reference_number') }}">
                                                        @error('reference_number')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="form-label" for="subject">Subjek</label>
                                                    <div class="form-control-wrap">
                                                        <input type="text" name="subject"
                                                            class="form-control @error('subject') is-invalid @enderror"
                                                            id="subject" placeholder="Masukan subjek"
                                                            value="{{ old('subject') }}">
                                                        @error('subject')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="form-label" for="content">Konten</label>
                                                    <div class="form-control-wrap">
                                                        <textarea name="content" class="form-control tinymce @error('content') is-invalid @enderror" id="content"
                                                            placeholder="Masukan konten">{{ old('content') }}</textarea>
                                                        @error('content')
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
                            </div>
                            <div class="col-lg-4">
                                <div class="card card-bordered">
                                    <div class="card-inner">
                                        <div class="row g-3">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="form-label" for="category">Kategori</label>
                                                    <div class="form-control-wrap">
                                                        <select name="category"
                                                            class="form-select js-select2 @error('category') is-invalid @enderror"
                                                            id="category" data-placeholder="Pilih kategori"
                                                            data-search="true" data-clear="on">
                                                            <option value=""></option>
                                                            @foreach ($categories as $category)
                                                                <option value="{{ $category->id }}"
                                                                    @selected(old('category') == $category->id)>
                                                                    {{ $category->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('category')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="form-label" for="party">Pihak Terkait</label>
                                                    <div class="form-control-wrap">
                                                        <select name="party"
                                                            class="form-select js-select2 @error('party') is-invalid @enderror"
                                                            id="party" data-placeholder="Pilih pihak Terkait"
                                                            data-search="true" data-clear="on">
                                                            <option value=""></option>
                                                            @foreach ($parties as $party)
                                                                <option value="{{ $party->id }}"
                                                                    @selected(old('party') == $party->id)>
                                                                    {{ $party->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('party')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="file" class="form-label">File</label>
                                                    <div class="upload-zone file @error('file') is-invalid @enderror"
                                                        data-input-name="file">
                                                        <div class="dz-message" data-dz-message>
                                                            <span class="dz-message-text">Seret file ke sini untuk
                                                                mengunggah</span>
                                                            <span class="dz-message-text">atau</span>
                                                            <button type="button" class="btn btn-primary">Pilih</button>
                                                        </div>
                                                        <div class="previews-container"></div>
                                                    </div>
                                                    @error('file')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
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
    <script>
        let uploadUrl = "{{ route('admin.attachment.upload', ['folder' => 'outgoing-letters']) }}";
    </script>
    <script src="{{ asset('assets/admin/js/libs/dropzone/message.js?ver=1.0.0') }}"></script>
    <script src="{{ asset('assets/admin/js/libs/dropzone/create.js?ver=1.0.0') }}"></script>
    <script src="{{ asset('assets/admin/js/interactions/disable-button.js?ver=1.0.0') }}"></script>
    <script src="https://cdn.tiny.cloud/1/uq0tce17zffxdk3vxbmk7s7nvv7hg15t5ntgqfyzhmbxu3g4/tinymce/7/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script src="{{ asset('assets/admin/js/libs/editors/tinymce.js?ver=1.0.0') }}"></script>
@endsection
