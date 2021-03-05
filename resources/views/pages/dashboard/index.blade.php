<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard</title>
    <!-- dashboard styles -->
    <link rel="stylesheet" href="{{ asset('css/tailwind.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <!-- library styles -->
    <link rel="stylesheet" href="{{ asset('vendor/chart.js/Chart.min.css') }}">
    <!-- theme styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <!-- dashboard -->
    <div class="dashboard">
        <!-- sidebar -->
        <div class="sidebar">
            <div class="sidebar-container">
                <div class="sidebar-header pt-4">
                    <a href="#" class="sidebar-brand">
                        <img src="{{ asset('img/logo-app.png') }}" width="64px" class="d-inline">
                    </a>
                </div>
                <div class="sidebar-menu">
                    <ul class="menu">
                        <li class="item active">
                            <a href=".html">
                                <svg class="bi icon" width="24" height="24" fill="currentColor">
                                    <use xlink:href="{{ asset('img/icon/bootstrap-icons.svg#house') }}"/>
                                </svg>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="header">Form Input</li>
                        <li class="item">
                            <a href=".html">
                                <svg class="bi icon" width="24" height="24" fill="currentColor">
                                    <use xlink:href="{{ asset('img/icon/bootstrap-icons.svg#cloud-drizzle') }}"/>
                                </svg>
                                <span>Data Cuaca</span>
                            </a>
                        </li>
                        <li class="item">
                            <a href=".html">
                                <svg class="bi icon" width="24" height="24" fill="currentColor">
                                    <use xlink:href="{{ asset('img/icon/bootstrap-icons.svg#cone-striped') }}"/>
                                </svg>
                                <span>Operasi Kapal</span>
                            </a>
                        </li>
                        <li class="header">Form Petugas</li>
                        <li class="item">
                            <a href=".html">
                                <svg class="bi icon" width="24" height="24" fill="currentColor">
                                    <use xlink:href="{{ asset('img/icon/bootstrap-icons.svg#megaphone') }}"/>
                                </svg>
                                <span>Form Lapor Kapal</span>
                            </a>
                        </li>
                        <li class="header">Laporan</li>
                        <li class="item">
                            <a href=".html">
                                <svg class="bi icon" width="24" height="24" fill="currentColor">
                                    <use xlink:href="{{ asset('img/icon/bootstrap-icons.svg#newspaper') }}"/>
                                </svg>
                                <span>Laporan</span>
                            </a>
                        </li>
                        <li class="header">Manajemen</li>
                        <li class="item">
                            <a href=".html">
                                <svg class="bi icon" width="24" height="24" fill="currentColor">
                                    <use xlink:href="{{ asset('img/icon/bootstrap-icons.svg#people') }}"/>
                                </svg>
                                <span>Akun</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="sidebar-footer">
                    <div class="text-center mb-4">
                        <img src="{{ asset('img/logo-dishub.png') }}" width="86px" class="d-inline">
                    </div>
                </div>
            </div>
        </div>
        <!-- navbar -->
        <div class="navbar">
            <div class="navbar-container">
                <div class="navbar-header">
                    <div class="navbar-brand">
                        <a href="#" class="title">Sistem Informasi Angkutan</a>
                        <a href="#" class="subtitle">Penyebrangan Gresik - Bawean</a>
                    </div>
                </div>
                <ul class="menu">
                    <li>
                        <a href="#">
                            <svg class="bi icon" width="24" height="24" fill="currentColor">
                                <use xlink:href="{{ asset('img/icon/bootstrap-icons.svg#person') }}"/>
                            </svg>
                            <span>Mr. john</span>
                        </a>
                    </li>
                    <li class="tw-bg-red-500"><a href="#" style="color: rgba(229, 231, 235, 1);">Logout</a></li>
                </ul>
            </div>
        </div>
        <!-- content -->
        <div class="body">
            <div class="container">
                <div class="content-header">
                </div>
                <div class="content">
                    <!-- welcome-card -->
                    <section id="welcome-card">
                        <div class="tw-mt-4 lg:tw-mt-12 tw-bg-blue-100 tw-block tw-rounded-xl lg:tw-py-8 lg:tw-px-10 tw-py-6 tw-px-8">
                            <div class="tw-block lg:tw-flex">
                                <div class="tw-text lg:tw-w-6/12 tw-w-full">
                                    <span class="tw-font-bold tw-text-2xl tw-text-blue-600">Welcome back Alfian!</span>
                                    <p class="tw-pt-4 tw-text-lg tw-text-gray-800">
                                        You've learned 80% of your goal this week!<br>
                                        Keep it up and improve your results!
                                    </p>
                                </div>
                                <div class="illustration tw-w-6/12 tw-hidden lg:tw-block">
                                    <img src="{{ asset('img/illustrations/1.svg') }}" class="tw-w-full negative-illustration">
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- welcome-card:end -->
                    <section id="panel">
                        <div class="row my-4">
                            @for ($i = 0; $i < 4; $i++)
                                <div class="col-lg-3">
                                    <div class="panel panel-primary">
                                        <div class="overlay"></div>
                                        <div class="icon">
                                            <svg class="bi icon" width="24" height="24" fill="currentColor">
                                                <use xlink:href="{{ asset('img/icon/bootstrap-icons.svg#person') }}"/>
                                            </svg>
                                        </div>
                                        <div class="content">
                                            <div class="main">1.0000</div>
                                            <div class="title">Customer</div>
                                            <a href="sales-customer.html" class="link">
                                                <i data-feather="arrow-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </section>
                    <!-- chart -->
                    <section id="chart">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card card-custom">
                                    <div class="card-header">
                                        <h3 class="card-title">
                                            <span class="fw-bolder tw-text-gray-700 fs-5">
                                                Cash Flow
                                            </span>
                                        </h3>
                                    </div>
                                    <div class="card-body">
                                        <canvas id="chartCashFlow" width="400" height="300"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>

    <!-- scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('vendor/chart.js/Chart.bundle.min.js') }}"></script>
    <script>
        function rupiahFormat(value, index, values) {
            if(parseInt(value) >= 1000){
                return 'Rp' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
            } else if (parseInt(value) < 0) {
                return '-Rp' + (value*(-1))
            } else {
                return 'Rp' + value
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            // chart - cash flow
            var ctxCashFlow = document.getElementById('chartCashFlow')
            var chartCashFlow = new Chart(ctxCashFlow, {
                type: 'line',
                data: {
                labels: [
                    'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                    'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
                ],
                datasets: [{
                    label: 'Inflow',
                    data: [
                    10000, 20000, 50000, 40000, 20000, 30000,
                    30000, 50000, 20000, 30000, 20000, 10000,
                    ],
                    backgroundColor: 'rgba(54, 162, 235, .2)',
                    borderColor: 'rgba(54, 162, 235, .5)',
                    borderWidth: 1
                }, {
                    label: 'Outflow',
                    data: [
                    -10000, -20000, -50000, -40000, 10000, 20000,
                    50000, -50000, -20000, 20000, -20000, 30000,
                    ],
                    backgroundColor: 'rgba(255, 159, 64, .2)',
                    borderColor: 'rgba(255, 159, 64, .5)',
                    borderWidth: 1
                }, {
                    label: 'Net Change',
                    data: [
                    100000,
                    50000,
                    100000,
                    50000,
                    10000,
                    25000,
                    0, 0, 0, 0, 0, 0
                    ],
                    backgroundColor: 'rgba(255, 99, 132, .2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
                },
                options: {
                scales: {
                    yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        callback: rupiahFormat
                    }
                    }]
                }
                }
            })
        })
    </script>
</body>
</html>