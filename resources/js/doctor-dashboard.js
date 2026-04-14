// resources/js/doctor-dashboard.js
import Chart from 'chart.js/auto';

document.addEventListener('DOMContentLoaded', function() {
    const canvas = document.getElementById('medicationChart');
    if (!canvas) return;

    const labelsData = JSON.parse(canvas.dataset.labels);
    const countData = JSON.parse(canvas.dataset.counts);
    const ctx = canvas.getContext('2d');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labelsData,
            datasets: [{
                label: 'Prescriptions Issued',
                data: countData,
                backgroundColor: [
                    'rgba(37, 99, 235, 0.8)', 'rgba(28, 181, 209, 0.8)', 
                    'rgba(5, 150, 105, 0.8)', 'rgba(212, 175, 55, 0.8)', 'rgba(148, 163, 184, 0.8)'
                ],
                borderRadius: 6,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { drawBorder: false }, ticks: { stepSize: 1 } },
                x: { grid: { display: false } }
            }
        }
    });
});