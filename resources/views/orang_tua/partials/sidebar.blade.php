<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div>

        @include('layout.brand-logo')
        
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
            <ul id="sidebarnav">

                <!-- Dashboard -->
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Home</span>
                </li>
                <li class="sidebar-item {{ request()->routeIs('orang_tua.index') ? 'selected' : '' }}">
                    <a class="sidebar-link" href="{{ route('orang_tua.index') }}" aria-expanded="{{ request()->routeIs('orang_tua.index') ? 'true' : 'false' }}">
                        <span>
                            <i class="ti ti-layout-dashboard"></i>
                        </span>
                        <span class="hide-menu">Dashboard</span>
                    </a>
                </li>

                <!-- Orang Tua Menu -->
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Orang Tua</span>
                </li>
                <li class="sidebar-item {{ request()->routeIs('orang_tua.*') ? 'selected' : '' }}">
                    <a class="sidebar-link" href="{{ route('orang_tua.index') }}" aria-expanded="{{ request()->routeIs('orang_tua.*') ? 'true' : 'false' }}">
                        <span>
                            <i class="ti ti-users"></i>
                        </span>
                        <span class="hide-menu">Data Orang Tua</span>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>