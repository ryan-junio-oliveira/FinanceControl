export const initPie = (selectorId = 'chartExpensesByCategory') => {
    const el = document.querySelector('#' + selectorId);
    if (!el) return null;

    let series = [];
    let labels = [];
    try {
        series = JSON.parse(el.dataset.series || '[]');
        labels = JSON.parse(el.dataset.labels || '[]');
    } catch (e) {
        console.warn('chart-pie: invalid data attributes', e);
    }

    const options = {
        chart: { type: 'donut', height: 280 },
        series: series,
        labels: labels,
        legend: { position: 'bottom' },
        tooltip: { y: { formatter: val => val ? val.toLocaleString() : val } },
        responsive: [{
            breakpoint: 640,
            options: { chart: { height: 220 }, legend: { position: 'bottom' } }
        }]
    };

    const chart = new ApexCharts(el, options);
    chart.render();
    return chart;
};

export default initPie;