@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <div class="login-container">
        <div class="bg">
            <img src="{{ asset('img/IMG_7456.jpg') }}" alt="">
        </div>
        <div class="main">
            <div class="background-overlay">
                <img src="{{ asset('img/icons/Logo Gresik.png') }}" width="86px" class="m-4 d-inline">
                <img src="{{ asset('img/icons/Tulisan Kab Gresik.png') }}" width="220px" class="m-4 d-inline pt-2">
                <img src="{{ asset('img/icons/Bupati dan Wakil.png') }}" width="120px" class="m-4 d-inline pt-2">
            </div>
            <div class="login-panel">
                <div class="panel-container">
                    <div class="header text-center">
                        <img src="{{ asset('img/icons/Logo Dishub.png') }}" width="84px" class="d-inline">
                    </div>
                    <div class="form">
                        <div class="title">LOGIN</div>
                        <div class="header mb-3">
                            <div>SISTEM INFORMASI ANGKUTAN</div>
                            <div>PENYEBERANGAN GRESIK - BAWEAN</div>
                        </div>
                        <x-message />
                        <form action="{{ route('login.post') }}" method="POST">
                            @csrf
                            <div class="input-group">
                                <svg class="bi icon" width="22" height="22" fill="currentColor">
                                    <use xlink:href="{{ asset('img/icon/bootstrap-icons.svg#person') }}"/>
                                </svg>
                                <input type="text" placeholder="Username" name="username">
                            </div>
                            <div class="input-group">
                                <svg class="bi icon" width="22" height="22" fill="currentColor">
                                    <use xlink:href="{{ asset('img/icon/bootstrap-icons.svg#lock') }}"/>
                                </svg>
                                <input type="password" placeholder="Password" name="password">
                            </div>
                            <div class="text-center">
                                <button class="btn btn-primary mt-4">
                                    LOGIN
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="footer text-center">
                        <img src="{{ asset('img/icons/Logo App.png') }}" width="64px" class="d-inline">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .login-container .bg {
            /* background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            background: url({{ asset('img/wallpapers/2.jpeg') }}); */

            position: fixed; 
            top: -50%; 
            left: -50%; 
            width: 200%; 
            height: 200%;
        }

        .login-container .bg img {
            position: absolute; 
            top: 0; 
            left: 0; 
            right: 0; 
            bottom: 0; 
            margin: auto; 
            min-width: 50%;
            min-height: 50%;
        }
    </style>
@endpush