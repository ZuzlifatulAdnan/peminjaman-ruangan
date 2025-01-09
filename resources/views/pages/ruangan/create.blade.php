@extends('layouts.app')

@section('title', 'Ruangan')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    @if (Auth::user()->role == 'Admin' || Auth::user()->role == 'PLPP')
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
                            <form action="{{ route('ruangan.store') }}" enctype="multipart/form-data" method="POST">
                                @csrf
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Tambah Ruangan</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <!-- Nama -->
                                            <div class="form-group col-md-4 mb-3">
                                                <label for="nama" class="form-label">Nama Ruangan</label>
                                                <input type="text"
                                                    class="form-control @error('nama') is-invalid @enderror" id="nama"
                                                    name="nama" value="{{ old('nama') }}"
                                                    placeholder="Masukkan Nama Ruangan" required>
                                                @error('nama')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Gedung -->
                                            <div class="form-group col-md-4 mb-3">
                                                <label for="gedung_id" class="form-label">Gedung</label>
                                                <select id="gedung_id"
                                                    class="form-control @error('gedung_id') is-invalid @enderror"
                                                    name="gedung_id" required>
                                                    <option value="">Pilih Gedung</option>
                                                    @foreach ($gedungs as $gedung)
                                                        <option value="{{ $gedung->id }}"
                                                            {{ old('gedung_id') == $gedung->id ? 'selected' : '' }}>
                                                            {{ $gedung->nama }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('gedung_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Status -->
                                            <div class="form-group col-md-4 mb-3">
                                                <label for="status" class="form-label">Status</label>
                                                <select id="status"
                                                    class="form-control @error('status') is-invalid @enderror"
                                                    name="status" required>
                                                    <option value="">Pilih Status</option>
                                                    <option value="Tersedia"
                                                        {{ old('status') == 'Tersedia' ? 'selected' : '' }}>Tersedia
                                                    </option>
                                                    <option value="Tidak Tersedia"
                                                        {{ old('status') == 'Tidak Tersedia' ? 'selected' : '' }}>Tidak
                                                        Tersedia
                                                    </option>
                                                </select>
                                                @error('status')
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
    @else
    @endif

@endsection

@push('scripts')
@endpush
