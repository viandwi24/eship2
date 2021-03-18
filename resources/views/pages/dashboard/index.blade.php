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
                            @foreach ($ships as $ship)
                                <div class="col-lg-4 col-sm-12">
                                    <!-- panel:sumarry -->
                                    <div class="panel panel-success">
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
                                                            <img src="{{ asset('icons/Status.png') }}" width="20px" class="d-inline">
                                                        </span>
                                                        <span class="tw-pt-2 tw-inline-block tw-text-xs">
                                                            @if ($state == null) - @else {{ $state->status }} @endif
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <span class="tw-inline-block" style="margin-top: -10px;">
                                                            <img src="{{ asset('icons/Status.png') }}" width="20px" class="d-inline">
                                                        </span>
                                                        <span class="tw-pt-2 tw-inline-block tw-text-xs">
                                                            @if ($state == null) - @else {{ $state->description }} @endif
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <span class="tw-inline-block" style="margin-top: -10px;">
                                                            <img src="{{ asset('icons/Lokasi.png') }}" width="16px" class="d-inline tw-pl-1">
                                                        </span>
                                                        <span class="tw-pt-2 tw-inline-block tw-pl-1 tw-text-xs">
                                                            @if ($state == null) - @else {{ $state->location }} @endif
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="tw-w-1/3 tw-text-right">
                                                    <div>
                                                        <img src="{{ asset('icons/Kapal.png') }}" width="68px" class="d-inline">
                                                    </div>
                                                    <div class="text-center tw-float-right tw-text-gray-100 tw-mt-2 tw-mr-2">
                                                        <div class="tw-text-xs">Kapasitas</div>
                                                        <div>{{ $ship->max_pax }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @foreach ($reports['route'] as $route_key => $route)
                        <div class="col-lg-6">
                            <!-- panel:title -->
                            <div class="panel panel-primary mb-4">
                                <div class="overlay"></div>
                                <div class="content text-center">
                                    <div class="title">
                                        {{ $route['departure'] }}
                                        {{-- - {{ $route->arrival }} --}}
                                    </div>
                                </div>
                            </div>
                            <!-- panel:sumarry -->
                            <div class="panel panel-primary">
                                <div class="overlay"></div>
                                <div class="text-center tw-flex tw-w-full {{ ($route['id'] % 2 != 0) ? 'tw-flex-row' : 'tw-flex-row-reverse' }}">
                                    <div class="tw-w-5/12 tw-flex tw-my-6 tw-mx-4 tw-flex-col">
                                        <div class="tw-text-sm mb-4 tw-text-gray-100">
                                            Jumlah PNP <br>
                                            {{ \Carbon\Carbon::now()->format('F Y') }}
                                        </div>
                                        <div class="tw-flex tw-w-full">
                                            <div class="tw-flex-1 text-center">
                                                <div class="d-inline">
                                                    <img src="{{ asset('icons/Dewasa.png') }}" width="38px" class="d-inline">
                                                </div>
                                                <div class="tw-text-gray-100">Dewasa</div>
                                                <div class="tw-text-xl tw-text-gray-100">{{ $route['count_adult'] }}</div>
                                            </div>
                                            <div class="tw-flex-1 text-center">
                                                <div class="d-inline">
                                                    <img src="{{ asset('icons/Bayi.png') }}" width="38px" class="d-inline mt-2">
                                                </div>
                                                <div class="tw-text-gray-100">Bayi</div>
                                                <div class="tw-text-xl tw-text-gray-100">{{ $route['count_baby'] }}</div>
                                            </div>
                                            <div class="tw-flex-1 text-center">
                                                <div class="d-inline">
                                                    <img src="{{ asset('icons/Anggota.png') }}" width="38px" class="d-inline">
                                                </div>
                                                <div class="tw-text-gray-100">Anggota</div>
                                                <div class="tw-text-xl tw-text-gray-100">{{ $route['count_security_forces'] }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tw-w-7/12 tw-flex tw-flex-col tw-my-6 tw-mx-4">
                                        <div class="tw-text-sm mb-4 tw-text-gray-100">
                                            TOTAL JUMLAH PENUMPANG <br>
                                            {{ \Carbon\Carbon::now()->format('F Y') }}
                                        </div>
                                        <div class="tw-flex tw-w-full">
                                            <div class="tw-flex-1 text-center">
                                                <div class="d-inline">
                                                    <img src="{{ asset('icons/Penumpang.png') }}" width="38px" class="d-inline mt-3">
                                                </div>
                                                <div class="tw-text-gray-100">Penumpang</div>
                                                <div class="tw-text-xl tw-text-gray-100">{{ $route['count_pax'] }}</div>
                                            </div>
                                            <div class="tw-flex-1 text-center">
                                                <div class="d-inline">
                                                    <img src="{{ asset('icons/Roda 2.png') }}" width="38px" class="d-inline mt-4">   
                                                </div>
                                                <div class="tw-text-gray-100">Roda 2</div>
                                                <div class="tw-text-xl tw-text-gray-100">{{ $route['count_vehicle_wheel_2'] }}</div>
                                            </div>
                                            <div class="tw-flex-1 text-center">
                                                <div class="d-inline">
                                                    <img src="{{ asset('icons/Roda 4.png') }}" width="38px" class="d-inline tw-mt-8">   
                                                </div>
                                                <div class="tw-text-gray-100">Roda 4</div>
                                                <div class="tw-text-xl tw-text-gray-100">{{ $route['count_vehicle_wheel_4'] }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- panel:chart -->
                            <div class="card mt-4">
                                <div class="card-header text-center">
                                    Load Factor Keberangkatan 
                                    | {{ \Carbon\Carbon::now()->format('F Y') }}
                                </div>
                                <div class="card-body">
                                    <canvas id="chartLoadFactor-{{ $route_key }}"></canvas>
                                </div>
                            </div>
                            {{-- <div class="card mt-4">
                                <div class="card-header text-center">
                                    Load Factor Keberangkatan 
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