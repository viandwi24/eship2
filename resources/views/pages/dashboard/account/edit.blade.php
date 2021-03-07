@extends('layouts.dashboard')

@section('title', 'Edit Akun')

@section('content')
    <div class="container">
        <!-- content-header -->
        <div class="content-header">
            <div class="header">
                <div class="title">
                    Edit Akun
                </div>
                <div class="actions">
                    <a href="{{ route('users.index') }}" class="btn btn-secondary">
                        Batal
                    </a>
                    <a href="" class="btn btn-primary">
                        Simpan
                    </a>
                </div>
            </div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb"> 
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item">Akun</li>
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
                        <form action="{{ route('users.update', ['user' => $user->id]) }}" method="POST" autocomplete="off">
                            @method('PUT')
                            @csrf
                            <div class="form-group row my-2">
                                <label class="col-sm-4 col-form-label text-md-end">Nama</label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <svg class="bi icon" width="16" height="16" fill="currentColor">
                                                <use xlink:href="{{ asset('img/icon/bootstrap-icons.svg#credit-card-2-front-fill') }}"/>
                                            </svg>
                                        </span>
                                        <input type="text" name="name" class="form-control" autocomplete="off" value="{{ $user->name }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row my-2">
                                <label class="col-sm-4 col-form-label text-md-end">Role</label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <svg class="bi icon" width="16" height="16" fill="currentColor">
                                                <use xlink:href="{{ asset('img/icon/bootstrap-icons.svg#award-fill') }}"/>
                                            </svg>
                                        </span>
                                        <select name="role" class="choices form-select">
                                            <option value="Admin" {{ ($user->role == 'Admin' ? 'selected' : '') }}>Admin</option>
                                            <option value="Petugas" {{ ($user->role == 'Petugas' ? 'selected' : '') }}>Petugas</option>
                                            <option value="Supervisor" {{ ($user->role == 'Supervisor' ? 'selected' : '') }}>Supervisor</option>
                                            <option value="Super Duper Admin" {{ ($user->role == 'Super Duper Admin' ? 'selected' : '') }}>Super Duper Admin</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row my-2">
                                <label class="col-sm-4 col-form-label text-md-end">Username</label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <svg class="bi icon" width="16" height="16" fill="currentColor">
                                                <use xlink:href="{{ asset('img/icon/bootstrap-icons.svg#person-fill') }}"/>
                                            </svg>
                                        </span>
                                        <input type="text" name="username" class="form-control" autocomplete="off" value="{{ $user->username }}">
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group row my-2">
                                <label class="col-sm-4 col-form-label text-md-end"></label>
                                <div class="col-md-4">
                                    <div class="alert alert-warning" role="alert">
                                        Biarkan kosong jika tidak ingin mengganti password.
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row my-2">
                                <label class="col-sm-4 col-form-label text-md-end">Password</label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <svg class="bi icon" width="16" height="16" fill="currentColor">
                                                <use xlink:href="{{ asset('img/icon/bootstrap-icons.svg#lock-fill') }}"/>
                                            </svg>
                                        </span>
                                        <input type="password" name="password" class="form-control" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row my-2">
                                <label class="col-sm-4 col-form-label text-md-end">Re-Password</label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <svg class="bi icon" width="16" height="16" fill="currentColor">
                                                <use xlink:href="{{ asset('img/icon/bootstrap-icons.svg#lock-fill') }}"/>
                                            </svg>
                                        </span>
                                        <input type="password" name="password_confirmation" class="form-control" autocomplete="off">
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
@endpush

@push('scripts-library')
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/choices.js/scripts/choices.min.js') }}"></script>
@endpush

@push('scripts')
    <script>
        // datepicker
        const initChoices = () => {
            const els = document.querySelectorAll('.choices.choice-default')
            els.forEach(function (el) {
                new Choices(el)
            })
        }

        // init
        document.addEventListener('DOMContentLoaded', function () {
            initChoices()
        })
    </script>
@endpush