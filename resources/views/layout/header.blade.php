<header class="app-header">
    <nav class="navbar navbar-expand-lg">
        <ul class="navbar-nav">
            <li class="nav-item d-block d-xl-none">
                <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                    <i class="ti ti-menu-2"></i>
                </a>
            </li>
            <!-- <li class="nav-item">
                <a class="nav-link nav-icon-hover" href="javascript:void(0)">
                    <i class="ti ti-bell-ringing"></i>
                    <div class="notification bg-primary rounded-circle"></div>
                </a>
            </li> -->
        </ul>
        <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
            <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
                <li class="nav-item dropdown">
                    <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <img src="{{asset('assets/images/profile/user-1.jpg')}}" alt="" width="35" height="35"
                            class="rounded-circle">
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2"
                        onclick="event.stopPropagation()">
                        <div class="message-body">
                            <div class="px-3 py-2 border-bottom">
                                <h6 class="mb-1 fw-semibold">{{ Auth::user()->nama_lengkap }}</h6>
                                <p class="mb-1 fs-3">{{ Auth::user()->username }}</p>
                                <span class="badge bg-primary">{{ ucfirst(Auth::user()->level) }}</span>
                            </div>
                            <a class="d-flex align-items-center gap-2 dropdown-item" id="darkModeToggle">
                                <i class="ti ti-moon fs-6" id="darkModeIcon"></i>
                                <p class="mb-0 fs-3" id="darkModeText">Dark Mode</p>
                            </a>
                            <form action="{{ route('logout') }}" method="POST" class="mx-3 mt-2">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger w-100"
                                    id="logoutBtn">Logout</button>
                            </form>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</header>