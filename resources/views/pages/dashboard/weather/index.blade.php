@extends('layouts.dashboard')

@section('title', 'Cuaca')

@section('content')
    <div class="container">
        <!-- content-header -->
        <div class="content-header">
            <div class="header">
                <div class="title">
                    Data Cuaca
                </div>
                <div class="actions">
                    <div class="btn-group">
                        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Tambah
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <li><a class="dropdown-item" href="{{ route('weather.create') }}">Tambah Data BMKG</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Data Cuaca</li>
                </ol>
            </nav>
        </div>
        <!-- content-header:end -->
        <!-- content -->
        <div class="content">
            <div class="row">
                <div class="col-12">
                    <div class="mt-2">
                        <!-- flush message error -->
                        <x-message />
                        <!-- flush message error:end -->
                        <table id="table-transactions" class="table table-hover table-stripped"></table>
                    </div>
                </div>
            </div>
        </div>
        <!-- content:end -->
    </div>
@endsection

@push('styles-library')
    <link rel="stylesheet" href="{{ asset('vendor/datatables/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/datatables/css/responsive.bootstrap4.min.css') }}">
@endpush

@push('scripts-library')
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/js/dataTables.responsive.min.js') }}"></script>
@endpush

@push('scripts')
    <script>
        // datatables
        const route = "{{ route('weather.index') }}";
        const initTable = () => {
            $('#table-transactions').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('weather.index') }}',
                responsive: true,
                autoWidth: false,
                columns: [
                    { title: '#', data: 'id', render: (data, type, row, meta) => meta.row + meta.settings._iDisplayStart + 1 },
                    {
                        title: 'Tanggal Mulai',
                        data: 'date_start'
                    },
                    {
                        title: 'Tanggal Selesai',
                        data: 'date_end'
                    },
                    {
                        title: 'Data BMKG',
                        data: null,
                        render: (data, type, row) => {
                            return `
                            <div>
                                <a class="btn btn-sm btn-outline-primary" href="${route}/${row.id}?view" target="_blank">
                                    <i class="bi bi-eye"></i> Lihat
                                </a>
                            </div>
                            `
                        }
                    },
                    {
                        title: '...',
                        data: null,
                        render: (data, type, row) => {
                            return `
                            <div>
                                <form action="${route}/${row.id}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                            `
                        }
                    },
                ]
            });
        }


        // init
        document.addEventListener('DOMContentLoaded', function () {
            initTable()
        })
    </script>
@endpush