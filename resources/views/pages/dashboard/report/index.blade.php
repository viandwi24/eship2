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

    <!-- modal -->
    <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <span class="nama-kapal"></span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form">
                        <div class="form-group row my-1 ">
                            <label class="col-sm-4 text-md-end col-form-label">Nama Kapal</label>
                            <div class="col-md-7">
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <svg class="bi icon" width="16" height="16" fill="currentColor">
                                            <use xlink:href="{{ asset('img/icon/bootstrap-icons.svg#person-fill') }}"/>
                                        </svg>
                                    </span>
                                    <input type="text" name="ship" class="form-control" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row my-1 ">
                            <label class="col-sm-4 text-md-end col-form-label">Tanggal</label>
                            <div class="col-md-7">
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <svg class="bi icon" width="16" height="16" fill="currentColor">
                                            <use xlink:href="{{ asset('img/icon/bootstrap-icons.svg#calendar-fill') }}"/>
                                        </svg>
                                    </span>
                                    <input type="text" name="date" class="form-control" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Ok</button>
                    {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                </div>
            </div>
        </div>
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
                    },
                    {
                        title: '...',
                        data: null,
                        render: (data, type, row) => {
                            return `
                            <div>
                                <button class="btn btn-sm btn-outline-primary" type="button"
                                    onclick="showModal('${data.id}', '${data.ship.name}', '${data.date}')">
                                    <i class="bi bi-search"></i>
                                    <div class="d-inline-block ml-4">Detail</div>
                                </button>
                            </div>
                            `
                        }
                    },
                ]
            });
        }

        // init modal
        var modal, modalEl = document.getElementById('modal')
        const initModal = () => {
            modal = new bootstrap.Modal(modalEl, {})
            showModal(1, 'Kapal', '1-2-2021')
        }
        const showModal = (id, ship, date) => {
            const title = modalEl.querySelector('.nama-kapal')
            const inputShip = modalEl.querySelector('input[name="ship"]')
            const inputDate = modalEl.querySelector('input[name="date"]')
            title.innerHTML = `${ship} [${date}]`
            inputShip.value = `${ship}`
            inputDate.value = `${date}`
            modal.toggle()
        }


        // init
        document.addEventListener('DOMContentLoaded', function () {
            initTable()
            initModal()
        })
    </script>
@endpush