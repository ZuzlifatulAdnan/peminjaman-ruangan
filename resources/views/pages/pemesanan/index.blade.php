@extends('layouts.app')

@section('title', 'Peminjaman')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/d') }}">
@endpush

@section('main')
    <div class="main-content">
        <div class="section-body">
            <div class="row">
                <div class="col-12">

                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Data Peminjaman</h4>
                        </div>
                        <div class="card-body">
                            <div class="p-2">
                                <div class="float-left mt-4">
                                    <div class="section-header-button">
                                        <a href="{{ route('pemesanan.create') }}" class="btn btn-primary mr-2">Tambah</a>
                                        <button class="btn btn-success" data-toggle="modal" data-target="#exportModal"><i
                                                class="fas fa-download"></i> Export</button>
                                    </div>
                                </div>
                                <div class="float-right mt-4">
                                    <form action="{{ route('pemesanan.index') }}" method="GET">
                                        <div class="row">
                                            <!-- Bulan Filter -->
                                            <div class="col-12 col-md-3 mb-3 mb-md-0">
                                                <div class="form-group">
                                                    <select name="bulan" class="form-control"
                                                        onchange="this.form.submit()">
                                                        <option value="">Bulan</option>
                                                        @foreach ($months as $key => $month)
                                                            <option value="{{ $key }}"
                                                                {{ request('bulan') == $key ? 'selected' : '' }}>
                                                                {{ $month }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Tahun Filter -->
                                            <div class="col-12 col-md-3 mb-3 mb-md-0">
                                                <div class="form-group">
                                                    <select name="tahun" class="form-control"
                                                        onchange="this.form.submit()">
                                                        <option value="">Tahun</option>
                                                        @foreach ($years as $year)
                                                            <option value="{{ $year }}"
                                                                {{ request('tahun') == $year ? 'selected' : '' }}>
                                                                {{ $year }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Status Filter -->
                                            <div class="col-12 col-md-3 mb-3 mb-md-0">
                                                <div class="form-group">
                                                    <select name="status" class="form-control"
                                                        onchange="this.form.submit()">
                                                        <option value="">Status</option>
                                                        @foreach ($statusOptions as $status)
                                                            <option value="{{ $status }}"
                                                                {{ request('status') == $status ? 'selected' : '' }}>
                                                                {{ $status }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Search Filter -->
                                            <div class="col-12 col-md-3 mb-3 mb-md-0">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" placeholder="Search Name"
                                                            name="nama" value="{{ request('nama') }}">
                                                        <div class="input-group-append">
                                                            <button class="btn btn-primary"><i
                                                                    class="fas fa-search"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="modal fade" id="exportModal" tabindex="-1" role="dialog"
                                aria-labelledby="exportModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exportModalLabel">Export Data Peminjaman</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('pemesanan.export') }}" method="GET">
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="bulan">Pilih Bulan</label>
                                                    <select name="bulan" id="bulan" class="form-control selectric">
                                                        <option value="">Pilih Bulan</option>
                                                        @foreach ($months as $key => $month)
                                                            <option value="{{ $key }}">{{ $month }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="tahun">Pilih Tahun</label>
                                                    <select name="tahun" id="tahun" class="form-control selectric">
                                                        <option value="">Pilih Tahun</option>
                                                        @foreach ($years as $year)
                                                            <option value="{{ $year }}">{{ $year }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger"
                                                    data-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-primary">Export</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix  divider mb-3"></div>
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered table-lg" id="table-1">
                                    <tr>
                                        <th style="width: 3%">No</th>
                                        <th>Nama Pemesan</th>
                                        <th class="text-center">Gedung || Ruangan</th>
                                        <th class="text-center">Tanggal Pemesanan</th>
                                        <th class="text-center">Status Pesanan</th>
                                        <th class="text-center">Waktu Pemesanan</th>
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
                                            <td class="text-center">
                                                {{ $pemesanan->ruangan->gedung->nama }} ||
                                                {{ $pemesanan->ruangan->nama }}
                                            </td>
                                            <td class="text-center">
                                                {{ \Carbon\Carbon::parse($pemesanan->tanggal_pesan)->format('d/m/Y') }}
                                            </td>
                                            <td class="text-center">
                                                @if ($pemesanan->status == 'Selesai')
                                                    <span class="badge badge-success">{{ $pemesanan->status }}</span>
                                                @elseif ($pemesanan->status == 'Diterima')
                                                    <span class="badge badge-primary">{{ $pemesanan->status }}</span>
                                                @elseif ($pemesanan->status == 'Diproses')
                                                    <span class="badge badge-warning">{{ $pemesanan->status }}</span>
                                                @elseif ($pemesanan->status == 'Ditolak')
                                                    <span class="badge badge-danger">{{ $pemesanan->status }}</span>
                                                @else
                                                    <span class="badge badge-secondary">{{ $pemesanan->status }}</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
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
                                                        <button class="btn btn-sm btn-icon m-1 btn-danger confirm-delete ">
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
