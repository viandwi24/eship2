@php
    // $menus = [
    //     [ 'role' => [], 'type' => 'item', 'text' => 'Dashboard', 'icon' => 'house', 'route' => route('dashboard'), 'regex' => 'dashboard' ],
    //     [ 'role' => [], 'type' => 'item', 'text' => 'Profil', 'icon' => 'person', 'route' => route('profile'), 'regex' => 'dashboard/profil' ],
    //     [ 'role' => ['Admin'], 'type' => 'header', 'text' => 'Administrasi' ],
    //     // [ 'role' => ['Admin'], 'type' => 'item', 'text' => 'Data Cuaca', 'icon' => 'cloud-drizzle', 'route' => route('weather.index'), 'regex' => '*weather*' ],
    //     [ 'role' => ['Admin'], 'type' => 'item', 'text' => 'Kapal', 'icon' => 'minecart', 'route' => route('ships.index'), 'regex' => '*ships*' ],
    //     // [ 'role' => ['Admin'], 'type' => 'item', 'text' => 'Rute', 'icon' => 'signpost-split', 'route' => route('routes.index'), 'regex' => '*routes*' ],
    //     [ 'role' => ['Admin'], 'type' => 'item', 'text' => 'Operasi Kapal', 'icon' => 'cone-striped', 'route' => route('ship-operations.index'), 'regex' => '*ship-operations*' ],
    //     [ 'role' => ['Admin', 'Petugas'], 'type' => 'header', 'text' => 'Form Petugas' ],
    //     [ 'role' => ['Admin', 'Petugas'], 'type' => 'item', 'text' => 'Lapor Kapal', 'icon' => 'megaphone', 'route' => route('ship-reports.index'), 'regex' => '*ship-reports*' ],
    //     [ 'role' => ['Admin'], 'type' => 'header', 'text' => 'Laporan' ],
    //     [ 'role' => ['Admin'], 'type' => 'item', 'text' => 'Laporan', 'icon' => 'newspaper', 'route' => route('reports'), 'regex' => '*/report*' ],
    //     [ 'role' => ['Admin'], 'type' => 'header', 'text' => 'Manajemen' ],
    //     [ 'role' => ['Admin'], 'type' => 'item', 'text' => 'Akun', 'icon' => 'people', 'route' => route('users.index'), 'regex' => '*users*' ],
    // ];
    $menus = [
        [ 'role' => [], 'type' => 'item', 'text' => 'Dashboard', 'icon' => null, 'img' => '<img src="'.asset('img/icons/Dashboard.png').'" width="26px" class="icon tw-inline-block tw-mt-1">', 'route' => route('dashboard'), 'regex' => 'dashboard' ],
        [ 'role' => [], 'type' => 'item', 'text' => 'Profil', 'icon' => null, 'img' => '<img src="'.asset('img/icons/Anggota.png').'" width="22px" class="icon tw-inline-block">', 'route' => route('profile'), 'regex' => 'dashboard/profil' ],
        [ 'role' => ['Admin'], 'type' => 'header', 'text' => 'Administrasi' ],
        [ 'role' => ['Admin'], 'type' => 'item', 'text' => 'Kapal', 'icon' => null, 'img' => '<img src="'.asset('img/icons/Kapal.png').'" width="32px" class="icon tw-inline-block tw-mt-2">', 'route' => route('ships.index'), 'regex' => '*ships*' ],
        [ 'role' => ['Admin'], 'type' => 'item', 'text' => 'Operasi Kapal', 'icon' => 'cone-striped', 'route' => route('ship-operations.index'), 'regex' => '*ship-operations*' ],
        [ 'role' => ['Admin', 'Petugas'], 'type' => 'header', 'text' => 'Form Petugas' ],
        [ 'role' => ['Admin', 'Petugas'], 'type' => 'item', 'text' => 'Pelaporan', 'icon' => null, 'img' => '<img src="'.asset('img/icons/Form Petugas.png').'" width="22px" class="icon tw-inline-block tw-mt-1">', 'route' => route('ship-reports.index'), 'regex' => '*ship-reports*' ],
        [ 'role' => ['Admin'], 'type' => 'header', 'text' => 'Laporan' ],
        [ 'role' => ['Admin', 'Supervisor'], 'type' => 'item', 'text' => 'Laporan', 'icon' => 'newspaper', 'route' => route('reports'), 'regex' => '*/report*' ],
        [ 'role' => ['Admin'], 'type' => 'header', 'text' => 'Manajemen' ],
        [ 'role' => ['Admin'], 'type' => 'item', 'text' => 'Akun', 'icon' => 'people', 'route' => route('users.index'), 'regex' => '*users*' ],
    ];
@endphp

<div class="sidebar">
    <div class="sidebar-container">
        <div class="sidebar-header pt-4">
            <a href="#" class="sidebar-brand">
                <img src="{{ asset('img/icons/Logo App.png') }}" width="54px" class="d-inline">
            </a>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                @foreach ($menus as $item)
                    @php  if (count($item['role']) > 0) if (!in_array(Auth::user()->role, $item['role'])) continue;  @endphp
                    @if ($item['type'] == 'item')
                        <li class="item {{ (request()->is($item['regex']) ? 'active' : '') }}">
                            <a href="{{ $item['route'] }}">
                                @if ($item['icon'] == null)
                                    {!! $item['img'] !!}
                                @else
                                    <svg class="bi icon" width="24" height="24" fill="currentColor">
                                        <use xlink:href="{{ asset('img/icon/bootstrap-icons.svg#' . $item['icon']) }}"/>
                                    </svg>
                                @endif
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
                <img src="{{ asset('img/icons/Logo Dishub.png') }}" width="64px" class="d-inline">
            </div>
        </div>
    </div>
</div>
