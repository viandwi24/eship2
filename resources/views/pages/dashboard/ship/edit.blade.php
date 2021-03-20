@extends('layouts.dashboard')

@section('title', 'Edit Kapal')

@section('content')
    <div class="container">
        <!-- content-header -->
        <div class="content-header">
            <div class="header">
                <div class="title">
                    Edit Kapal
                </div>
                <div class="actions">
                    <a href="{{ route('ships.index') }}" class="btn btn-secondary">
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
                    <li class="breadcrumb-item">Kapal</li>
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
                        <form action="{{ route('ships.update', ['ship' => $ship->id]) }}" method="POST" autocomplete="off">
                            @csrf
                            @method('PUT')
                            <div class="form-group row my-2">
                                <label class="col-sm-4 col-form-label text-md-end">Nama Kapal</label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <svg class="bi icon" width="16" height="16" fill="currentColor">
                                                <use xlink:href="{{ asset('img/icon/bootstrap-icons.svg#credit-card-2-front-fill') }}"/>
                                            </svg>
                                        </span>
                                        <input type="text" name="name" class="form-control" autocomplete="off" placeholder="Nama Kapal" value="{{ $ship->name }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row my-2">
                                <label class="col-sm-4 col-form-label text-md-end">Tipe Kapal</label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <svg class="bi icon" width="16" height="16" fill="currentColor">
                                                <use xlink:href="{{ asset('img/icon/bootstrap-icons.svg#credit-card-2-front-fill') }}"/>
                                            </svg>
                                        </span>
                                        <select name="type" class="form-select" autocomplete="off">
                                            <option value="">--Pilih Tipe--</option>
                                            <option value="Non Cepat (Ro-Ro)" {{ ($ship->type == 'Non Cepat (Ro-Ro)') ? 'selected' : '' }}>Non Cepat (Ro-Ro)</option>
                                            <option value="Cepat (HSC)" {{ ($ship->type == 'Cepat (HSC)') ? 'selected' : '' }}>Cepat (HSC)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row my-2">
                                <label class="col-sm-4 col-form-label text-md-end">Maksimum Penumpang</label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <svg class="bi icon" width="16" height="16" fill="currentColor">
                                                <use xlink:href="{{ asset('img/icon/bootstrap-icons.svg#sort-numeric-down') }}"/>
                                            </svg>
                                        </span>
                                        <input type="number" name="max_pax" class="form-control" autocomplete="off" placeholder="Maksimum Penumpang" value="{{ $ship->max_pax }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row my-2">
                                <label class="col-sm-4 col-form-label text-md-end">Maksimum Roda 2</label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <svg class="bi icon" width="16" height="16" fill="currentColor">
                                                <use xlink:href="{{ asset('img/icon/bootstrap-icons.svg#sort-numeric-down') }}"/>
                                            </svg>
                                        </span>
                                        <input type="number" name="max_vehicle_wheel_2" class="form-control" autocomplete="off" placeholder="Maksimum Roda 2" value="{{ $ship->max_vehicle_wheel_2 }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row my-2">
                                <label class="col-sm-4 col-form-label text-md-end">Maksimum Roda 4</label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <svg class="bi icon" width="16" height="16" fill="currentColor">
                                                <use xlink:href="{{ asset('img/icon/bootstrap-icons.svg#sort-numeric-down') }}"/>
                                            </svg>
                                        </span>
                                        <input type="number" name="max_vehicle_wheel_4" class="form-control" autocomplete="off" placeholder="Maksimum Roda 4" value="{{ $ship->max_vehicle_wheel_4 }}">
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group row my-2">
                                <label class="col-sm-4 col-form-label text-md-end">Jadwal</label>
                                <div class="col-md-4">
                                    @php $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']; @endphp
                                    @foreach ($days as $day)
                                        @php
                                            $search = $day;
                                            $found = false;
                                            $time = '00:00';
                                            foreach ($ship->schedules as $key => $schedule) {
                                                if ($schedule->day === $search)
                                                {
                                                    $found = true;
                                                    $time = \Carbon\Carbon::parse($schedule->time)->format('G:i');
                                                    break;
                                                }
                                            }
                                        @endphp
                                        <div class="input-group input-group-sm mb-2 input-check-schedule-group" style="width: 290px;">
                                            <div class="input-group-text">
                                                <input name="days[]" class="form-check-input" type="checkbox" value="{{ $day }}" id="input-schedule-{{ strtolower($day) }}" {{ $found ? 'checked' : '' }}>
                                            </div>
                                            <span class="input-group-text" style="width: 120px;">
                                                <label class="form-check-label" for="input-schedule-{{ strtolower($day) }}">{{ $day }}</label>
                                            </span>
                                            <span class="input-group-text">
                                                <svg class="bi icon" width="16" height="16" fill="currentColor">
                                                    <use xlink:href="{{ asset('img/icon/bootstrap-icons.svg#clock-fill') }}"/>
                                                </svg>
                                            </span>
                                            <input class="form-control timepicker" name="time" placeholder="Jam" autocomplete="off" value="{!! $time !!}">
                                            {{-- @php
                                                dd($filtered[0]['time']);
                                            @endphp --}}
                                        </div>
                                    @endforeach
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
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">   
@endpush

@push('scripts-library')
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/choices.js/scripts/choices.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>
@endpush

@push('scripts')
    <script>
        // datepicker
        const initDatepicker = () => {
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

        const initSchedule = () => {
            document.querySelectorAll('.input-check-schedule-group input[type="checkbox"]').forEach((e) => {
                e.addEventListener('change', function () {
                    const el = e.parentElement.parentElement.querySelector('.timepicker')
                    if (e.checked) {
                        el.disabled = false
                        el.setAttribute('name', 'time[]')
                    } else {
                        el.disabled = true
                        el.removeAttribute('name')
                    }
                })
            })

            document.querySelectorAll('.input-check-schedule-group input[type="checkbox"]').forEach((e) => {
                const el = e.parentElement.parentElement.querySelector('.timepicker')
                if (e.checked) {
                    el.disabled = false
                    el.setAttribute('name', 'time[]')
                } else {
                    el.disabled = true
                    el.removeAttribute('name')
                }
            })
        }

        // init
        document.addEventListener('DOMContentLoaded', function () {
            initDatepicker()
            initChoices()
            initSchedule()
        })
    </script>
@endpush