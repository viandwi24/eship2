@extends('layouts.dashboard')

@section('title', 'Cuaca')

@section('content')
    <div class="container">
        <!-- content-header -->
        <div class="content-header">
            <div class="header">
                <div class="title">
                    Tambah Data Cuaca
                </div>
                <div class="actions">
                    <a href="{{ route('weather.index') }}" class="btn btn-secondary">
                        Batal
                    </a>
                    <a href="" class="btn btn-primary">
                        Simpan
                    </a>
                </div>
            </div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb"> 
                    <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                    <li class="breadcrumb-item">Data Cuaca</li>
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
                        <form action="{{ route('weather.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group row my-2">
                                <label class="col-sm-4 col-form-label text-md-end">Tanggal Mulai</label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <svg class="bi icon" width="16" height="16" fill="currentColor">
                                                <use xlink:href="{{ asset('img/icon/bootstrap-icons.svg#calendar-fill') }}"/>
                                            </svg>
                                        </span>
                                        <input class="form-control datepicker" data-date-format="dd-mm-yyyy" name="date_start" placeholder="Dari..." autocomplete="off" value="{{ old('date_start') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row my-2">
                                <label class="col-sm-4 col-form-label text-md-end">Tanggal Selesai</label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <svg class="bi icon" width="16" height="16" fill="currentColor">
                                                <use xlink:href="{{ asset('img/icon/bootstrap-icons.svg#calendar-fill') }}"/>
                                            </svg>
                                        </span>
                                        <input class="form-control datepicker" data-date-format="dd-mm-yyyy" name="date_end" placeholder="Sampai..." autocomplete="off" value="{{ old('date_end') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row my-2">
                                <label class="col-sm-4 col-form-label text-md-end">Data BMKG</label>
                                <div class="col-md-4">
                                    <input type="file" class="form-control" name="file">
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
    {{-- <link rel="stylesheet" href="{{ asset('vendor/pikaday/css/pikaday.css') }}">    --}}
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}">   
@endpush

@push('scripts-library')
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    {{-- <script src="{{ asset('vendor/pikaday/pikaday.js') }}"></script>
    <script src="{{ asset('vendor/moment/moment.js') }}"></script> --}}
@endpush

@push('scripts')
    <script>
        // datepicker
        const initDatepicker = () => {
            // const els = document.querySelectorAll('.datepicker')
            // els.forEach((el) => new Pikaday({
            //     field: el,
            //     format: 'd-m-Y',
            //     toString(date, format) {
            //         const day = ('0' + date.getDate()).slice(-2);
            //         const month = ('0' + (date.getMonth() + 1)).slice(-2);
            //         const year = date.getFullYear();
            //         return `${day}-${month}-${year}`;
            //     },
            // }))
            $('.datepicker').datepicker({
                orientation: 'bottom'
            });
        }

        // init
        document.addEventListener('DOMContentLoaded', function () {
            initDatepicker()
        })
    </script>
@endpush