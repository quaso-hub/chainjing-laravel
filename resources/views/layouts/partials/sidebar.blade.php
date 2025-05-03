<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <div class="logo-header" data-background-color="dark">
            <a href="{{
                Auth::user()->jabatan_id === 1 ? route('dashboard.admin') :
                (Auth::user()->jabatan_id === 2 ? route('dashboard.anggota') :
                (Auth::user()->jabatan_id === 3 ? route('dashboard.publik') : '#'))
            }}" class="logo mx-auto">
                <img src="{{ asset('assets/img/kaiadmin/logo_light.png') }}" alt="navbar brand" class="navbar-brand"
                    height="20">
            </a>
            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar"><i class="gg-menu-right"></i></button>
                <button class="btn btn-toggle sidenav-toggler"><i class="gg-menu-left"></i></button>
            </div>
            <button class="topbar-toggler more"><i class="gg-more-vertical-alt"></i></button>
        </div>
    </div>
    <div class="sidebar-wrapper scrollbar scrollbar-inner pt-3">

        <div class="sidebar-content">
            @include('layouts.partials.menu')
        </div>
    </div>
</div>
