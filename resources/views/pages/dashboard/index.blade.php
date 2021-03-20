@extends('layouts.dashboard')

@section('title', 'Home')

@section('content')
    <div class="container">
        <!-- content-header -->
        <div class="content-header">
            <div class="header">
                <div class="title">
                    Dashboard
                </div>
                <div class="actions">
                </div>
            </div>
        </div>
        <!-- content-header:end -->
        <div class="content">
            <section id="panel">
                <div class="row my-4">
                    <div class="col-12 mb-2">
                        <div class="row">
                            @php $color = 0; @endphp
                            @foreach ($ships as $ship)
                                @php $color++; if ($color == 4) $color = 1; @endphp
                                <div class="col-lg-4 col-sm-12">
                                    <!-- panel:sumarry -->
                                    <div class="panel panel-ship-{{ $color }}">
                                        <div class="tw-w-full mx-4 my-4">
                                            <div class="tw-w-full">
                                                <span class="tw-text-lg tw-font-semibold tw-text-gray-100">{{ $ship->name }}</span>
                                            </div>
                                            <div class="tw-flex tw-w-full">
                                                <div class="tw-w-2/3 tw-text-gray-100">
                                                    @php
                                                        $state = \App\Models\ShipOperation::where('ship_id', $ship->id)->whereDate('date', \Carbon\Carbon::now())->first();
                                                    @endphp
                                                    <div>
                                                        <span class="tw-inline-block" style="margin-top: -10px;">
                                                            <img src="{{ asset('img/icons/Status.png') }}" width="20px" class="d-inline">
                                                        </span>
                                                        <span class="tw-pt-2 tw-inline-block tw-text-xs">
                                                            @if ($state == null) - @else {{ $state->status }} @endif
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <span class="tw-inline-block" style="margin-top: -10px;">
                                                            <img src="{{ asset('img/icons/Keterangan.png') }}" width="18px" class="d-inline">
                                                        </span>
                                                        <span class="tw-pt-2 tw-inline-block tw-text-xs">
                                                            @if ($state == null) - @else {{ $state->description }} @endif
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <span class="tw-inline-block" style="margin-top: -10px;">
                                                            <img src="{{ asset('img/icons/Lokasi.png') }}" width="16px" class="d-inline tw-pl-1">
                                                        </span>
                                                        <span class="tw-pt-2 tw-inline-block tw-pl-1 tw-text-xs">
                                                            GRESIK
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="tw-w-1/3 tw-text-right">
                                                    <div>
                                                        <img src="{{ asset('img/icons/Kapal.png') }}" width="68px" class="d-inline">
                                                    </div>
                                                    <div class="text-center tw-float-right tw-text-gray-100 tw-mt-2 tw-mr-2">
                                                        <div class="tw-text-xs">Kapasitas</div>
                                                        <div class="tw-text-2xl tw-font-semibold">{{ $ship->max_pax }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @php $color = 0; @endphp
                    @foreach ($reports['route'] as $route_key => $route)
                        @php $color++; if ($color == 3) $color = 1; @endphp
                        <div class="col-lg-12 col-xl-6">
                            <!-- panel:title -->
                            <div class="panel mb-4" style="background: #203450;">
                                <div class="overlay"></div>
                                <div class="content text-center">
                                    <div class="title tw-text-xl tw-font-semibold">
                                        dari {{ $route['departure'] }}
                                        {{-- - {{ $route->arrival }} --}}
                                    </div>
                                </div>
                            </div>
                            <!-- panel:sumarry -->
                            <div class="panel panel-sumarry">
                                <div class="overlay"></div>
                                <div class="text-center tw-flex tw-flex-col lg:tw-flex-row tw-w-full {{ ($route['id'] % 2 != 0) ? 'tw-flex-row' : 'tw-flex-row-reverse' }} color-{{ $color }}">
                                    <div class="tw-w-full lg:tw-w-5/12 tw-flex tw-flex-col">
                                        <div class="tw-text-sm mt-4 tw-text-gray-100">
                                            Jumlah PNP <br>
                                            {{ \Carbon\Carbon::now()->format('F Y') }}
                                        </div>
                                        <div class="tw-flex tw-w-full tw-pt-10 tw-pb-6 tw-px-4">
                                            <div class="tw-flex-1 text-center">
                                                <div class="d-inline">
                                                    <img src="{{ asset('img/icons/Dewasa.png') }}" width="22px" class="d-inline" style="margin-top: 0px;">
                                                </div>
                                                <div class="tw-text-gray-100">Dewasa</div>
                                                <div class="tw-text-xl tw-font-semibold tw-text-gray-100">{{ $route['count_adult'] }}</div>
                                            </div>
                                            <div class="tw-flex-1 text-center">
                                                <div class="d-inline">
                                                    <img src="{{ asset('img/icons/Bayi.png') }}" width="22px" class="d-inline" style="margin-top: 5px;">
                                                </div>
                                                <div class="tw-text-gray-100">Bayi</div>
                                                <div class="tw-text-xl tw-font-semibold tw-text-gray-100">{{ $route['count_baby'] }}</div>
                                            </div>
                                            <div class="tw-flex-1 text-center">
                                                <div class="d-inline">
                                                    <img src="{{ asset('img/icons/Anggota.png') }}" width="22px" class="d-inline">
                                                </div>
                                                <div class="tw-text-gray-100">Anggota</div>
                                                <div class="tw-text-xl tw-font-semibold tw-text-gray-100">{{ $route['count_security_forces'] }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tw-w-full lg:tw-w-7/12 tw-flex tw-flex-col">
                                        <div class="tw-text-sm mt-4 tw-text-gray-100">
                                            TOTAL JUMLAH PENUMPANG <br>
                                            {{ \Carbon\Carbon::now()->format('F Y') }}
                                        </div>
                                        <div class="tw-flex tw-w-full tw-py-5 tw-px-4">
                                            <div class="tw-flex-1 text-center">
                                                <div class="d-inline">
                                                    <img src="{{ asset('img/icons/Penumpang.png') }}" width="38px" class="d-inline mt-3">
                                                </div>
                                                <div class="tw-text-gray-100">Penumpang</div>
                                                <div class="tw-text-xl tw-font-semibold tw-text-gray-100">{{ $route['count_pax'] }}</div>
                                            </div>
                                            <div class="tw-flex-1 text-center">
                                                <div class="d-inline">
                                                    <img src="{{ asset('img/icons/Roda 2.png') }}" width="38px" class="d-inline mt-4">   
                                                </div>
                                                <div class="tw-text-gray-100">Roda 2</div>
                                                <div class="tw-text-xl tw-font-semibold tw-text-gray-100">{{ $route['count_vehicle_wheel_2'] }}</div>
                                            </div>
                                            <div class="tw-flex-1 text-center">
                                                <div class="d-inline">
                                                    <img src="{{ asset('img/icons/Roda 4.png') }}" width="38px" class="d-inline tw-mt-8">   
                                                </div>
                                                <div class="tw-text-gray-100">Roda 4</div>
                                                <div class="tw-text-xl tw-font-semibold tw-text-gray-100">{{ $route['count_vehicle_wheel_4'] }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- panel:chart -->
                            <div class="panel mt-4 p-4" style="display: block;">
                                <div class="text-center tw-text-xl tw-font-semibold mb-2">
                                    Load Factor Penumpang 
                                    | {{ \Carbon\Carbon::now()->format('F Y') }}
                                </div>
                                <canvas id="chartLoadFactor-{{ $route_key }}"></canvas>
                            </div>
                            {{-- <div class="card mt-4">
                                <div class="card-header text-center">
                                    Load Factor Penumpang 
                                    | {{ \Carbon\Carbon::now()->format('F Y') }}
                                </div>
                                <div class="card-body">
                                    <canvas id="chartLoadFactor-{{ $route_key }}"></canvas>
                                </div>
                            </div> --}}
                        </div>
                    @endforeach
                </div>
            </section>
        </div>
    </div>
@endsection

@push('styles-library')
    <link rel="stylesheet" href="{{ asset('vendor/chart.js/Chart.min.css') }}">
@endpush

@push('scripts-library')
    <script src="{{ asset('vendor/chart.js/Chart.bundle.min.js') }}"></script>
@endpush

@push('styles')
    <style>
        .panel-ship-1 { background: linear-gradient(to bottom left, #70C76E, #14B4CC); }
        .panel-ship-2 { background: linear-gradient(to bottom left, #F8CA7D, #F29B7E); }
        .panel-ship-3 { background: linear-gradient(to bottom left, #51ACDE, #4590CC); }

        .panel-sumarry .color-1 > div:nth-child(1) { background: linear-gradient(to bottom right, #92CE4C, #40BD9F); }
        .panel-sumarry .color-1 > div:nth-child(2) { background: linear-gradient(to bottom left, #8DCD50, #17B5C8); }
        .panel-sumarry .color-2 > div:nth-child(1) { background: linear-gradient(to bottom right, #4590CC, #54B4E4); }
        .panel-sumarry .color-2 > div:nth-child(2) { background: linear-gradient(to bottom right, #4590CC, #54B4E4); }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // 
            var data = {!! json_encode($reports, JSON_HEX_TAG) !!}
            
            // chart - cash flow
            data.route.forEach((route, route_key) => {
                const datasets = [];
                route.load_factor_pax.ship.forEach((ship, ship_key) => {
                    const data = []
                    ship.percents.forEach((percent) => {
                        data.push(percent.percent)
                    })
                    var dynamicColors = function() {
                        var r = Math.floor(Math.random() * 255)
                        var g = Math.floor(Math.random() * 255)
                        var b = Math.floor(Math.random() * 255)
                        return { r, g, b }
                    };
                    datasets.push({
                        label: ship.name,
                        data: data,
                        backgroundColor: `rgba(${dynamicColors().r}, ${dynamicColors().g}, ${dynamicColors().b}, .2)`,
                        borderColor: `rgba(${dynamicColors().r}, ${dynamicColors().g}, ${dynamicColors().b}, .5)`,
                        borderWidth: 1
                    })
                })

                // 
                var ctxLoadFactor = document.getElementById(`chartLoadFactor-${route_key}`)
                var chartCashFlow = new Chart(ctxLoadFactor, {
                    type: 'line',
                    data: {
                    labels: [
                        {!! $reports['load_factor_label'] !!}
                    ],
                    datasets: datasets
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true,
                                    callback: function(value) {
                                        return value + "%"
                                    }
                                }
                            }]
                        },
                        tooltips: {
                            titleColor: 'red',
                            callbacks: {
                                label: function(tooltipItem, chart) { 
                                    var indice = tooltipItem.index
                                    var datasetIndex = tooltipItem.datasetIndex
                                    var ship = chart.datasets[datasetIndex]
                                    var value = ship.data[indice]
                                    tooltipItem.label = `${tooltipItem.label} {{ \Carbon\Carbon::now()->format('F Y') }}`
                                    // return  data.labels[indice] +': '+data.datasets[0].data[indice] + '';
                                    return `${ship.label} : ${value}%`
                                }
                            }
                        },
                    }
                })
            });
        })
    </script>    
@endpush