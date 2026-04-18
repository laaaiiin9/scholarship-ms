import { Chart, registerables } from 'chart.js';
Chart.register(...registerables);

document.addEventListener('DOMContentLoaded', () => {
    const dataEl = document.getElementById('student-analytics-data');
    if (!dataEl) return;

    const distributionData = JSON.parse(dataEl.getAttribute('data-distribution'));

    // Prepare labels and counts from object { 'SUBMITTED': 1, 'DECIDED': 2 }
    const labels = Object.keys(distributionData).map(k => k.replace(/_/g, ' '));
    const counts = Object.values(distributionData);
    
    // Status color mapping for consistency
    const statusColors = {
        'DRAFT': '#9ca3af',
        'SUBMITTED': '#4f46e5',
        'UNDER_REVIEW': '#f59e0b',
        'REVISION_REQUIRED': '#ef4444',
        'DECIDED': '#10b981',
        'REJECTED': '#6b7280'
    };

    const bgColors = Object.keys(distributionData).map(k => statusColors[k] || '#8b5cf6');

    const ctx = document.getElementById('statusChart');
    if (ctx && counts.length > 0) {
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    data: counts,
                    backgroundColor: bgColors,
                    borderWidth: 0,
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '75%',
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            usePointStyle: true,
                            padding: 20,
                            font: { size: 12, family: "'Inter', sans-serif" },
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
    } else if (ctx) {
        // Show empty state if no applications
        ctx.parentNode.innerHTML = '<div class="d-flex align-items-center justify-content-center h-100"><p class="text-muted small">No data available yet</p></div>';
    }
});
