export const initCardsBar = () => {
    const el = document.querySelector('#chartCards');
    if (!el) return null;

    let labels = [];
    let series = [];
    try {
        labels = JSON.parse(el.dataset.labels || '[]');
        series = JSON.parse(el.dataset.series || '[]');
    } catch (e) {
        console.warn('chart-cards: invalid data attributes', e);
    }

    const options = {
        chart: { type: 'bar', height: 220, toolbar: { show: false } },
        series: [{ name: 'Fatura', data: series }],
        plotOptions: { bar: { borderRadius: 6, columnWidth: '50%' } },
        xaxis: { categories: labels, labels: { rotate: -45 } },
        yaxis: { labels: { formatter: v => v ? v.toLocaleString() : v } },
        tooltip: { y: { formatter: val => val ? val.toLocaleString() : val } }
    };

    const chart = new ApexCharts(el, options);
    chart.render();
    return chart;
};

export default initCardsBar;