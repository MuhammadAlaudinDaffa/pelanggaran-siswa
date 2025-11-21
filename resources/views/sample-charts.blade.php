@extends('layout.main')
@section('title', 'Sample Charts - Simplified Graphics')
@section('content')
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h4 class="card-title text-white mb-1">Simplified Graphics Demo</h4>
                    <p class="card-text mb-0">Contoh implementasi grafik yang disederhanakan sesuai desain halaman</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards with Mini Charts -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="stat-number text-primary">1,234</div>
                            <div class="stat-label">Total Siswa</div>
                        </div>
                        <div id="miniChart1" class="mini-chart"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="stat-number text-success">89</div>
                            <div class="stat-label">Prestasi</div>
                        </div>
                        <div id="miniChart2" class="mini-chart"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="stat-number text-danger">23</div>
                            <div class="stat-label">Pelanggaran</div>
                        </div>
                        <div id="miniChart3" class="mini-chart"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stat-number text-info">75%</div>
                            <div class="stat-label">Progress</div>
                        </div>
                        <div id="progressRing" class="progress-ring"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Charts -->
    <div class="row">
        <!-- Area Chart -->
        <div class="col-lg-8 mb-4">
            <div class="card card-chart">
                <div class="card-body">
                    <h5 class="card-title mb-3">Tren Pelanggaran & Prestasi</h5>
                    <div id="areaChart" class="simple-chart simple-area-chart chart-md"></div>
                </div>
            </div>
        </div>

        <!-- Donut Chart -->
        <div class="col-lg-4 mb-4">
            <div class="card card-chart">
                <div class="card-body">
                    <h5 class="card-title mb-3">Distribusi Kategori</h5>
                    <div id="donutChart" class="simple-chart simple-donut-chart chart-md"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Bar Chart -->
        <div class="col-lg-6 mb-4">
            <div class="card card-chart">
                <div class="card-body">
                    <h5 class="card-title mb-3">Pelanggaran per Kelas</h5>
                    <div id="barChart" class="simple-chart simple-bar-chart chart-md"></div>
                </div>
            </div>
        </div>

        <!-- Line Chart -->
        <div class="col-lg-6 mb-4">
            <div class="card card-chart">
                <div class="card-body">
                    <h5 class="card-title mb-3">Tren Bulanan</h5>
                    <div id="lineChart" class="simple-chart simple-line-chart chart-md"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mini Charts Data
    const miniData1 = { series: [{ data: [10, 15, 12, 18, 20, 25, 22] }] };
    const miniData2 = { series: [{ data: [5, 8, 12, 15, 18, 20, 25] }] };
    const miniData3 = { series: [{ data: [8, 6, 4, 7, 5, 3, 2] }] };

    // Create Mini Charts
    simpleCharts.createMiniChart(document.querySelector('#miniChart1'), miniData1, 'area');
    simpleCharts.createMiniChart(document.querySelector('#miniChart2'), miniData2, 'area');
    simpleCharts.createMiniChart(document.querySelector('#miniChart3'), miniData3, 'area');

    // Progress Ring
    simpleCharts.createProgressRing(document.querySelector('#progressRing'), 75, {
        color: simpleCharts.currentColors.info,
        size: 80
    });

    // Area Chart
    const areaData = {
        series: [{
            name: 'Pelanggaran',
            data: [30, 25, 35, 20, 45, 32, 28]
        }, {
            name: 'Prestasi',
            data: [15, 20, 25, 30, 28, 35, 40]
        }],
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul']
    };
    simpleCharts.createAreaChart(document.querySelector('#areaChart'), areaData);

    // Donut Chart
    const donutData = {
        series: [44, 55, 13, 33],
        labels: ['Ringan', 'Sedang', 'Berat', 'Sangat Berat']
    };
    simpleCharts.createDonutChart(document.querySelector('#donutChart'), donutData);

    // Bar Chart
    const barData = {
        series: [{
            name: 'Pelanggaran',
            data: [12, 8, 15, 6, 20, 10]
        }],
        categories: ['X RPL 1', 'X RPL 2', 'XI RPL 1', 'XI RPL 2', 'XII RPL 1', 'XII RPL 2']
    };
    simpleCharts.createBarChart(document.querySelector('#barChart'), barData);

    // Line Chart
    const lineData = {
        series: [{
            name: 'Pelanggaran',
            data: [23, 18, 25, 15, 30, 22, 20]
        }, {
            name: 'Prestasi',
            data: [12, 15, 18, 22, 25, 28, 30]
        }],
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul']
    };
    simpleCharts.createLineChart(document.querySelector('#lineChart'), lineData);
});
</script>
@endpush