import { Chart, registerables } from 'chart.js';
Chart.register(...registerables);

document.addEventListener('DOMContentLoaded', () => {
    const dataEl = document.getElementById('analytics-data');
    if (!dataEl) return;

    const months = JSON.parse(dataEl.getAttribute('data-months'));
    const trendData = JSON.parse(dataEl.getAttribute('data-trend'));
    const distributionData = JSON.parse(dataEl.getAttribute('data-distribution'));

    // 1. Trends Chart (Line)
    const trendsCtx = document.getElementById('trendsChart');
    if (trendsCtx) {
        new Chart(trendsCtx, {
            type: 'line',
            data: {
                labels: months,
                datasets: [{
                    label: 'Applications',
                    data: trendData,
                    borderColor: '#4f46e5',
                    backgroundColor: 'rgba(79, 70, 229, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 4,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#4f46e5',
                    pointBorderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        backgroundColor: '#1f2937',
                        titleFont: { size: 13, weight: '600' },
                        bodyFont: { size: 12 },
                        padding: 10,
                        cornerRadius: 8
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(0, 0, 0, 0.05)' },
                        ticks: { stepSize: 1, color: '#9ca3af' }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { color: '#9ca3af' }
                    }
                }
            }
        });
    }

    // 2. Program Distribution Chart (Doughnut)
    const distCtx = document.getElementById('distributionChart');
    if (distCtx) {
        const labels = distributionData.map(d => d.name);
        const counts = distributionData.map(d => d.count);
        
        // Premium Color Palette
        const palette = [
            '#4f46e5', // Primary
            '#10b981', // Success
            '#f59e0b', // Warning
            '#ef4444', // Danger
            '#8b5cf6', // Purple
            '#06b6d4'  // Cyan
        ];

        new Chart(distCtx, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    data: counts,
                    backgroundColor: palette,
                    borderWidth: 0,
                    hoverOffset: 15
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 20,
                            font: { size: 11, family: "'Inter', sans-serif" },
                            color: '#6b7280'
                        }
                    },
                    tooltip: {
                        backgroundColor: '#1f2937',
                        padding: 12,
                        cornerRadius: 8,
                        displayColors: false
                    }
                }
            }
        });
    }
});
