@php
    $menus = [
        [ 'type' => 'item', 'text' => 'Dashboard', 'icon' => 'house', 'route' => route('dashboard'), 'regex' => 'dashboard' ],
        [ 'type' => 'header', 'text' => 'Form Input' ],
        [ 'type' => 'item', 'text' => 'Data Cuaca', 'icon' => 'cloud-drizzle', 'route' => route('weather.index'), 'regex' => '*weather*' ],
        [ 'type' => 'item', 'text' => 'Operasi Kapal', 'icon' => 'cone-striped', 'route' => route('weather.index'), 'regex' => '*ship-operations*' ],
        [ 'type' => 'header', 'text' => 'Form Petugas' ],
        [ 'type' => 'item', 'text' => 'Form Lapor Kapal', 'icon' => 'megaphone', 'route' => route('weather.index'), 'regex' => '*ship-report*' ],
        [ 'type' => 'header', 'text' => 'Laporan' ],
        [ 'type' => 'item', 'text' => 'Laporan', 'icon' => 'newspaper', 'route' => route('weather.index'), 'regex' => '*report*' ],
        [ 'type' => 'header', 'text' => 'Manajemen' ],
        [ 'type' => 'item', 'text' => 'Akun', 'icon' => 'people', 'route' => route('weather.index'), 'regex' => '*account*' ],
    ];
@endphp

<div class="sidebar">
    <div class="sidebar-container">
        <div class="sidebar-header pt-4">
            <a href="#" class="sidebar-brand">
                <img src="{{ asset('img/logo-app.png') }}" width="64px" class="d-inline">
            </a>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                @foreach ($menus as $item)
                    @if ($item['type'] == 'item')
                        <li class="item {{ (request()->is($item['regex']) ? 'active' : '') }}">
                            <a href="{{ $item['route'] }}">
                                <svg class="bi icon" width="24" height="24" fill="currentColor">
                                    <use xlink:href="{{ asset('img/icon/bootstrap-icons.svg#' . $item['icon']) }}"/>
                                </svg>
                                <span>{{ $item['text'] }}</span>
                            </a>
                        </li>
                    @elseif ($item['type'] == 'header')
                        <li class="header">{{ $item['text'] }}</li>
                    @endif
                @endforeach
            </ul>
        </div>
        <div class="sidebar-footer">
            <div class="text-center mb-4">
                <img src="{{ asset('img/logo-dishub.png') }}" width="86px" class="d-inline">
            </div>
        </div>
    </div>
</div>