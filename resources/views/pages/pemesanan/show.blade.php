@extends('layouts.app')

@section('title', 'Pemesanan')

@push('style')
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="card">
                    <div class="card-header">
                        <h4>Detail Pemesanan</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @if ($pemesanan->user->role == 'Mahasiswa')
                                <div class="col-md-4 detail-value">
                                    <span class="detail-header">Nama Pemesan|| NPM:</span>
                                    <p>{{ $pemesanan->user->name }} || {{ $pemesanan->user->npm }}</p>
                                </div>
                                <div class="col-md-4 detail-value">
                                    <span class="detail-header">UKM:</span>
                                    <p>{{ $pemesanan->ukm->nama }}</p>
                                </div>
                                <div class="col-md-4 detail-value">
                                    <span class="detail-header">Ruangan || Gedung:</span>
                                    <p>{{ $pemesanan->ruangan->nama }} || {{ $pemesanan->ruangan->gedung->nama }} </p>
                                </div>
                            @else
                                <div class="col-md-6 detail-value">
                                    @if($pemesanan->user->role == 'Dosen')
                                        <span class="detail-header">Nama Pemesan|| NIP:</span>
                                        <p>{{ $pemesanan->user->name }} || {{ $pemesanan->user->nip }}</p>
                                    @else
                                        <span class="detail-header">Nama Pemesan:</span>
                                        <p>{{ $pemesanan->user->name }}</p>
                                    @endif
                                </div>
                                <div class="col-md-6 detail-value">
                                    <span class="detail-header">Ruangan || Gedung:</span>
                                    <p>{{ $pemesanan->ruangan->nama }} || {{ $pemesanan->ruangan->gedung->nama }} </p>
                                </div>
                            @endif

                        </div>
                        <div class="row">
                            <div class="col-md-6 detail-value">
                                <span class="detail-header">Tanggal Pesan:</span>
                                <p>{{ $pemesanan->tanggal_pesan }}</p>
                            </div>
                            <div class="col-md-6 detail-value">
                                <span class="detail-header">Waktu Mulai - Waktu Selesai:</span>
                                <p>{{ $pemesanan->waktu_mulai }} - {{ $pemesanan->waktu_selesai }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 detail-value">
                                <span class="detail-header">Tujuan:</span>
                                <p>{{ $pemesanan->tujuan }}</p>
                            </div>
                            <div class="col-md-6 detail-value">
                                <span class="detail-header">Status:</span>
                                <p>{{ $pemesanan->status }}</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('pemesanan.edit', $pemesanan->id) }}" class="btn btn-primary">Edit</a>
                            <a href="{{ route('pemesanan.index') }}" class="btn btn-warning">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
