@extends('layouts.app')

@section('title', 'Beranda')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h4>Selamat Datang ! {{ Auth::user()->name }} Di Sistem Peminjaman Ruangan</h4>
            </div>
            <div class="section-body">
                @if (Auth::user()->role == 'Admin' || Auth::user()->role == 'PLPP')
                <div class="row">
                    <!-- Statistik -->
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-primary">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>{{ __('Users') }}</h4>
                                </div>
                                <div class="card-body">
                                    {{ $totalUser }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-success">
                                <i class="fas fa-building"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>{{ __('UKM') }}</h4>
                                </div>
                                <div class="card-body">
                                    {{ $totalUKM }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-warning">
                                <i class="fas fa-door-closed"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>{{ __('Rooms') }}</h4>
                                </div>
                                <div class="card-body">
                                    {{ $totalRuangan }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-danger">
                                <i class="fas fa-building-columns"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>{{ __('Buildings') }}</h4>
                                </div>
                                <div class="card-body">
                                    {{ $totalGedung }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-12">
                        <h4 class="mb-4">Daftar Ruangan</h4>
                        <div class="row">
                            @foreach ($ruangans->groupBy('gedung.nama') as $gedungNama => $ruanganGroup)
                                <div class="col-md-6 col-lg-4">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="card-title">Gedung {{ $gedungNama }}</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                @foreach ($ruanganGroup as $ruangan)
                                                    <div class="col-12 mb-2">
                                                        @if ($ruangan->status == 'Tersedia')
                                                            <a href="{{ route('peminjaman.input', ['ruangan_id' => $ruangan->id]) }}" 
                                                               class="d-flex justify-content-between align-items-center border rounded p-3 text-decoration-none text-dark shadow-sm hover-shadow">
                                                                <span class="font-weight-bold">{{ $ruangan->nama }}</span>
                                                                <span class="badge badge-success">Tersedia</span>
                                                            </a>
                                                        @else
                                                            <div class="d-flex justify-content-between align-items-center border rounded p-3 bg-light shadow-sm">
                                                                <span class="font-weight-bold">{{ $ruangan->nama }}</span>
                                                                <span class="badge badge-danger">Tidak Tersedia</span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @else
                <div class="row mt-4">
                    <div class="col-12">
                        <h4 class="mb-4">Daftar Ruangan</h4>
                        <div class="row">
                            @foreach ($ruangans->groupBy('gedung.nama') as $gedungNama => $ruanganGroup)
                                <div class="col-md-6 col-lg-4">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="card-title">Gedung {{ $gedungNama }}</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                @foreach ($ruanganGroup as $ruangan)
                                                    <div class="col-12 mb-2">
                                                        @if ($ruangan->status == 'Tersedia')
                                                            <a href="{{ route('peminjaman.input', ['ruangan_id' => $ruangan->id]) }}" 
                                                               class="d-flex justify-content-between align-items-center border rounded p-3 text-decoration-none text-dark shadow-sm hover-shadow">
                                                                <span class="font-weight-bold">{{ $ruangan->nama }}</span>
                                                                <span class="badge badge-success">Tersedia</span>
                                                            </a>
                                                        @else
                                                            <div class="d-flex justify-content-between align-items-center border rounded p-3 bg-light shadow-sm">
                                                                <span class="font-weight-bold">{{ $ruangan->nama }}</span>
                                                                <span class="badge badge-danger">Tidak Tersedia</span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>  
                @endif
            </div>
        </section>
    </div>
@endsection
