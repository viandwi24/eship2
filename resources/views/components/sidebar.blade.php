@php
    $menus = [
        [ 'role' => [], 'type' => 'item', 'text' => 'Dashboard', 'icon' => 'house', 'route' => route('dashboard'), 'regex' => 'dashboard' ],
        [ 'role' => ['Admin'], 'type' => 'header', 'text' => 'Form Input' ],
        [ 'role' => ['Admin'], 'type' => 'item', 'text' => 'Data Cuaca', 'icon' => 'cloud-drizzle', 'route' => route('weather.index'), 'regex' => '*weather*' ],
        [ 'role' => ['Admin'], 'type' => 'item', 'text' => 'Operasi Kapal', 'icon' => 'cone-striped', 'route' => route('weather.index'), 'regex' => '*ship-operations*' ],
        [ 'role' => ['Petugas'], 'type' => 'header', 'text' => 'Form Petugas' ],
        [ 'role' => ['Petugas'], 'type' => 'item', 'text' => 'Form Lapor Kapal', 'icon' => 'megaphone', 'route' => route('weather.index'), 'regex' => '*ship-report*' ],
        [ 'role' => ['Admin'], 'type' => 'header', 'text' => 'Laporan' ],
        [ 'role' => ['Admin'], 'type' => 'item', 'text' => 'Laporan', 'icon' => 'newspaper', 'route' => route('weather.index'), 'regex' => '*report*' ],
        [ 'role' => ['Admin'], 'type' => 'header', 'text' => 'Manajemen' ],
        [ 'role' => ['Admin'], 'type' => 'item', 'text' => 'Akun', 'icon' => 'people', 'route' => route('users.index'), 'regex' => '*users*' ],
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
                    @php  if (count($item['role']) > 0) if (!in_array(Auth::user()->role, $item['role'])) continue;  @endphp
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