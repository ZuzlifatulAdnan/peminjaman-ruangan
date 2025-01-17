@extends('layouts.app')

@section('title', 'Edit UKM')

@push('style')
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
                            <form action="{{ route('ukm.update', $ukm->id) }}" enctype="multipart/form-data" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Edit UKM</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <!-- nama -->
                                            <div class="form-group col-md-12 mb-3">
                                                <label for="nama" class="form-label">Nama UKM</label>
                                                <input type="text" class="form-control" id="nama" name="nama"
                                                    value="{{ old('nama', $ukm->nama) }}" placeholder="Masukkan Nama UKM">
                                                @error('nama')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <!-- Nama Ketua Ukm  -->
                                        <div class="row">
                                            <div class="form-group col-md-12 mb-3">
                                                <label for="nama_ketua" class="form-label">Nama Ketua UKM</label>
                                                <input type="text" class="form-control" id="nama_ketua" name="nama_ketua"
                                                    value="{{ old('nama_ketua', $ukm->nama_ketua) }}"
                                                    placeholder="Masukkan Nama Ketua UKM">
                                                @error('nama_ketua')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <!-- Nomer ketua ukm -->
                                        <div class="row">
                                            <div class="form-group col-md-12 mb-3">
                                                <label for="nomer_ketua" class="form-label">Nomer Ketua UKM</label>
                                                <input type="text" class="form-control" id="nomer_ketua"
                                                    name="nomer_ketua" value="{{ old('nomer_ketua', $ukm->nomer_ketua) }}"
                                                    placeholder="Masukkan Nomer Ketua UKM">
                                                @error('nomer_ketua')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary mt-2">Update</button>
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
