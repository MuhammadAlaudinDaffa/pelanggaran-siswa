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
                <li class="sidebar-item {{ request()->routeIs('kepala_sekolah.index') ? 'selected' : '' }}">
                    <a class="sidebar-link" href="{{ route('kepala_sekolah.index') }}"
                        aria-expanded="{{ request()->routeIs('kepala_sekolah.index') ? 'true' : 'false' }}">
                        <span>
                            <i class="ti ti-layout-dashboard"></i>
                        </span>
                        <span class="hide-menu">Dashboard</span>
                    </a>
                </li>

                <!-- Kesiswaan Management -->
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Manajemen Kesiswaan</span>
                </li>
                <li
                    class="sidebar-item {{ request()->routeIs('kepala_sekolah.kesiswaan.siswa_overview.*') ? 'selected' : '' }}">
                    <a class="sidebar-link" href="{{ route('kepala_sekolah.kesiswaan.siswa_overview.index') }}"
                        aria-expanded="{{ request()->routeIs('kesiswaan.siswa_overview.*') ? 'true' : 'false' }}">
                        <span>
                            <i class="ti ti-users"></i>
                        </span>
                        <span class="hide-menu">Overview Siswa</span>
                    </a>
                </li>
                <li
                    class="sidebar-item {{ request()->routeIs('kepala_sekolah.pelanggaran.*') ? 'selected' : '' }}">
                    <a class="sidebar-link" href="{{ route('kepala_sekolah.kesiswaan.pelanggaran.index') }}"
                        aria-expanded="{{ request()->routeIs('kesiswaan.pelanggaran.*') ? 'true' : 'false' }}">
                        <span>
                            <i class="ti ti-users"></i>
                        </span>
                        <span class="hide-menu">Pelanggaran</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->routeIs('kepala_sekolah.kesiswaan.sanksi.*') ? 'selected' : '' }}">
                    <a class="sidebar-link" href="{{ route('kepala_sekolah.kesiswaan.sanksi.index') }}"
                        aria-expanded="{{ request()->routeIs('kesiswaan.sanksi.*') ? 'true' : 'false' }}">
                        <span>
                            <i class="ti ti-gavel"></i>
                        </span>
                        <span class="hide-menu">Sanksi</span>
                    </a>
                </li>
                <li
                    class="sidebar-item {{ request()->routeIs('kepala_sekolah.kesiswaan.pelaksanaan_sanksi.*') ? 'selected' : '' }}">
                    <a class="sidebar-link" href="{{ route('kepala_sekolah.kesiswaan.pelaksanaan_sanksi.index') }}"
                        aria-expanded="{{ request()->routeIs('kesiswaan.pelaksanaan_sanksi.*') ? 'true' : 'false' }}">
                        <span>
                            <i class="ti ti-clipboard-check"></i>
                        </span>
                        <span class="hide-menu">Pelaksanaan Sanksi</span>
                    </a>
                </li>
                <li
                    class="sidebar-item {{ request()->routeIs('kepala_sekolah.kesiswaan.monitoring_pelanggaran.*') ? 'selected' : '' }}">
                    <a class="sidebar-link" href="{{ route('kepala_sekolah.kesiswaan.monitoring_pelanggaran.index') }}"
                        aria-expanded="{{ request()->routeIs('kesiswaan.monitoring_pelanggaran.*') ? 'true' : 'false' }}">
                        <span>
                            <i class="ti ti-eye"></i>
                        </span>
                        <span class="hide-menu">Monitoring Pelanggaran</span>
                    </a>
                </li>

                @php
                    $guru = \App\Models\Guru::where('user_id', Auth::id())->first();
                    $isWaliKelas = $guru && \App\Models\Kelas::where('wali_kelas_id', $guru->guru_id)->exists();
                @endphp
                
                @if($guru)
                    <!-- Guru Menu -->
                    <li class="nav-small-cap">
                        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu">Guru</span>
                    </li>
                    <li class="sidebar-item {{ request()->routeIs('kepala_sekolah.guru.info_kelas.*') ? 'selected' : '' }}">
                        <a class="sidebar-link" href="{{ route('kepala_sekolah.guru.info_kelas.index') }}" aria-expanded="{{ request()->routeIs('kepala_sekolah.guru.info_kelas.*') ? 'true' : 'false' }}">
                            <span>
                                <i class="ti ti-message-circle"></i>
                            </span>
                            <span class="hide-menu">Informasi Kelas</span>
                        </a>
                    </li>
                @endif
                @if($isWaliKelas)
                    <!-- Wali Kelas Menu -->
                    <li class="nav-small-cap">
                        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu">Wali Kelas</span>
                    </li>
                    <li class="sidebar-item {{ request()->routeIs('kepala_sekolah.kesiswaan.siswa_overview.*') ? 'selected' : '' }}">
                        <a class="sidebar-link" href="{{ \App\Helpers\RouteHelper::route('kesiswaan.siswa_overview.index') }}" aria-expanded="{{ request()->routeIs('kepala_sekolah.kesiswaan.siswa_overview.*') ? 'true' : 'false' }}">
                            <span>
                                <i class="ti ti-users"></i>
                            </span>
                            <span class="hide-menu">Data Siswa</span>
                        </a>
                    </li>
                @endif
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>