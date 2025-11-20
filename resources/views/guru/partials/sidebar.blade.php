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
                <li class="sidebar-item {{ request()->routeIs('guru.index') ? 'selected' : '' }}">
                    <a class="sidebar-link" href="{{ route('guru.index') }}" aria-expanded="{{ request()->routeIs('guru.index') ? 'true' : 'false' }}">
                        <span>
                            <i class="ti ti-layout-dashboard"></i>
                        </span>
                        <span class="hide-menu">Dashboard</span>
                    </a>
                </li>

                <!-- Guru Menu -->
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Guru</span>
                </li>
                <li class="sidebar-item {{ request()->routeIs('guru.guru.info_kelas.*') ? 'selected' : '' }}">
                    <a class="sidebar-link" href="{{ route('guru.guru.info_kelas.index') }}" aria-expanded="{{ request()->routeIs('guru.guru.info_kelas.*') ? 'true' : 'false' }}">
                        <span>
                            <i class="ti ti-message-circle"></i>
                        </span>
                        <span class="hide-menu">Informasi Kelas</span>
                    </a>
                </li>

                @php
                    $guru = \App\Models\Guru::where('user_id', Auth::id())->first();
                    $isWaliKelas = $guru && \App\Models\Kelas::where('wali_kelas_id', $guru->guru_id)->exists();
                @endphp
                @if($isWaliKelas)
                    <!-- Wali Kelas Menu -->
                    <li class="nav-small-cap">
                        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu">Wali Kelas</span>
                    </li>
                    <li class="sidebar-item {{ request()->routeIs('guru.kesiswaan.siswa_overview.*') ? 'selected' : '' }}">
                        <a class="sidebar-link" href="{{ \App\Helpers\RouteHelper::route('kesiswaan.siswa_overview.index') }}" aria-expanded="{{ request()->routeIs('guru.kesiswaan.siswa_overview.*') ? 'true' : 'false' }}">
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