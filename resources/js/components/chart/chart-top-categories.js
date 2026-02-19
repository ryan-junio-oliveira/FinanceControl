export const initTopCategories = () => {
    const el = document.querySelector('#chartTopCategories');
    if (!el) return null;

    let labels = [];
    let series = [];
    try {
        labels = JSON.parse(el.dataset.labels || '[]');
        series = JSON.parse(el.dataset.series || '[]');
    } catch (e) {
        console.warn('chart-top-categories: invalid data attributes', e);
    }

    const options = {
        chart: { type: 'bar', height: 220, toolbar: { show: false } },
        series: [{ name: 'Despesas', data: series }],
        plotOptions: { bar: { horizontal: true, barHeight: '50%', borderRadius: 6 } },
        xaxis: { labels: { formatter: v => v ? v.toLocaleString() : v } },
        yaxis: { categories: labels },
        tooltip: { y: { formatter: val => val ? val.toLocaleString() : val } }
    };

    const chart = new ApexCharts(el, options);
    chart.render();
    return chart;
};

export default initTopCategories;