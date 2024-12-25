@extends('layouts.app')

@section('title', 'UKM')

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
                                <h4>Data UKM</h4>
                            </div>
                            <div class="card-body">
                                <div class="p-2">
                                    <div class="float-left">
                                        <div class="section-header-button">
                                            <a href="{{ route('ukm.create') }}" class="btn btn-primary">Tambah</a>
                                        </div>
                                    </div>
                                    <div class="float-right">
                                        <form action="{{ route('ukm.index') }}" method="GET">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Search" name="name" value="{{ request('name') }}">
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
                                            <th>Nama UKM</th>
                                            <th>Nama Ketua UKM</th>
                                            <th>Nomer Telepon Ketua UKM</th>
                                            <th style="width: 5%" class="text-center">Action</th>
                                        </tr>
                                        @foreach ($ukms as $index => $ukm)
                                            <tr>
                                                <td>
                                                    {{ $ukms->firstItem() + $index }}
                                                </td>
                                                <td>
                                                    {{ $ukm->nama }}
                                                </td>
                                                <td>
                                                    {{ $ukm->nama_ketua }}
                                                </td>
                                                <td>
                                                    {{ $ukm->nomer_ketua }}
                                                </td>
                                                <td>
                                                    <div class="d-flex justify-content-center">
                                                        <a href="{{ route('ukm.edit', $ukm) }}"
                                                        class="btn btn-sm btn-icon btn-primary m-1"><i
                                                            class="fas fa-edit"></i></a>
                                                        <form action="{{ route('ukm.destroy', $ukm) }}" method="post">
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
                                            Showing {{ $ukms->firstItem() }}
                                            to {{ $ukms->lastItem() }}
                                            of {{ $ukms->total() }} entries
                                        </span>
                                        <div class="paginate-sm">
                                            {{ $ukms->onEachSide(0)->links() }}
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
