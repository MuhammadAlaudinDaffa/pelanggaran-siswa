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

                <!-- Data Anak -->
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Data Anak</span>
                </li>
                <li class="sidebar-item {{ request()->routeIs('orang_tua.kesiswaan.siswa_overview.*') ? 'selected' : '' }}">
                    <a class="sidebar-link" href="{{ route('orang_tua.kesiswaan.siswa_overview.show', Auth::id()) }}" aria-expanded="{{ request()->routeIs('orang_tua.kesiswaan.siswa_overview.*') ? 'true' : 'false' }}">
                        <span>
                            <i class="ti ti-user"></i>
                        </span>
                        <span class="hide-menu">Profil Anak</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->routeIs('orang_tua.kesiswaan.pelanggaran.*') ? 'selected' : '' }}">
                    <a class="sidebar-link" href="{{ route('orang_tua.kesiswaan.pelanggaran.index') }}" aria-expanded="{{ request()->routeIs('orang_tua.kesiswaan.pelanggaran.*') ? 'true' : 'false' }}">
                        <span>
                            <i class="ti ti-alert-triangle"></i>
                        </span>
                        <span class="hide-menu">Pelanggaran</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->routeIs('orang_tua.kesiswaan.prestasi.*') ? 'selected' : '' }}">
                    <a class="sidebar-link" href="{{ route('orang_tua.kesiswaan.prestasi.index') }}" aria-expanded="{{ request()->routeIs('orang_tua.kesiswaan.prestasi.*') ? 'true' : 'false' }}">
                        <span>
                            <i class="ti ti-trophy"></i>
                        </span>
                        <span class="hide-menu">Prestasi</span>
                    </a>
                </li>

            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>