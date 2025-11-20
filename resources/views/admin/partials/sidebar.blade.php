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
                <li class="sidebar-item {{ request()->routeIs('admin.index') ? 'selected' : '' }}">
                    <a class="sidebar-link" href="{{ route('admin.index') }}" aria-expanded="{{ request()->routeIs('admin.index') ? 'true' : 'false' }}">
                        <span>
                            <i class="ti ti-layout-dashboard"></i>
                        </span>
                        <span class="hide-menu">Dashboard</span>
                    </a>
                </li>

                <!-- Data Master -->
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Data Master</span>
                </li>
                <li class="sidebar-item {{ request()->routeIs('admin.data-master.*') ? 'selected' : '' }}">
                    <a class="sidebar-link" href="{{ route('admin.data-master.index') }}" aria-expanded="{{ request()->routeIs('admin.data-master.*') ? 'true' : 'false' }}">
                        <span>
                            <i class="ti ti-database"></i>
                        </span>
                        <span class="hide-menu">Master Data</span>
                    </a>
                </li>

                <!-- Kesiswaan -->
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Kesiswaan</span>
                </li>
                <li class="sidebar-item {{ request()->routeIs('admin.kesiswaan.pelanggaran.*') ? 'selected' : '' }}">
                    <a class="sidebar-link" href="{{ route('admin.kesiswaan.pelanggaran.index') }}" aria-expanded="{{ request()->routeIs('admin.kesiswaan.pelanggaran.*') ? 'true' : 'false' }}">
                        <span>
                            <i class="ti ti-alert-triangle"></i>
                        </span>
                        <span class="hide-menu">Pelanggaran</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->routeIs('admin.kesiswaan.prestasi.*') ? 'selected' : '' }}">
                    <a class="sidebar-link" href="{{ route('admin.kesiswaan.prestasi.index') }}" aria-expanded="{{ request()->routeIs('admin.kesiswaan.prestasi.*') ? 'true' : 'false' }}">
                        <span>
                            <i class="ti ti-trophy"></i>
                        </span>
                        <span class="hide-menu">Prestasi</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->routeIs('admin.kesiswaan.sanksi.*') ? 'selected' : '' }}">
                    <a class="sidebar-link" href="{{ route('admin.kesiswaan.sanksi.index') }}" aria-expanded="{{ request()->routeIs('admin.kesiswaan.sanksi.*') ? 'true' : 'false' }}">
                        <span>
                            <i class="ti ti-gavel"></i>
                        </span>
                        <span class="hide-menu">Sanksi</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->routeIs('admin.kesiswaan.pelaksanaan_sanksi.*') ? 'selected' : '' }}">
                    <a class="sidebar-link" href="{{ route('admin.kesiswaan.pelaksanaan_sanksi.index') }}" aria-expanded="{{ request()->routeIs('admin.kesiswaan.pelaksanaan_sanksi.*') ? 'true' : 'false' }}">
                        <span>
                            <i class="ti ti-clipboard-check"></i>
                        </span>
                        <span class="hide-menu">Pelaksanaan Sanksi</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->routeIs('admin.kesiswaan.monitoring_pelanggaran.*') ? 'selected' : '' }}">
                    <a class="sidebar-link" href="{{ route('admin.kesiswaan.monitoring_pelanggaran.index') }}" aria-expanded="{{ request()->routeIs('admin.kesiswaan.monitoring_pelanggaran.*') ? 'true' : 'false' }}">
                        <span>
                            <i class="ti ti-eye-check"></i>
                        </span>
                        <span class="hide-menu">Monitoring Pelanggaran</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->routeIs('admin.kesiswaan.siswa_overview.*') ? 'selected' : '' }}">
                    <a class="sidebar-link" href="{{ route('admin.kesiswaan.siswa_overview.index') }}" aria-expanded="{{ request()->routeIs('admin.kesiswaan.siswa_overview.*') ? 'true' : 'false' }}">
                        <span>
                            <i class="ti ti-users"></i>
                        </span>
                        <span class="hide-menu">Siswa Overview</span>
                    </a>
                </li>

                <!-- Bimbingan Konseling -->
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Bimbingan Konseling</span>
                </li>
                <li class="sidebar-item {{ request()->routeIs('admin.bimbingan_konseling.*') ? 'selected' : '' }}">
                    <a class="sidebar-link" href="{{ route('admin.bimbingan_konseling.bk.index') }}"
                        aria-expanded="{{ request()->routeIs('admin.bimbingan_konseling.*') ? 'true' : 'false' }}">
                        <span>
                            <i class="ti ti-heart-handshake"></i>
                        </span>
                        <span class="hide-menu">Bimbingan Konseling</span>
                    </a>
                </li>

                @php
                    $guru = \App\Models\Guru::where('user_id', Auth::id())->first();
                @endphp
                @if($guru)
                    <!-- Guru Menu -->
                    <li class="nav-small-cap">
                        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu">Guru</span>
                    </li>
                    <li class="sidebar-item {{ request()->routeIs('admin.guru.info_kelas.*') ? 'selected' : '' }}">
                        <a class="sidebar-link" href="{{ route('admin.guru.info_kelas.index') }}" aria-expanded="{{ request()->routeIs('admin.guru.info_kelas.*') ? 'true' : 'false' }}">
                            <span>
                                <i class="ti ti-message-circle"></i>
                            </span>
                            <span class="hide-menu">Informasi Kelas</span>
                        </a>
                    </li>
                @endif
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>