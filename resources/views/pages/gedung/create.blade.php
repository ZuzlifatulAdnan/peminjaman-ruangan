@extends('layouts.app')

@section('title', 'Gedung')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        @include('layouts.alert')
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <form action="{{ route('gedung.store') }}" enctype="multipart/form-data" method="POST">
                            @csrf
                            <div class="card">
                                <div class="card-header">
                                    <h4>Tambah Gedung</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <!-- nama -->
                                        <div class="form-group col-md-12 mb-3">
                                            <label for="nama" class="form-label">Nama Gedung</label>
                                            <input type="text" class="form-control" id="nama" name="nama"
                                                value="{{ old('nama') }}" placeholder="Masukkan Nama Gedung">
                                            @error('nama')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary mt-2">Simpan</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
@endpush
