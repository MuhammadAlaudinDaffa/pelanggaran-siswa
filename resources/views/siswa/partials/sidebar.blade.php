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
                <li class="sidebar-item {{ request()->routeIs('siswa.index') ? 'selected' : '' }}">
                    <a class="sidebar-link" href="{{ route('siswa.index') }}" aria-expanded="{{ request()->routeIs('siswa.index') ? 'true' : 'false' }}">
                        <span>
                            <i class="ti ti-layout-dashboard"></i>
                        </span>
                        <span class="hide-menu">Dashboard</span>
                    </a>
                </li>

                <!-- Siswa Menu -->
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Siswa</span>
                </li>
                <li class="sidebar-item {{ request()->routeIs('siswa.kesiswaan.siswa_overview.*') ? 'selected' : '' }}">
                    <a class="sidebar-link" href="{{ \App\Helpers\RouteHelper::route('kesiswaan.siswa_overview.show', Auth::user()->user_id) }}" aria-expanded="{{ request()->routeIs('siswa.kesiswaan.siswa_overview.*') ? 'true' : 'false' }}">
                        <span>
                            <i class="ti ti-user"></i>
                        </span>
                        <span class="hide-menu">Data Siswa</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->routeIs('siswa.bimbingan_konseling.*') ? 'selected' : '' }}">
                    <a class="sidebar-link" href="{{ route('siswa.bimbingan_konseling.bk.index') }}" aria-expanded="{{ request()->routeIs('siswa.bimbingan_konseling.*') ? 'true' : 'false' }}">
                        <span>
                            <i class="ti ti-messages"></i>
                        </span>
                        <span class="hide-menu">Bimbingan Konseling</span>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>