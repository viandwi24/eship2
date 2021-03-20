@extends('layouts.dashboard')

@section('title', 'Edit Laporan Kapal')

@section('content')
    <div class="container">
        <!-- content-header -->
        <div class="content-header">
            <div class="header">
                <div class="title">
                    Edit Laporan Kapal
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
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
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
                        <form action="{{ route('ship-reports.update', ['ship_report' => $shipReport->id]) }}" method="POST" autocomplete="off" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
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
                                                    <option value="{{ $item->id }}" {{ $item->id == $shipReport->user_id ? 'selected' : '' }}>{{ $item->name }}</option>                                                
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
                                                <option value="{{ $ship->id }}" {{ $ship->id == $shipReport->ship_id ? 'selected' : '' }}>{{ $ship->name }}</option>                                                
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
                                            <option value="">--Pilih Pemberangkatan--</option>
                                            @foreach ($routes as $item)
                                                <option value="{{ $item->id }}" {{ $item->id == $shipReport->route_id ? 'selected' : '' }}>
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
                                        <input class="form-control datepicker" data-date-format="dd-mm-yyyy" name="date" placeholder="Tanggal" autocomplete="off" value="{{ old('date', $shipReport->date->format('d-m-Y')) }}">
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
                                        <input class="form-control timepicker" name="time" placeholder="Jam" autocomplete="off" value="{{ old('time', $shipReport->time) }}">
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
                                        <input type="number" min="0" name="count_adult" class="form-control" autocomplete="off" value="{{ old('count_adult', $shipReport->count_adult) }}">
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
                                        <input type="number" min="0" name="count_baby" class="form-control" autocomplete="off" value="{{ old('count_baby', $shipReport->count_baby) }}">
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
                                        <input type="number" min="0" name="count_security_forces" class="form-control" autocomplete="off" value="{{ old('count_security_forces', $shipReport->count_security_forces) }}">
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
                                        <input type="number" min="0" name="count_vehicle_wheel_2" class="form-control" autocomplete="off" value="{{ old('count_vehicle_wheel_2', $shipReport->count_vehicle_wheel_2) }}">
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
                                        <input type="number" min="0" name="count_vehicle_wheel_4" class="form-control" autocomplete="off" value="{{ old('count_vehicle_wheel_4', $shipReport->count_vehicle_wheel_4) }}">
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group row my-2">
                                <label class="col-sm-4 col-form-label text-md-end">Foto Embarkasi</label>
                                <div class="col-md-4">
                                    @if ($shipReport->photo_embarkation == null)
                                        <div class="tw-block tw-border-gray-300 tw-border-2 tw-text-center tw-relative" style="height: 100px;"><span style="position: absolute;top: 50%;transform: translate(-50%,-50%);">Belum ada foto.</span></div>
                                    @else
                                        <img src="{{ route('ship-reports.show', ['ship_report' => $shipReport->id]) }}?view_photo_embarkation" alt="Foto" class="tw-border-gray-300 tw-border-2" id="preview_photo_embarkation">
                                    @endif
                                    <input type="file" name="photo_embarkation" class="form-control mt-2">
                                </div>
                            </div>
                            <hr>
                            <div class="form-group row my-2">
                                <label class="col-sm-4 col-form-label text-md-end">Foto Pemberangkatan</label>
                                <div class="col-md-4">
                                    @if ($shipReport->photo_embarkation == null)
                                        <div class="tw-block tw-border-gray-300 tw-border-2 tw-text-center tw-relative" style="height: 100px;"><span style="position: absolute;top: 50%;transform: translate(-50%,-50%);">Belum ada foto.</span></div>
                                    @else
                                        <img src="{{ route('ship-reports.show', ['ship_report' => $shipReport->id]) }}?view_photo_departure" alt="Foto" class="tw-border-gray-300 tw-border-2" id="preview_photo_departure">
                                    @endif
                                    <input type="file" name="photo_departure" class="form-control mt-2">
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
        var shipSelected = JSON.parse(JSON.stringify({!! json_encode($shipReport->ship, JSON_HEX_TAG) !!}));
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

            const shipSelectOnChange = () => {
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
            }
            shipSelect.addEventListener('change', shipSelectOnChange)

            //
            const check = () => {
                if (shipSelected != null) {
                    // pax
                    totalPax = countAdult + countBaby + countSecurityForces
                    console.log({ countAdult, countBaby, countSecurityForces })
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
                }
            }

            // 
            const inputCountAdultOnChange = () => { 
                countAdult = parseInt(inputCountAdult.value)
                check()
            }
            inputCountAdult.addEventListener('change', inputCountAdultOnChange)
            const inputCountBabyOnChange = () => { 
                countBaby = parseInt(inputCountBaby.value)
                check()
            }
            inputCountBaby.addEventListener('change', inputCountBabyOnChange)
            const inputCountSecurityForcesOnChange = () => { 
                countSecurityForces = parseInt(inputCountSecurityForces.value)
                check()
            }
            inputCountSecurityForces.addEventListener('change', inputCountSecurityForcesOnChange)
            const inputCountVehicleWheel2OnChange = () => { 
                countVehicleWheel2 = parseInt(inputCountVehicleWheel2.value)
                check()
            }
            inputCountVehicleWheel2.addEventListener('change', inputCountVehicleWheel2OnChange)
            const inputCountVehicleWheel4OnChange = () => { 
                countVehicleWheel4 = parseInt(inputCountVehicleWheel4.value)
                check()
            }
            inputCountVehicleWheel4.addEventListener('change', inputCountVehicleWheel4OnChange)

            // 
            shipSelectOnChange()
            inputCountAdultOnChange()
            inputCountBabyOnChange()
            inputCountSecurityForcesOnChange()
            inputCountVehicleWheel2OnChange()
            inputCountVehicleWheel4OnChange()
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

        // 
        function readURL(input, previewQuery) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $(previewQuery).attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        const initInputFile = () => {
            $("input[name='photo_embarkation']").change(function() {
                readURL(this, '#preview_photo_embarkation');
            });
            $("input[name='photo_departure']").change(function() {
                readURL(this, '#preview_photo_departure');
            });
        }

        // init
        document.addEventListener('DOMContentLoaded', function () {
            initDatepicker()
            initChoices()
            initInputFile()
            initShipMax()
        })
    </script>
@endpush