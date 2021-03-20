<div class="navbar">
    <div class="navbar-container">
        <div class="toggle-sidebar">
            <a href="#" class="toggle">
                <svg class="bi icon" width="24" height="24" fill="currentColor">
                    <use xlink:href="{{ asset('img/icon/bootstrap-icons.svg#text-left') }}"/>
                </svg>
            </a>
        </div>
        <div class="navbar-header">
            <div class="navbar-brand">
                <a href="#" class="title">Sistem Informasi Angkutan</a>
                <a href="#" class="subtitle">Penyeberangan Gresik - Bawean</a>
            </div>
        </div>
        <ul class="menu">
            <li class="tw-hidden lg:tw-block">
                <a href="{{ route('profile') }}">
                    <svg class="bi icon" width="24" height="24" fill="currentColor">
                        <use xlink:href="{{ asset('img/icon/bootstrap-icons.svg#person') }}"/>
                    </svg>
                    <span>{{ Auth::user()->name }}</span>
                </a>
            </li>
            <li class="tw-bg-red-500"><a href="{{ route('logout') }}" style="color: rgba(229, 231, 235, 1);">Logout</a></li>
        </ul>
    </div>
</div>