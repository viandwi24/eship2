@extends('layouts.dashboard')

@section('title', 'Laporan Kapal')

@section('content')
    <div class="container">
        <!-- content-header -->
        <div class="content-header">
            <div class="header">
                <div class="title">
                    Laporan Kapal
                </div>
                <div class="actions">
                    <a class="btn btn-primary" href="{{ route('ship-reports.create') }}">Tambah</a></li>
                </div>
            </div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Laporan Kapal</li>
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
        const route = "{{ route('ship-reports.index') }}";
        const initTable = () => {
            $('#table-transactions').DataTable({
                processing: true,
                serverSide: true,
                ajax: route,
                responsive: true,
                autoWidth: false,
                order: [[3, 'desc']],
                columnDefs: [
                    { orderable: false, targets: [6] }
                ],
                columns: [
                    { title: '#', data: 'id', render: (data, type, row, meta) => meta.row + meta.settings._iDisplayStart + 1 },
                    {
                        title: 'Kapal',
                        data: 'ship.name'
                    },
                    {
                        title: 'Petugas',
                        data: 'user.name'
                    },
                    {
                        title: 'Tanggal',
                        data: 'date'
                    },
                    {
                        title: 'Jam',
                        data: 'time'
                    },
                    {
                        title: 'Rute',
                        data: null,
                        render: (data, type, row) => `${row.route.departure}-${row.route.arrival}`
                    },
                    {
                        title: '...',
                        data: null,
                        render: (data, type, row) => {
                            return `
                            <div>
                                <a class="btn btn-sm btn-outline-warning" href="${route}/${row.id}/edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="${route}/${row.id}" method="POST" class="d-inline">
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