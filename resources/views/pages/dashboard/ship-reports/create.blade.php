@extends('layouts.dashboard')

@section('title', 'Tambah Laporan Kapal')

@section('content')
    <div class="container">
        <!-- content-header -->
        <div class="content-header">
            <div class="header">
                <div class="title">
                    Tambah Laporan Kapal
                </div>
                <div class="actions">
                    <a href="{{ route('ship-reports.index') }}" class="btn btn-secondary">
                        Batal
                    </a>
                    <button onclick="document.querySelector('form').submit()" class="btn btn-primary">
                        Simpan
                    </button>
                </div>
            </div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb"> 
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item">Pelaporan Kapal</li>
                    <li class="breadcrumb-item active" aria-current="page">Tambah</li>
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
                        <form action="{{ route('ship-reports.store') }}" method="POST" autocomplete="off" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group row my-2">
                                <label class="col-sm-4 col-form-label text-md-end">Nama Petugas</label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <svg class="bi icon" width="16" height="16" fill="currentColor">
                                                <use xlink:href="{{ asset('img/icon/bootstrap-icons.svg#person-fill') }}"/>
                                            </svg>
                                        </span>
                                        @if (Auth::user()->role == 'Petugas')
                                            <input type="text" class="form-control" value="{{ Auth::user()->name }}" disabled>
                                            <input type="hidden" name="user_id" class="form-control" autocomplete="off" value="{{ Auth::user()->id }}">
                                        @else
                                            <select name="user_id" class="choices form-select">
                                                <option value="">--Pilih Petugas--</option>
                                                @foreach ($petugas_users as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>                                                
                                                @endforeach
                                            </select>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row my-2">
                                <label class="col-sm-4 col-form-label text-md-end">Nama Kapal</label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <svg class="bi icon" width="16" height="16" fill="currentColor">
                                                <use xlink:href="{{ asset('img/icon/bootstrap-icons.svg#credit-card-2-front-fill') }}"/>
                                            </svg>
                                        </span>
                                        <select name="ship_id" class="choices form-select">
                                            <option value="">--Pilih Kapal--</option>
                                            @foreach ($ships as $ship)
                                                <option value="{{ $ship->id }}">{{ $ship->name }}</option>                                                
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row my-2">
                                <label class="col-sm-4 col-form-label text-md-end">Pemberangkatan</label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <svg class="bi icon" width="16" height="16" fill="currentColor">
                                                <use xlink:href="{{ asset('img/icon/bootstrap-icons.svg#signpost-2-fill') }}"/>
                                            </svg>
                                        </span>
                                        <select name="route_id" class="choices form-select">
                                            <option value="">--Pilih Pelabuhan--</option>
                                            @foreach ($routes as $item)
                                                <option value="{{ $item->id }}">
                                                    {{ $item->departure }}
                                                    {{-- -{{ $item->arrival }} --}}
                                                </option>                                                
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row my-2">
                                <label class="col-sm-4 col-form-label text-md-end">Tanggal</label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <svg class="bi icon" width="16" height="16" fill="currentColor">
                                                <use xlink:href="{{ asset('img/icon/bootstrap-icons.svg#calendar-fill') }}"/>
                                            </svg>
                                        </span>
                                        <input class="form-control datepicker" data-date-format="dd-mm-yyyy" name="date" placeholder="Tanggal" autocomplete="off" value="{{ old('date', \Carbon\Carbon::now()->format('d-m-Y')) }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row my-2">
                                <label class="col-sm-4 col-form-label text-md-end">Jam</label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <svg class="bi icon" width="16" height="16" fill="currentColor">
                                                <use xlink:href="{{ asset('img/icon/bootstrap-icons.svg#calendar-fill') }}"/>
                                            </svg>
                                        </span>
                                        <input class="form-control timepicker" name="time" placeholder="Jam" autocomplete="off" value="{{ old('date', \Carbon\Carbon::now()->format('H:i')) }}">
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group row my-2">
                                <div class="offset-md-4 col-md-4">
                                    <div class="alert alert-danger" role="alert" id="alertPaxMax" style="display: none;">
                                        Total Maksimum Penumpang adalah : <span></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row my-2">
                                <label class="col-sm-4 col-form-label text-md-end">Jumlah Orang Dewasa</label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <svg class="bi icon" width="16" height="16" fill="currentColor">
                                                <use xlink:href="{{ asset('img/icon/bootstrap-icons.svg#sort-numeric-down') }}"/>
                                            </svg>
                                        </span>
                                        <input type="number" min="0" name="count_adult" class="form-control" autocomplete="off" value="{{ old('count_adult') }}" placeholder="Isi jumlah orang dewasa...">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row my-2">
                                <label class="col-sm-4 col-form-label text-md-end">Jumlah Bayi</label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <svg class="bi icon" width="16" height="16" fill="currentColor">
                                                <use xlink:href="{{ asset('img/icon/bootstrap-icons.svg#sort-numeric-down') }}"/>
                                            </svg>
                                        </span>
                                        <input type="number" min="0" name="count_baby" class="form-control" autocomplete="off" value="{{ old('count_baby') }}" placeholder="Isi jumlah bayi...">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row my-2">
                                <label class="col-sm-4 col-form-label text-md-end">Jumlah Anggota (TNI/Polisi)</label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <svg class="bi icon" width="16" height="16" fill="currentColor">
                                                <use xlink:href="{{ asset('img/icon/bootstrap-icons.svg#sort-numeric-down') }}"/>
                                            </svg>
                                        </span>
                                        <input type="number" min="0" name="count_security_forces" class="form-control" autocomplete="off" value="{{ old('count_security_forces') }}" placeholder="Isi jumlah anggota...">
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group row my-2">
                                <div class="offset-md-4 col-md-4">
                                    <div class="alert alert-warning" role="alert" id="alertShipFast" style="display: none;">
                                        Tipe kapal cepat tidak mengangkut kendaraan.
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row my-2">
                                <div class="offset-md-4 col-md-4">
                                    <div class="alert alert-danger" role="alert" id="alertVehicle2Max" style="display: none;">
                                        Total Maksimum Kendaraan 2 adalah : <span></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row my-2">
                                <label class="col-sm-4 col-form-label text-md-end">Jumlah Kendaraan Roda 2</label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <svg class="bi icon" width="16" height="16" fill="currentColor">
                                                <use xlink:href="{{ asset('img/icon/bootstrap-icons.svg#sort-numeric-down') }}"/>
                                            </svg>
                                        </span>
                                        <input type="number" min="0" name="count_vehicle_wheel_2" class="form-control" autocomplete="off" value="{{ old('count_vehicle_wheel_2') }}" placeholder="Isi jumlah kendaraan roda 2...">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row my-2">
                                <div class="offset-md-4 col-md-4">
                                    <div class="alert alert-danger" role="alert" id="alertVehicle4Max" style="display: none;">
                                        Total Maksimum Kendaraan 4 adalah : <span></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row my-2">
                                <label class="col-sm-4 col-form-label text-md-end">Jumlah Kendaraan Roda 4</label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <svg class="bi icon" width="16" height="16" fill="currentColor">
                                                <use xlink:href="{{ asset('img/icon/bootstrap-icons.svg#sort-numeric-down') }}"/>
                                            </svg>
                                        </span>
                                        <input type="number" min="0" name="count_vehicle_wheel_4" class="form-control" autocomplete="off" value="{{ old('count_vehicle_wheel_4') }}" placeholder="Isi jumlah kendaraan roda 4...">
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group row my-2">
                                <label class="col-sm-4 col-form-label text-md-end">Foto Embarkasi</label>
                                <div class="col-md-4">
                                    <input type="file" name="photo_embarkation" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row my-2">
                                <label class="col-sm-4 col-form-label text-md-end">Foto Pemberangkatan</label>
                                <div class="col-md-4">
                                    <input type="file" name="photo_departure" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row my-2">
                                <div class="offset-md-4 col-md-4">
                                    <button class="btn btn-primary">
                                        Simpan
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- content:end -->
    </div>
@endsection

@push('styles-library')
    <link rel="stylesheet" href="{{ asset('vendor/glyphicons-only-bootstrap/css/bootstrap.min.css') }}">   
    <link rel="stylesheet" href="{{ asset('vendor/choices.js/styles/choices.min.css') }}">   
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}">   
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">   
@endpush

