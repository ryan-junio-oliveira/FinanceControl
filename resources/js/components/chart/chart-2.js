
export const initChartTwo = () => {
    const chartElement = document.querySelector('#chartTwo');

    if (chartElement) {
        const percent = parseFloat(chartElement.dataset.percent) || 0;

        const chartTwoOptions = {
            series: [percent],
            colors: ["#465FFF"],
            chart: {
                fontFamily: "Outfit, sans-serif",
                type: "radialBar",
                height: 220,
                sparkline: {
                    enabled: true,
                },
            },
            plotOptions: {
                radialBar: {
                    startAngle: -90,
                    endAngle: 90,
                    hollow: {
                        size: "75%",
                    },
                    track: {
                        background: "#E4E7EC",
                        strokeWidth: "100%",
                        margin: 5,
                    },
                    dataLabels: {
                        name: { show: false },
                        value: {
                            fontSize: "28px",
                            fontWeight: "600",
                            offsetY: 50,
                            color: "#1D2939",
                            formatter: function (val) {
                                return Math.round(val) + "%";
                            },
                        },
                    },
                },
            },
            fill: { type: "solid", colors: ["#465FFF"] },
            stroke: { lineCap: "round" },
            labels: ["Execução"],
        };

        const chart = new ApexCharts(chartElement, chartTwoOptions);
        chart.render();
        return chart;
    }
}

export default initChartTwo;
