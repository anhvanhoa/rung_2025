const setOption = (color) => {
    var options = {
        series: [{
            name: "Revenue",
            data: [50, 85, 60, 100, 70, 45, 90, 75]
        }],
        chart: {
            height: 45,
            type: "area",
            sparkline: {
                enabled: !0
            },
            animations: {
                enabled: !1
            }
        },
        colors: [getComputedStyle(document.documentElement).getPropertyValue(color).trim()],
        fill: {
            type: "gradient",
            gradient: {
                shadeIntensity: 1,
                opacityFrom: .5,
                opacityTo: .1,
                stops: [0, 90, 100]
            }
        },
        tooltip: {
            enabled: !1
        },
        dataLabels: {
            enabled: !1
        },
        grid: {
            show: !1
        },
        xaxis: {
            labels: {
                show: !1
            },
            axisBorder: {
                show: !1
            },
            axisTicks: {
                show: !1
            }
        },
        yaxis: {
            show: !1
        },
        stroke: {
            curve: "smooth",
            width: 1
        }
    }
    return options;
}

var colors = ['--abstack-primary', '--abstack-success', '--abstack-info', '--abstack-danger', '--abstack-secondary', '--abstack-warning'];

for (var i = 0; i < 6; i++) {
    var id = "#chart" + i;
    var color = colors[i];
    var option = setOption(color);
    var chart = new ApexCharts(document.querySelector(id), option)
    chart.render();
}

