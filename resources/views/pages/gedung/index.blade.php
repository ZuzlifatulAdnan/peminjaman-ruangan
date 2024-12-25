@extends('layouts.app')

@section('title', 'Gedung')

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
                                <h4>Data Gedung</h4>
                            </div>
                            <div class="card-body">
                                <div class="p-2">
                                    <div class="float-left">
                                        <div class="section-header-button">
                                            <a href="{{ route('gedung.create') }}" class="btn btn-primary">Tambah</a>
                                        </div>
                                    </div>
                                    <div class="float-right">
                                        <form action="{{ route('gedung.index') }}" method="GET">
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
                                            <th>Nama Gedung</th>
                                            <th style="width: 5%" class="text-center">Action</th>
                                        </tr>
                                        @foreach ($gedungs as $index => $gedung)
                                            <tr>
                                                <td>
                                                    {{ $gedungs->firstItem() + $index }}
                                                </td>
                                                <td>
                                                    {{ $gedung->nama }}
                                                </td>
                                                <td>
                                                    <div class="d-flex justify-content-center">
                                                        <a href="{{ route('gedung.edit', $gedung) }}"
                                                        class="btn btn-sm btn-icon btn-primary m-1"><i
                                                            class="fas fa-edit"></i></a>
                                                        <form action="{{ route('gedung.destroy', $gedung) }}" method="post">
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
                                            Showing {{ $gedungs->firstItem() }}
                                            to {{ $gedungs->lastItem() }}
                                            of {{ $gedungs->total() }} entries
                                        </span>
                                        <div class="paginate-sm">
                                            {{ $gedungs->onEachSide(0)->links() }}
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
