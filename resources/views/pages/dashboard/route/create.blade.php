@extends('layouts.dashboard')

@section('title', 'Tambah Rute')

@section('content')
    <div class="container">
        <!-- content-header -->
        <div class="content-header">
            <div class="header">
                <div class="title">
                    Tambah Rute
                </div>
                <div class="actions">
                    <a href="{{ route('routes.index') }}" class="btn btn-secondary">
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
                    <li class="breadcrumb-item">Rute</li>
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
                        <form action="{{ route('routes.store') }}" method="POST" autocomplete="off">
                            @csrf
                            <div class="form-group row my-2">
                                <label class="col-sm-4 col-form-label text-md-end">Keberangkatan</label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <svg class="bi icon" width="16" height="16" fill="currentColor">
                                                <use xlink:href="{{ asset('img/icon/bootstrap-icons.svg#signpost') }}"/>
                                            </svg>
                                        </span>
                                        <input type="text" name="departure" class="form-control" autocomplete="off" placeholder="Keberangkatan" value="{{ old('departure') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row my-2">
                                <label class="col-sm-4 col-form-label text-md-end">Kedatangan</label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <svg class="bi icon" width="16" height="16" fill="currentColor" style="transform: scaleX(-1);">
                                                <use xlink:href="{{ asset('img/icon/bootstrap-icons.svg#signpost-fill') }}"/>
                                            </svg>
                                        </span>
                                        <input type="text" name="arrival" class="form-control" autocomplete="off" placeholder="Kedatangan" value="{{ old('arrival') }}">
                                    </div>
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
    <link rel="stylesheet" href="{{ asset('vendor/choices.js/styles/choices.min.css') }}">   
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}">   
@endpush

@push('scripts-library')
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/choices.js/scripts/choices.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
@endpush

@push('scripts')
    <script>
        // datepicker
        const initDatepicker = () => {
            $('.datepicker').datepicker({
                orientation: 'bottom'
            });
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
        })
    </script>
@endpush