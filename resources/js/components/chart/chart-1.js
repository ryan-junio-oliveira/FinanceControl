

export const initChartOne = () => {
    const chartElement = document.querySelector('#chartOne');
    if (!chartElement) return;

    // parse optional data attributes: data-series (JSON) and data-categories (JSON)
    let seriesData = null;
    let categories = null;

    try {
        if (chartElement.dataset.series) {
            seriesData = JSON.parse(chartElement.dataset.series);
        }
    } catch (e) {
        console.warn('chartOne: invalid data-series', e);
    }

    try {
        if (chartElement.dataset.categories) {
            categories = JSON.parse(chartElement.dataset.categories);
        }
    } catch (e) {
        console.warn('chartOne: invalid data-categories', e);
    }

    // sensible defaults (keeps backward compatibility)
    const defaultCategories = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
    const defaultSeries = [{ name: "Sales", data: [168, 385, 201, 298, 187, 195, 291, 110, 215, 390, 280, 112] }];

    const series = seriesData && Array.isArray(seriesData) && seriesData.length ? seriesData : defaultSeries;
    const cats = categories && Array.isArray(categories) && categories.length ? categories : defaultCategories;

    // color mapping for common series names
    const colorMap = {
        'Receitas': '#12B76A',
        'Despesas': '#F04438',
    };
    const colors = series.map(s => colorMap[s.name] || '#465FFF');

    const chartOneOptions = {
        series: series,
        colors: colors,
        chart: {
            fontFamily: "Outfit, sans-serif",
            type: "bar",
            height: 280,
            toolbar: { show: false },
        },
        plotOptions: {
            bar: { horizontal: false, columnWidth: "39%", borderRadius: 6, borderRadiusApplication: "end" },
        },
        dataLabels: { enabled: false },
        stroke: { show: true, width: 3, colors: ["transparent"] },
        xaxis: { categories: cats, axisBorder: { show: false }, axisTicks: { show: false } },
        legend: { show: true, position: "top", horizontalAlign: "left", fontFamily: "Outfit", markers: { radius: 99 } },
        yaxis: { title: false },
        grid: { yaxis: { lines: { show: true } } },
        fill: { opacity: 1 },
        tooltip: {
            x: { show: false },
            y: { formatter: function (val) { return val; } },
        },
    };

    const chart = new ApexCharts(chartElement, chartOneOptions);
    chart.render();

    return chart;
};

export default initChartOne;
