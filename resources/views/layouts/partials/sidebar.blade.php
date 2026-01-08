<div class="sidebar sidebar-dark sidebar-main sidebar-expand-md">

    <div class="sidebar-mobile-toggler text-center">
        <a href="#" class="sidebar-mobile-main-toggle">
            <i class="icon-arrow-left8"></i>
        </a>
        Navigation
        <a href="#" class="sidebar-mobile-expand">
            <i class="icon-screen-full"></i>
            <i class="icon-screen-normal"></i>
        </a>
    </div>
    <div class="sidebar-content">

        <div class="sidebar-user">
            <div class="card-body">
                <div class="media">
                    <div class="mr-3">
                        <a href="#"><img src="{{ asset('limitless/global_assets/images/placeholders/placeholder.jpg') }}" width="38" height="38" class="rounded-circle" alt=""></a>
                    </div>

                    <div class="media-body">
                        <div class="media-title font-weight-semibold">{{ Auth::user()->name }}</div>
                        <div class="font-size-xs opacity-50">
                            <i class="icon-user font-size-sm"></i> &nbsp;{{ ucfirst(Auth::user()->role) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card card-sidebar-mobile">
            <ul class="nav nav-sidebar" data-nav-type="accordion">

                <li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs">Main</div> <i class="icon-menu" title="Main"></i></li>

                {{-- === MENU KHUSUS ADMIN === --}}
                @if(auth()->user()->role == 'admin')
                    
                    {{-- Dashboard --}}
                    <li class="nav-item">
                        <a href="{{ route('home') }}" class="nav-link {{ Request::is('home') ? 'active' : '' }}">
                            <i class="icon-home4"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    {{-- Kelola Barang --}}
                    <li class="nav-item">
                        <a href="{{ route('items.index') }}" class="nav-link {{ Request::is('items*') ? 'active' : '' }}">
                            <i class="icon-box"></i>
                            <span>Kelola Barang</span>
                        </a>
                    </li>

                    {{-- Data Pesanan --}}
                    <li class="nav-item">
                        <a href="{{ route('bookings.index') }}" class="nav-link {{ Request::is('bookings*') ? 'active' : '' }}">
                            <i class="icon-cart5"></i>
                            <span>Data Pesanan</span>
                            @php $pendingCount = \App\Booking::where('status', 'pending')->count(); @endphp
                            @if($pendingCount > 0)
                                <span class="badge badge-pill bg-warning-400 ml-auto">{{ $pendingCount }}</span>
                            @endif
                        </a>
                    </li>

                {{-- === MENU KHUSUS USER (CUSTOMER) === --}}
                @else

                    {{-- Katalog --}}
                    <li class="nav-item">
                        <a href="{{ route('home') }}" class="nav-link {{ Request::is('home') ? 'active' : '' }}">
                            <i class="icon-store"></i>
                            <span>Katalog Sewa</span>
                        </a>
                    </li>

                    {{-- Pesanan Saya --}}
                    <li class="nav-item">
                        <a href="{{ route('bookings.mine') }}" class="nav-link {{ Request::is('my-bookings*') ? 'active' : '' }}">
                            <i class="icon-bag"></i>
                            <span>Pesanan Saya</span>
                        </a>
                    </li>

                @endif

                {{-- Menu Logout --}}
                <li class="nav-item">
                    <a href="{{ route('logout') }}" class="nav-link"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="icon-switch2"></i>
                        <span>Logout</span>
                    </a>
                </li>

            </ul>
        </div>
        </div>
    </div>