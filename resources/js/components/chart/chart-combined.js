export const initCombined = () => {
    const el = document.querySelector('#chartCombined');
    if (!el) return null;

    let labels = [];
    let series = [];
    try {
        labels = JSON.parse(el.dataset.labels || '[]');
        series = JSON.parse(el.dataset.series || '[]');
    } catch (e) {
        console.warn('chart-combined: invalid data attributes', e);
    }

    const options = {
        chart: { height: 220, type: 'bar', stacked: false, toolbar: { show: false } },
        series: series,
        plotOptions: { bar: { horizontal: false, columnWidth: '50%', borderRadius: 6 } },
        xaxis: { categories: labels },
        yaxis: { labels: { formatter: v => v ? v.toLocaleString() : v } },
        tooltip: { y: { formatter: val => val ? val.toLocaleString() : val } },
        colors: ['#12B76A', '#F04438', '#475569']
    };

    const chart = new ApexCharts(el, options);
    chart.render();
    return chart;
};

export default initCombined;