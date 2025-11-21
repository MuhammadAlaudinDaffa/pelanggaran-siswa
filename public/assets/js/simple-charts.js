// Simple Charts Configuration - Matching Page Design
class SimpleCharts {
    constructor() {
        this.colors = {
            primary: '#0d6efd',
            success: '#198754',
            danger: '#dc3545',
            warning: '#ffc107',
            info: '#0dcaf0',
            secondary: '#6c757d',
            light: '#f8f9fa',
            dark: '#212529'
        };
        
        this.darkColors = {
            primary: '#6ea8fe',
            success: '#75b798',
            danger: '#ea868f',
            warning: '#ffda6a',
            info: '#6edff6',
            secondary: '#adb5bd',
            light: '#495057',
            dark: '#f8f9fa'
        };
        
        this.isDark = document.body.getAttribute('data-bs-theme') === 'dark';
        this.currentColors = this.isDark ? this.darkColors : this.colors;
    }

    // Base configuration for all charts
    getBaseConfig() {
        return {
            chart: {
                fontFamily: 'inherit',
                toolbar: { show: false },
                animations: {
                    enabled: true,
                    easing: 'easeinout',
                    speed: 800
                }
            },
            colors: [this.currentColors.primary, this.currentColors.success, this.currentColors.danger, this.currentColors.warning, this.currentColors.info],
            grid: {
                borderColor: this.isDark ? '#3e4651' : '#e7e7e7',
                strokeDashArray: 3,
                xaxis: { lines: { show: false } },
                yaxis: { lines: { show: true } }
            },
            xaxis: {
                labels: {
                    style: {
                        colors: this.isDark ? '#adb5bd' : '#8c8c8c',
                        fontSize: '11px'
                    }
                },
                axisBorder: { show: false },
                axisTicks: { show: false }
            },
            yaxis: {
                labels: {
                    style: {
                        colors: this.isDark ? '#adb5bd' : '#8c8c8c',
                        fontSize: '11px'
                    },
                    formatter: (val) => Math.floor(val)
                }
            },
            legend: {
                fontSize: '12px',
                fontWeight: 500,
                labels: {
                    colors: this.isDark ? '#adb5bd' : '#495057'
                }
            },
            tooltip: {
                theme: this.isDark ? 'dark' : 'light',
                style: {
                    fontSize: '11px'
                }
            }
        };
    }

    // Simple Area Chart
    createAreaChart(element, data, options = {}) {
        const config = {
            ...this.getBaseConfig(),
            series: data.series,
            chart: {
                ...this.getBaseConfig().chart,
                type: 'area',
                height: options.height || 350
            },
            dataLabels: { enabled: false },
            stroke: {
                curve: 'smooth',
                width: 2
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.4,
                    opacityTo: 0.1,
                    stops: [0, 90, 100]
                }
            },
            xaxis: {
                ...this.getBaseConfig().xaxis,
                categories: data.categories
            }
        };

        const chart = new ApexCharts(element, config);
        chart.render();
        return chart;
    }

    // Simple Bar Chart
    createBarChart(element, data, options = {}) {
        const config = {
            ...this.getBaseConfig(),
            series: data.series,
            chart: {
                ...this.getBaseConfig().chart,
                type: 'bar',
                height: options.height || 350
            },
            plotOptions: {
                bar: {
                    borderRadius: 4,
                    horizontal: options.horizontal || false,
                    columnWidth: '60%'
                }
            },
            dataLabels: { enabled: false },
            xaxis: {
                ...this.getBaseConfig().xaxis,
                categories: data.categories
            }
        };

        const chart = new ApexCharts(element, config);
        chart.render();
        return chart;
    }

    // Simple Line Chart
    createLineChart(element, data, options = {}) {
        const config = {
            ...this.getBaseConfig(),
            series: data.series,
            chart: {
                ...this.getBaseConfig().chart,
                type: 'line',
                height: options.height || 350
            },
            dataLabels: { enabled: false },
            stroke: {
                curve: 'smooth',
                width: 3
            },
            markers: {
                size: 4,
                strokeWidth: 2,
                hover: { size: 6 }
            },
            xaxis: {
                ...this.getBaseConfig().xaxis,
                categories: data.categories
            }
        };

        const chart = new ApexCharts(element, config);
        chart.render();
        return chart;
    }

    // Simple Donut Chart
    createDonutChart(element, data, options = {}) {
        const config = {
            ...this.getBaseConfig(),
            series: data.series,
            chart: {
                ...this.getBaseConfig().chart,
                type: 'donut',
                height: options.height || 300
            },
            labels: data.labels,
            plotOptions: {
                pie: {
                    donut: {
                        size: '70%',
                        labels: {
                            show: true,
                            total: {
                                show: true,
                                fontSize: '16px',
                                fontWeight: 600,
                                color: this.isDark ? '#adb5bd' : '#495057'
                            }
                        }
                    }
                }
            },
            dataLabels: {
                enabled: true,
                style: {
                    fontSize: '11px',
                    fontWeight: 500
                }
            }
        };

        const chart = new ApexCharts(element, config);
        chart.render();
        return chart;
    }

    // Mini Chart for Cards
    createMiniChart(element, data, type = 'line') {
        const config = {
            series: data.series,
            chart: {
                type: type,
                height: 60,
                sparkline: { enabled: true },
                animations: { enabled: false }
            },
            colors: [this.currentColors.primary],
            stroke: {
                curve: 'smooth',
                width: 2
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.3,
                    opacityTo: 0.1
                }
            },
            tooltip: {
                fixed: { enabled: false },
                x: { show: false },
                y: {
                    title: {
                        formatter: () => ''
                    }
                },
                marker: { show: false }
            }
        };

        const chart = new ApexCharts(element, config);
        chart.render();
        return chart;
    }

    // Progress Ring Chart
    createProgressRing(element, value, options = {}) {
        const config = {
            series: [value],
            chart: {
                type: 'radialBar',
                height: options.size || 80
            },
            plotOptions: {
                radialBar: {
                    hollow: { size: '60%' },
                    dataLabels: {
                        show: true,
                        name: { show: false },
                        value: {
                            fontSize: '14px',
                            fontWeight: 600,
                            color: this.isDark ? '#adb5bd' : '#495057',
                            formatter: (val) => `${val}%`
                        }
                    }
                }
            },
            colors: [options.color || this.currentColors.primary]
        };

        const chart = new ApexCharts(element, config);
        chart.render();
        return chart;
    }

    // Update colors when theme changes
    updateTheme() {
        this.isDark = document.body.getAttribute('data-bs-theme') === 'dark';
        this.currentColors = this.isDark ? this.darkColors : this.colors;
    }
}

// Initialize Simple Charts
const simpleCharts = new SimpleCharts();

// Listen for theme changes
document.addEventListener('DOMContentLoaded', function() {
    // Update charts when theme changes
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.type === 'attributes' && mutation.attributeName === 'data-bs-theme') {
                simpleCharts.updateTheme();
                // Trigger chart re-render if needed
                window.dispatchEvent(new Event('themeChanged'));
            }
        });
    });

    observer.observe(document.body, {
        attributes: true,
        attributeFilter: ['data-bs-theme']
    });
});

// Export for global use
window.SimpleCharts = SimpleCharts;
window.simpleCharts = simpleCharts;