@php
    function random_color_part() {
        return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
    }

    function random_color() {
        return random_color_part() . random_color_part() . random_color_part();
    }
    $colors = [];
    foreach ($ships as $ship) $colors[] = '#' . random_color();
    $colorsRoutes = [];
    foreach ($routes as $route) $colorsRoutes[] = '#' . random_color();
@endphp
@if (!isset($xls) && @$xls != true)
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
@endif
<table class="table table-sm table-bordered table-striped">
    <thead>
        <tr>
            <th rowspan="4">NO</th>
            <th rowspan="4">HARI</th>
            <th rowspan="4">TANGGAL</th>
            @php $i = 0 @endphp
            @foreach ($routes as $item)
                <th colspan="{{ count($ships)*6 }}" style="background: {{ $colorsRoutes[$i] }}">PEMBERANGKATAN DARI PELABUHAN {{ strtoupper($item->arrival) }}</th>                 
                @php $i++ @endphp
            @endforeach
        </tr>
        <tr>
            @foreach ($routes as $item)
                @php $i = 0 @endphp
                @foreach ($ships as $ship)
                    <th colspan="6" style="background: {{ $colors[$i] }}">{{ strtoupper($ship->name) }}</th>    
                    @php $i++ @endphp
                @endforeach             
            @endforeach
        </tr>
        <tr>
            @foreach ($routes as $item)
                @foreach ($ships as $ship)
                    <th rowspan="2">JAM</th>  
                    <th colspan="5">JMLH PNP</th>  
                @endforeach             
            @endforeach
        </tr>
        <tr>
            @foreach ($routes as $item)
                @foreach ($ships as $ship)
                <th>DWS</th>
                <th>BAYI</th>
                <th>ANGG</th>
                <th>R2</th>
                <th>R4</th>
                @endforeach             
            @endforeach
        </tr>
    </thead>
    <tbody>
        @php
            $i = 1;
            $total = [];
        @endphp
        @foreach ($reports as $report)
            <tr>
                <td>{{ $i }}</td>
                <td>{{ \Carbon\Carbon::parse($report['date'])->format('l') }}</td>
                <td>{{ $report['date'] }}</td>
                @foreach ($report['routes'] as $route)
                    @foreach ($route['ships'] as $ship)
                        @php if (!isset($total[$route['id']][$ship['id']])) $total[$route['id']][$ship['id']] = [ 'dws' => 0, 'bayi' => 0, 'angg' => 0, 'r2' => 0, 'r4' => 0 ]; @endphp
                        @if ($ship['operation'] != null && $ship['operation']->status == 'Tidak Beroperasi')
                            <th style="background: red;"></th>
                            <th style="background: red;"></th>
                            <th style="background: red;"></th>
                            <th style="background: red;"></th>
                            <th style="background: red;"></th>
                            <th style="background: red;"></th>
                        @elseif ($ship['operation'] != null && $ship['operation']->status == 'Beroperasi')
                            @if ($ship['report'] != null)
                                @php
                                    $total[$route['id']][$ship['id']]['dws'] += $ship['report']->count_adult;
                                    $total[$route['id']][$ship['id']]['bayi'] += $ship['report']->count_baby;
                                    $total[$route['id']][$ship['id']]['angg'] += $ship['report']->count_security_forces;
                                    $total[$route['id']][$ship['id']]['r2'] += $ship['report']->count_vehicle_wheel_2;
                                    $total[$route['id']][$ship['id']]['r4'] += $ship['report']->count_vehicle_wheel_4;
                                @endphp
                                <th>{{ (\Carbon\Carbon::parse($ship['report']->time)->format('H:i')) }}</th>
                                <th>{{ ($ship['report']->count_adult) }}</th>
                                <th>{{ ($ship['report']->count_baby) }}</th>
                                <th>{{ ($ship['report']->count_security_forces) }}</th>
                                <th>{{ ($ship['report']->count_vehicle_wheel_2) }}</th>
                                <th>{{ ($ship['report']->count_vehicle_wheel_4) }}</th>
                            @else
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            @endif
                        @else
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        @endif
                    @endforeach
                @endforeach
            </tr>
            @php $i++ @endphp
        @endforeach

        {{--  --}}
        {{-- @php dd($total); @endphp --}}
        <tr style="background: pink;">
            <td colspan="3">Jumlah Perkapal</td>
            @foreach ($routes as $route)
                @php $i = 0 @endphp
                @foreach ($ships as $ship)
                    <td style="background: {{ $colors[$i] }};">-</td>
                    <td style="background: {{ $colors[$i] }};">{{ $total[$route['id']][$ship['id']]['dws'] }}</td>
                    <td style="background: {{ $colors[$i] }};">{{ $total[$route['id']][$ship['id']]['bayi'] }}</td>
                    <td style="background: {{ $colors[$i] }};">{{ $total[$route['id']][$ship['id']]['angg'] }}</td>
                    <td style="background: {{ $colors[$i] }};">{{ $total[$route['id']][$ship['id']]['r2'] }}</td>
                    <td style="background: {{ $colors[$i] }};">{{ $total[$route['id']][$ship['id']]['r4'] }}</td>
                    @php $i++ @endphp
                @endforeach             
            @endforeach
        </tr>
        <tr style="background: pink;">
            <td colspan="3">Total</td>
            @php $i = 0 @endphp
            @foreach ($routes as $route)
                @php
                    $totalPNPPerRoute = 0;
                    $totalR2PerRoute = 0;
                    $totalR4PerRoute = 0;
                    foreach ($ships as $ship) {
                        $totalPNPPerRoute += $total[$route['id']][$ship['id']]['dws']
                            + $total[$route['id']][$ship['id']]['bayi']
                            + $total[$route['id']][$ship['id']]['angg'];
                        $totalR2PerRoute += $total[$route['id']][$ship['id']]['r2'];
                        $totalR4PerRoute += $total[$route['id']][$ship['id']]['r4'];
                    }
                @endphp
                <td colspan="{{ (count($ships)*6)-2 }}" style="background: {{ $colorsRoutes[$i] }};text-align: center;">
                    {{ $totalPNPPerRoute }}
                </td>
                <td style="background: {{ $colorsRoutes[$i] }}">{{ $totalR2PerRoute }}</td>
                <td style="background: {{ $colorsRoutes[$i] }}">{{ $totalR4PerRoute }}</td>
                @php $i++ @endphp
            @endforeach
        </tr>
    </tbody>
</table>