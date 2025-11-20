<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logos/favicon.png') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/dark-mode.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tabler-icons/3.35.0/tabler-icons.min.css">
</head>

<body data-bs-theme="light">
    <script>
        // Set theme and loader background before any rendering
        const savedTheme = localStorage.getItem('theme') || 'light';
        const loaderBg = savedTheme === 'dark' ? '#1a1d29' : '#fff';
        document.documentElement.style.setProperty('--loader-bg', loaderBg);
    </script>
    
    <!-- Loader -->
    <div id="loader" class="position-fixed top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center" style="z-index: 9999; background-color: var(--loader-bg);">
        <div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    
    <!-- Navigation Loader -->
    <div id="navLoader" class="position-fixed top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center" style="z-index: 9999; background-color: var(--loader-bg); opacity: 0; visibility: hidden; transition: all 0.3s ease;">
        <div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">

        <!-- Sidebar Start -->
        @if(Auth::user()->level === 'admin')
            @include('admin.partials.sidebar')
        @elseif(Auth::user()->level === 'kesiswaan')
            @include('kesiswaan.partials.sidebar')
        @elseif(Auth::user()->level === 'kepala_sekolah')
            @include('kepala_sekolah.partials.sidebar')
        @elseif(Auth::user()->level === 'bimbingan_konseling')
            @include('bimbingan_konseling.partials.sidebar')
        @elseif(Auth::user()->level === 'guru')
            @include('guru.partials.sidebar')
        @elseif(Auth::user()->level === 'siswa')
            @include('siswa.partials.sidebar')
        @elseif(Auth::user()->level === 'orang_tua')
            @include('orangtua.partials.sidebar')
        @endif
        <!--  Sidebar End -->

        <!--  Main wrapper -->
        <div class="body-wrapper">

            <!--  Header Start -->
            @include('layout.header')
            <!--  Header End -->
            
            <!-- Content Start -->
            <div class="container-fluid">
                @yield('content')
            </div>
            <!-- Content End -->

        </div>
    </div>
    <script src="{{  asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{  asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{  asset('assets/js/sidebarmenu.js') }}"></script>
    <script src="{{  asset('assets/js/app.min.js') }}"></script>
    <script src="{{  asset('assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
    <script src="{{  asset('assets/libs/simplebar/dist/simplebar.js') }}"></script>
    <script src="{{  asset('assets/js/dashboard.js') }}"></script>
    <script>
        // Apply theme before DOM loads to prevent flash
        (function() {
            const savedTheme = localStorage.getItem('theme') || 'light';
            document.body.setAttribute('data-bs-theme', savedTheme);
            
            // Set loader background immediately based on theme
            const loader = document.getElementById('loader');
            const navLoader = document.getElementById('navLoader');
            if (savedTheme === 'dark') {
                if (loader) loader.style.backgroundColor = '#1a1d29';
                if (navLoader) navLoader.style.backgroundColor = '#1a1d29';
            }
        })();
        

        
        document.addEventListener('DOMContentLoaded', function() {
            const darkModeToggle = document.getElementById('darkModeToggle');
            const darkModeIcon = document.getElementById('darkModeIcon');
            const darkModeText = document.getElementById('darkModeText');
            const sidebarLogo = document.getElementById('sidebarLogo');
            const loader = document.getElementById('loader');
            const body = document.body;
            
            // Hide loader immediately
            if (loader) {
                loader.style.animation = 'fadeOut 1s ease-in-out forwards';
            }
            
            // Check saved theme
            const savedTheme = localStorage.getItem('theme') || 'light';
            updateToggleUI(savedTheme);
            updateLogo(savedTheme);
            
            darkModeToggle.addEventListener('click', function() {
                const currentTheme = body.getAttribute('data-bs-theme');
                const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
                
                body.setAttribute('data-bs-theme', newTheme);
                localStorage.setItem('theme', newTheme);
                updateToggleUI(newTheme);
                updateLogo(newTheme);
            });
            
            function updateToggleUI(theme) {
                if (theme === 'dark') {
                    darkModeIcon.className = 'ti ti-sun fs-6';
                    darkModeText.textContent = 'Light Mode';
                } else {
                    darkModeIcon.className = 'ti ti-moon fs-6';
                    darkModeText.textContent = 'Dark Mode';
                }
            }
            
            function updateLogo(theme) {
                if (sidebarLogo) {
                    sidebarLogo.src = theme === 'dark' 
                        ? '{{ asset("assets/images/logos/light-logo.png") }}'
                        : '{{ asset("assets/images/logos/dark-logo.png") }}';
                }
            }
            
            // Navigation loader
            document.addEventListener('click', function(e) {
                const target = e.target.closest('a');
                if (target && target.href && !target.href.includes('javascript:') && !target.closest('form')) {
                    const navLoader = document.getElementById('navLoader');
                    if (navLoader) {
                        // Set background based on current theme
                        const currentTheme = body.getAttribute('data-bs-theme');
                        navLoader.style.backgroundColor = currentTheme === 'dark' ? '#1a1d29' : '#fff';
                        navLoader.style.opacity = '1';
                        navLoader.style.visibility = 'visible';
                    }
                }
            });
        });
    </script>
</body>

</html>