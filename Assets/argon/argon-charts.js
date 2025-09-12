var argonCharts = {
    colors: {
        gray: {
            100: "#f6f9fc",
            200: "#e9ecef",
            300: "#dee2e6",
            400: "#ced4da",
            500: "#adb5bd",
            600: "#8898aa",
            700: "#525f7f",
            800: "#32325d",
            900: "#212529"
        },
        theme: {
            default: "#172b4d",
            primary: "#5e72e4",
            secondary: "#f4f5f7",
            info: "#11cdef",
            success: "#2dce89",
            danger: "#f5365c",
            warning: "#fb6340"
        }
    },
    chartOptions: {
        defaults: {
            global: {
                responsive: true,
                maintainAspectRatio: false,
                defaultColor: "#e9ecef",
                defaultFontColor: "#8898aa",
                defaultFontFamily: "Open Sans",
                defaultFontSize: 13,
                layout: {
                    padding: 0
                },
                legend: {
                    display: false,
                    position: "bottom",
                    labels: {
                        usePointStyle: true,
                        padding: 16
                    }
                },
                elements: {
                    point: {
                        radius: 0,
                        backgroundColor: "#5e72e4"
                    },
                    line: {
                        tension: .4,
                        borderWidth: 4,
                        borderColor: "#5e72e4",
                        backgroundColor: "transparent",
                        borderCapStyle: "rounded"
                    },
                    rectangle: {
                        backgroundColor: "#5e72e4"
                    },
                    arc: {
                        backgroundColor: "#5e72e4",
                        borderColor: "#e9ecef",
                        borderWidth: 4
                    }
                },
                tooltips: {
                    enabled: true,
                    mode: "index",
                    intersect: false
                }
            },
            doughnut: {
                cutoutPercentage: 83,
                legendCallback: function(chart) {
                    var data = chart.data;
                    var content = "";
                    data.labels.forEach(function(label, index) {
                        var bgColor = data.datasets[0].backgroundColor[index];
                        content += '<span class="chart-legend-item">';
                        content += '<i class="chart-legend-indicator" style="background-color: ' + bgColor + '"></i>';
                        content += label;
                        content += '</span>';
                    });
                    return content;
                }
            }
        }
    }
};
