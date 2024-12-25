@extends('layouts.app')

@section('title', 'Pemesanan')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/d') }}">
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
                        <div class="card">
                            <div class="card-header">
                                <h4>Data Pemesanan</h4>
                            </div>
                            <div class="card-body">
                                <div class="p-2">
                                    <div class="float-left">
                                        <div class="section-header-button">
                                            <a href="{{ route('pemesanan.create') }}" class="btn btn-primary">Tambah</a>
                                        </div>
                                    </div>
                                    <div class="float-right">
                                        <form action="{{ route('pemesanan.index') }}" method="GET">
                                            <div class="input-group">
                                                <select name="bulan" class="form-control" onchange="this.form.submit()">
                                                    <option value="">Bulan</option>
                                                    @foreach ($months as $key => $month)
                                                        <option value="{{ $key }}" {{ request('bulan') == $key ? 'selected' : '' }}>
                                                            {{ $month }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <select name="tahun" class="form-control" onchange="this.form.submit()">
                                                    <option value="">Tahun</option>
                                                    @foreach ($years as $year)
                                                        <option value="{{ $year }}" {{ request('tahun') == $year ? 'selected' : '' }}>
                                                            {{ $year }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <select name="status" class="form-control" onchange="this.form.submit()">
                                                    <option value="">Status</option>
                                                    @foreach ($statusOptions as $status)
                                                        <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                                                            {{ $status }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <input type="text" class="form-control" placeholder="Search Name"
                                                    name="nama" value="{{ request('nama') }}">
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <div class="clearfix  divider mb-3"></div>

                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered table-lg" id="table-1">
                                        <tr>
                                            <th style="width: 3%">No</th>
                                            <th>Nama Pemesan</th>
                                            <th>Ruangan</th>
                                            <th>Tanggal Pemesanan</th>
                                            <th>Status Pesanan</th>
                                            <th>Waktu Pemesanan</th>
                                            <th style="width: 5%" class="text-center">Action</th>
                                        </tr>
                                        @foreach ($pemesanans as $index => $pemesanan)
                                            <tr>
                                                <td>
                                                    {{ $pemesanans->firstItem() + $index }}
                                                </td>
                                                <td>
                                                    {{ $pemesanan->user->name }}
                                                </td>
                                                <td>
                                                    {{ $pemesanan->ruangan->nama }}
                                                </td>
                                                <td>
                                                    {{ $pemesanan->tanggal_pesan }}
                                                </td>
                                                <td>
                                                    {{ $pemesanan->status }}
                                                </td>
                                                <td>
                                                    {{ $pemesanan->waktu_mulai }} - {{ $pemesanan->waktu_selesai }}
                                                </td>
                                                <td>
                                                    <div class="d-flex justify-content-center">
                                                        <a href="{{ route('pemesanan.edit', $pemesanan) }}"
                                                            class="btn btn-sm btn-icon btn-primary m-1"><i
                                                                class="fas fa-edit"></i></a>
                                                        <a href="{{ route('pemesanan.show', $pemesanan) }}"
                                                            class="btn btn-sm btn-icon btn-info m-1"><i
                                                                class="fas fa-eye"></i></a>
                                                        <form action="{{ route('pemesanan.destroy', $pemesanan) }}"
                                                            method="post">
                                                            @csrf
                                                            @method('delete')
                                                            <button
                                                                class="btn btn-sm btn-icon m-1 btn-danger confirm-delete ">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                    <div class="card-footer d-flex justify-content-between">
                                        <span>
                                            Showing {{ $pemesanans->firstItem() }}
                                            to {{ $pemesanans->lastItem() }}
                                            of {{ $pemesanans->total() }} entries
                                        </span>
                                        <div class="paginate-sm">
                                            {{ $pemesanans->onEachSide(0)->links() }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    {{-- <script src="{{ asset() }}"></script> --}}
    {{-- <script src="{{ asset() }}"></script> --}}
    <script src="{{ asset('library/jquery-ui-dist/jquery-ui.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/modules-datatables.js') }}"></script>
    <script src="{{ asset('js/page/components-table.js') }}"></script>
@endpush
