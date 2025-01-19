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
                                            <a href="{{ route('admin.manage.incomingLetters.index') }}"
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
                    <form action="{{ route('admin.manage.incomingLetters.update', $incomingLetter->id) }}" method="post"
                        autocomplete="off">
                        @csrf
                        @method('put')
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
                                                            value="{{ old('reference_number', $incomingLetter->reference_number) }}">
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
                                                            value="{{ old('subject', $incomingLetter->subject) }}">
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
                                                    <label class="form-label" for="description">Keterangan</label>
                                                    <div class="form-control-wrap">
                                                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description"
                                                            placeholder="Masukan keterangan">{{ old('description', $incomingLetter->description) }}</textarea>
                                                        @error('description')
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
                                                                    @selected($incomingLetter->category_id == $category->id)>
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
                                                                    @selected($incomingLetter->party_id == $party->id)>
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
    <script src="{{ asset('assets/admin/js/interactions/disable-button.js?ver=1.0.0') }}"></script>
@endsection
