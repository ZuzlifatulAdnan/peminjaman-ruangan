@extends('layouts.app')

@section('title', 'Edit Proses Peminjaman')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
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
                        <form action="{{ route('peminjaman.updateProses', $pemesanan->id) }}" enctype="multipart/form-data"
                            method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="card">
                                <div class="card-header">
                                    <h4>Edit Proses Peminjaman</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-12 mb-3">
                                            <label for="status" class="form-label">Status</label>
                                            <select id="status"
                                                class="form-control @error('status') is-invalid @enderror" name="status"
                                                required>
                                                <option value="">Pilih Status</option>
                                                <option value="Diterima"
                                                    {{ old('status', $pemesanan->status) == 'Diterima' ? 'selected' : '' }}>
                                                    Diterima</option>
                                                <option value="Ditolak"
                                                    {{ old('status', $pemesanan->status) == 'Ditolak' ? 'selected' : '' }}>
                                                    Ditolak</option>
                                                <option value="Diproses"
                                                    {{ old('status', $pemesanan->status) == 'Diproses' ? 'selected' : '' }}>
                                                    Diproses</option>
                                            </select>
                                            @error('status')
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
@endsection

@push('scripts')
    <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
@endpush
