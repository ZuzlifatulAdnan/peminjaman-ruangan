@extends('layouts.app')

@section('title', 'Peminjaman')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
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
                            <form action="{{ route('pemesanan.store') }}" enctype="multipart/form-data" method="POST">
                                @csrf
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Tambah Peminjaman</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="form-group col-md-4 mb-3">
                                                <label for="user_id" class="form-label">User</label>
                                                <select id="user_id"
                                                    class="form-control select2 @error('user_id') is-invalid @enderror"
                                                    name="user_id" required>
                                                    <option value="">Pilih User</option>
                                                    @foreach ($users as $user)
                                                        <option value="{{ $user->id }}"
                                                            {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                                            {{ $user->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('user_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-4 mb-3">
                                                <label for="ruangan_id" class="form-label">Ruangan</label>
                                                <select id="ruangan_id"
                                                    class="form-control select2 @error('ruangan_id') is-invalid @enderror"
                                                    name="ruangan_id" required>
                                                    <option value="">Pilih Ruangan</option>
                                                    @foreach ($ruangans->groupBy('gedung.nama') as $gedungNama => $ruanganList)
                                                        <optgroup label="Gedung {{ $gedungNama }}">
                                                            @foreach ($ruanganList as $ruangan)
                                                                <option value="{{ $ruangan->id }}"
                                                                    {{ old('ruangan_id') == $ruangan->id ? 'selected' : '' }}>
                                                                    {{ $ruangan->nama }}
                                                                </option>
                                                            @endforeach
                                                        </optgroup>
                                                    @endforeach
                                                </select>
                                                @error('user_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-4 mb-3">
                                                <label for="ukm_id" class="form-label">UKM</label>
                                                <select id="ukm_id"
                                                    class="form-control select2 @error('ukm_id') is-invalid @enderror"
                                                    name="ukm_id">
                                                    <option value="">Pilih UKM</option>
                                                    @foreach ($ukms as $ukm)
                                                        <option value="{{ $ukm->id }}"
                                                            {{ old('ukm_id') == $ukm->id ? 'selected' : '' }}>
                                                            {{ $ukm->nama }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('ukm_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-4 mb-3">
                                                <label for="tanggal_pesan" class="form-label">Tanggal Pesan</label>
                                                <input type="date"
                                                    class="form-control @error('tanggal_pesan') is-invalid @enderror"
                                                    id="tanggal_pesan" name="tanggal_pesan"
                                                    value="{{ old('tanggal_pesan') }}">
                                                @error('tanggal_pesan')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-4 mb-3">
                                                <label for="waktu_mulai" class="form-label">Waktu Mulai</label>
                                                <input type="time"
                                                    class="form-control @error('waktu_mulai') is-invalid @enderror"
                                                    id="waktu_mulai" name="waktu_mulai" value="{{ old('waktu_mulai') }}">
                                                @error('waktu_mulai')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-4 mb-3">
                                                <label for="waktu_selesai" class="form-label">Waktu Selesai</label>
                                                <input type="time"
                                                    class="form-control @error('waktu_selesai') is-invalid @enderror"
                                                    id="waktu_selesai" name="waktu_selesai"
                                                    value="{{ old('waktu_selesai') }}">
                                                @error('waktu_selesai')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-6 mb-3">
                                                <label for="tujuan" class="form-label">Tujuan</label>
                                                <input type="text"
                                                    class="form-control @error('tujuan') is-invalid @enderror"
                                                    id="tujuan" name="tujuan" value="{{ old('tujuan') }}"
                                                    placeholder="Masukkan Tujuan">
                                                @error('tujuan')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6 mb-3">
                                                <label for="status" class="form-label">Status</label>
                                                <select id="status"
                                                    class="form-control @error('status') is-invalid @enderror"
                                                    name="status" required>
                                                    <option value="">Pilih Status</option>
                                                    <option value="Selesai"
                                                        {{ old('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                                    <option value="Diterima"
                                                        {{ old('status') == 'Diterima' ? 'selected' : '' }}>Diterima
                                                    </option>
                                                    <option value="Ditolak"
                                                        {{ old('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak
                                                    </option>
                                                    <option value="Diproses"
                                                        {{ old('status') == 'Diproses' ? 'selected' : '' }}>Diproses
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
    <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>
@endpush