@push('scripts-library')
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/choices.js/scripts/choices.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>
@endpush

@push('scripts')
    <script>
        // initShipMax
        var shipSelected = null;
        var totalPax = 0, 
            countAdult = 0,
            countBaby = 0,
            countSecurityForces = 0,
            countVehicleWheel2 = 0,
            countVehicleWheel4 = 0

        const initShipMax = () => {
            const ships = JSON.parse(JSON.stringify({!! json_encode($ships, JSON_HEX_TAG) !!}))
            const shipSelect = document.querySelector('select[name="ship_id"]')
            const inputCountAdult = document.querySelector('input[name="count_adult"]')
            const inputCountBaby = document.querySelector('input[name="count_baby"]')
            const inputCountSecurityForces = document.querySelector('input[name="count_security_forces"]')
            const inputCountVehicleWheel2 = document.querySelector('input[name="count_vehicle_wheel_2"]')
            const inputCountVehicleWheel4 = document.querySelector('input[name="count_vehicle_wheel_4"]')

            shipSelect.addEventListener('change', () => {
                var found = null
                ships.forEach(e => {
                    if (e.id == shipSelect.value) {
                        found = e
                    }
                })
                if (found == null) return shipSelected = null
                shipSelected = found
                countAdult = 0
                countBaby = 0
                countSecurityForces = 0
                check()
            })

            //
            const check = () => {
                if (shipSelected != null) {

                    const inputCountVehicleWheel2 = document.querySelector('input[name="count_vehicle_wheel_2"]')
                    const inputCountVehicleWheel4 = document.querySelector('input[name="count_vehicle_wheel_4"]')

                    // pax
                    totalPax = countAdult + countBaby + countSecurityForces
                    const alertPaxMax = document.querySelector('#alertPaxMax')                    
                    if (totalPax > shipSelected.max_pax) {
                        alertPaxMax.style.display = 'block'
                        alertPaxMax.querySelector('span').innerHTML = shipSelected.max_pax
                    } else {
                        alertPaxMax.style.display = 'none'
                    }

                    // 
                    const alertVehicle4Max = document.querySelector('#alertVehicle4Max')
                    if (countVehicleWheel4 > shipSelected.max_vehicle_wheel_4) {
                        alertVehicle4Max.style.display = 'block'
                        alertVehicle4Max.querySelector('span').innerHTML = shipSelected.max_vehicle_wheel_4
                    } else {
                        alertVehicle4Max.style.display = 'none'
                    }

                    // 
                    const alertVehicle2Max = document.querySelector('#alertVehicle2Max')
                    if (countVehicleWheel2 > shipSelected.max_vehicle_wheel_2) {
                        alertVehicle2Max.style.display = 'block'
                        alertVehicle2Max.querySelector('span').innerHTML = shipSelected.max_vehicle_wheel_2
                    } else {
                        alertVehicle2Max.style.display = 'none'
                    }

                    // 
                    const alertShipFast = document.querySelector('#alertShipFast')
                    if (shipSelected.type == "Cepat (HSC)") {
                        alertShipFast.style.display = 'block'
                        inputCountVehicleWheel2.disabled = true
                        inputCountVehicleWheel4.disabled = true
                    } else {
                        alertShipFast.style.display = 'none'
                        inputCountVehicleWheel2.disabled = false
                        inputCountVehicleWheel4.disabled = false
                    }

                    if( shipSelected.id != 3 ) {
                        alertShipFast.style.display = 'block'
                        inputCountVehicleWheel2.disabled = true
                        inputCountVehicleWheel4.disabled = true
                        inputCountVehicleWheel2.value = 0
                        inputCountVehicleWheel4.value = 0
                    }
                }
            }

            // 
            inputCountAdult.addEventListener('change', () => { 
                countAdult = parseInt(inputCountAdult.value)
                check()
            })
            inputCountBaby.addEventListener('change', () => { 
                countBaby = parseInt(inputCountBaby.value)
                check()
            })
            inputCountSecurityForces.addEventListener('change', () => { 
                countSecurityForces = parseInt(inputCountSecurityForces.value)
                check()
            })
            inputCountVehicleWheel2.addEventListener('change', () => { 
                countVehicleWheel2 = parseInt(inputCountVehicleWheel2.value)
                check()
            })
            inputCountVehicleWheel4.addEventListener('change', () => { 
                countVehicleWheel4 = parseInt(inputCountVehicleWheel4.value)
                check()
            })
        }

        // datepicker
        const initDatepicker = () => {
            $('.datepicker').datepicker({
                orientation: 'bottom'
            })
            $('.timepicker').timepicker({
                showMeridian: false,
                minuteStep: 1
            })
        }

        const initChoices = () => {
            const els = document.querySelectorAll('.choices.choice-default')
            els.forEach(function (el) {
                new Choices(el)
            })
        }

        // init
        document.addEventListener('DOMContentLoaded', function () {
            initDatepicker()
            initChoices()
            initShipMax()
        })
    </script>
@endpush