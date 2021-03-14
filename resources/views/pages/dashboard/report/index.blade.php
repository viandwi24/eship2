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
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group row my-2">
                                    <label class="col-sm-4 col-form-label text-md-end">Tanggal :</label>
                                    <div class="col-md-4">
                                        <div class="row">
                                            <div class="col-lg-5 col-sm-12">
                                                <div class="input-group">
                                                    <span class="input-group-text">
                                                        <svg class="bi icon" width="16" height="16" fill="currentColor">
                                                            <use xlink:href="{{ asset('img/icon/bootstrap-icons.svg#calendar') }}"/>
                                                        </svg>
                                                    </span>
                                                    <input class="form-control datepicker" data-date-format="dd-mm-yyyy" id="filter-date-start" placeholder="Tanggal" autocomplete="off" value="{{ \Carbon\Carbon::now()->firstOfMonth()->format('d-m-Y') }}">
                                                </div>
                                            </div>
                                            <div class="col-lg-5 col-sm-12">
                                                <div class="input-group">
                                                    <span class="input-group-text">
                                                        <svg class="bi icon" width="16" height="16" fill="currentColor">
                                                            <use xlink:href="{{ asset('img/icon/bootstrap-icons.svg#calendar-fill') }}"/>
                                                        </svg>
                                                    </span>
                                                    <input class="form-control datepicker" data-date-format="dd-mm-yyyy" id="filter-date-end" placeholder="Tanggal" autocomplete="off" value="{{ \Carbon\Carbon::now()->lastOfMonth()->format('d-m-Y') }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mx-1 mt-4">
                            <table id="table-transactions" class="table table-hover table-stripped"></table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- content:end -->
    </div>

    <!-- modal -->
    <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
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
                        <div class="form-group row my-1 ">
                            <label class="col-sm-4 text-md-end col-form-label">Data Cuaca</label>
                            <div class="col-md-7">
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <svg class="bi icon" width="16" height="16" fill="currentColor">
                                            <use xlink:href="{{ asset('img/icon/bootstrap-icons.svg#cloud-drizzle-fill') }}"/>
                                        </svg>
                                    </span>
                                    <div class="tw-bg-gray-200 tw-flex-1 tw-px-3 tw-py-1 tw-border-2 tw-border-gray-300 weather"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Ok</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles-library')
    <link rel="stylesheet" href="{{ asset('vendor/datatables/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/datatables/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}">   
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
    <script src="{{ asset('vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
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
                searching: false,
                ajax: {
                    url: route,
                    data: function (d) {
                        d.date_start = $('#filter-date-start').val(),
                        d.date_end = $('#filter-date-end').val()
                    }
                },
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
                            data.weather = JSON.parse(data.weather)
                            const weather = (data.weather != null) ? `'${data.weather.id}'` : `null`
                            console.log(data)
                            return `
                            <div>
                                <button class="btn btn-sm btn-outline-primary" type="button"
                                    onclick="showModal(
                                        '${data.id}', '${data.ship.name}', '${data.date}',
                                        ${weather}
                                    )">
                                    <i class="bi bi-search"></i>
                                    <div class="d-inline-block ml-4">Detail</div>
                                </button>
                            </div>
                            `
                        }
                    },
                ]
            });

            $('#filter-date-start').change(() => table.draw());
            $('#filter-date-end').change(() => table.draw());
        }

        // init modal
        var modal, modalEl = document.getElementById('modal')
        const initModal = () => {
            modal = new bootstrap.Modal(modalEl, {})
            // showModal(1, 'Kapal', '1-2-2021')
        }
        const showModal = (id, ship, date, weather = null, photo_embarkation = null) => {
            const title = modalEl.querySelector('.nama-kapal')
            const inputShip = modalEl.querySelector('input[name="ship"]')
            const inputDate = modalEl.querySelector('input[name="date"]')
            const inputWeather = modalEl.querySelector('div.weather')
            const routeWeather = `{{ route('weather.index') }}`
            title.innerHTML = `${ship} [${date}]`
            inputShip.value = `${ship}`
            inputDate.value = `${date}`
            if (weather == null) 
            {
                inputWeather.innerHTML = 'Tidak ada data cuaca di tanggal ini.'
            } else {
                inputWeather.innerHTML = `
                    <a href="${routeWeather}/${weather}?view" target="_blank">Lihat data cuaca</a>
                `
            }
            modal.toggle()
        }

        // datepicker
        const initDatepicker = () => {
            $('.datepicker').datepicker({
                orientation: 'bottom'
            })
        }

        // init
        document.addEventListener('DOMContentLoaded', function () {
            initTable()
            initModal()
            initDatepicker()
        })
    </script>
@endpush