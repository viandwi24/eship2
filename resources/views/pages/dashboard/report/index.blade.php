@extends('layouts.dashboard')

@section('title', 'Laporan')

@section('content')
    <div class="container">
        <!-- content-header -->
        <div class="content-header">
            <div class="header">
                <div class="title">
                    Laporan
                </div>
                <div class="actions">
                </div>
            </div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Laporan</li>
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
    <style>
        td.details-control {
            background: url('https://cdn.rawgit.com/DataTables/DataTables/6c7ada53ebc228ea9bc28b1b216e793b1825d188/examples/resources/details_open.png') no-repeat center center;
            cursor: pointer;
        }
        tr.shown td.details-control {
            background: url('https://cdn.rawgit.com/DataTables/DataTables/6c7ada53ebc228ea9bc28b1b216e793b1825d188/examples/resources/details_close.png') no-repeat center center;
        }
    </style>
@endpush

@push('scripts-library')
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/js/dataTables.responsive.min.js') }}"></script>
@endpush

@push('scripts')
    <script>
        // 
        var table

        // datatables
        const route = "{{ route('reports') }}";
        const initTable = () => {
            table = $('#table-transactions').DataTable({
                processing: true,
                serverSide: true,
                ajax: route,
                responsive: true,
                autoWidth: false,
                order: [[1, 'asc']],
                columnDefs: [
                    { orderable: false, targets: [0] }
                ],
                columns: [
                    { title: '#', data: 'id', render: (data, type, row, meta) => meta.row + meta.settings._iDisplayStart + 1 },
                    {
                        title: 'Tanggal',
                        data: 'date'
                    },
                    {
                        title: 'Kapal',
                        data: 'ship.name'
                    },
                    {
                        title: 'Status',
                        data: 'status'
                    },
                    {
                        title: 'Keterangan',
                        data: 'description'
                    },
                    {
                        title: 'Lokasi',
                        data: 'location'
                    },
                    {
                        title: 'Petugas',
                        data: 'petugas'
                    },
                    {
                        title: 'Total Penumpang',
                        data: 'pax'
                    }
                ]
            });
        }


        // init
        document.addEventListener('DOMContentLoaded', function () {
            initTable()
        })
    </script>
@endpush