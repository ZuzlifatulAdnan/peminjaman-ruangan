@extends('layouts.app')

@section('title', 'Export Pemesanan')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Export Data Pemesanan</h1>
            </div>
            <div class="section-body">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h4>Pilih Bulan dan Tahun</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('pemesanan.export.download') }}" method="GET">
                                    <div class="form-group">
                                        <label for="bulan">Bulan</label>
                                        <select name="bulan" id="bulan" class="form-control" required>
                                            <option value="">-- Pilih Bulan --</option>
                                            @foreach ($months as $key => $month)
                                                <option value="{{ $key }}"
                                                    {{ request('bulan') == $key ? 'selected' : '' }}>
                                                    {{ $month }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="tahun">Tahun</label>
                                        <select name="tahun" id="tahun" class="form-control" required>
                                            <option value="">-- Pilih Tahun --</option>
                                            @foreach ($years as $year)
                                            <option value="{{ $year }}"
                                                {{ request('tahun') == $year ? 'selected' : '' }}>
                                                {{ $year }}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group text-center">
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-file-excel"></i> Export Excel
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
