import { Chart, registerables } from 'chart.js';
import TableService from '../../services/admin/table';
import { createIcons, icons } from 'lucide';

Chart.register(...registerables);

document.addEventListener('DOMContentLoaded', () => {
    
    // 1. Dashboard Analytics (Charts)
    if (document.getElementById('trendChart') && window.ReportData) {
        initCharts();
    }

    // 2. Detailed Applications Report (Table)
    const tableBodyId = 'report-table-body';
    if (document.getElementById(tableBodyId)) {
        initApplicationsReport();
    }

    function initCharts() {
        const data = window.ReportData;

        // Trend Chart (Line)
        new Chart(document.getElementById('trendChart'), {
            type: 'line',
            data: {
                labels: data.trends.map(t => t.month),
                datasets: [{
                    label: 'Applications',
                    data: data.trends.map(t => t.count),
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    fill: true,
                    tension: 0.4,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { beginAtZero: true, grid: { borderDash: [5, 5] } },
                    x: { grid: { display: false } }
                }
            }
        });

        // Outcome Chart (Pie/Doughnut)
        new Chart(document.getElementById('outcomeChart'), {
            type: 'doughnut',
            data: {
                labels: Object.keys(data.outcomes),
                datasets: [{
                    data: Object.values(data.outcomes),
                    backgroundColor: ['#10b981', '#ef4444', '#f59e0b', '#3b82f6'],
                    borderWidth: 0,
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: { display: false }
                }
            }
        });
    }

    function initApplicationsReport() {
        const tableService = new TableService({
            tableBodyId: tableBodyId,
            paginationContainerId: 'pagination-container',
            searchInputId: 'reportSearch',
            endpoint: '/admin/reports/applications',
            renderRow: (item) => {
                const name = item.user?.profile 
                    ? `${item.user.profile.first_name} ${item.user.profile.last_name}` 
                    : (item.user?.name || 'Unknown');
                
                const date = new Date(item.created_at).toLocaleDateString();
                const statusColor = item.status === 'DECIDED' ? 'success' : 'primary';

                return `
                    <tr>
                        <td class="ps-4">
                            <div class="fw-bold text-body">${name}</div>
                            <div class="text-muted small">${item.user?.email || ''}</div>
                        </td>
                        <td><span class="text-body fw-medium">${item.scholarship?.name || 'N/A'}</span></td>
                        <td><span class="badge bg-${statusColor}-subtle text-${statusColor} border border-${statusColor}-subtle rounded-pill px-3 py-2">${item.status}</span></td>
                        <td class="text-muted">${date}</td>
                        <td class="fw-bold">${item.decision?.result || '<span class="text-muted fw-normal">Pending</span>'}</td>
                        <td class="pe-4 text-end">
                            <a href="/admin/applications/${item.id}" class="btn btn-sm btn-icon btn-outline-eskoylar-primary rounded-3 shadow-sm">
                                <i data-lucide="eye" style="width: 16px;"></i>
                            </a>
                        </td>
                    </tr>
                `;
            }
        });

        // Additional Filters
        const scholarshipFilter = document.getElementById('scholarshipFilter');
        const statusFilter = document.getElementById('statusFilter');
        const resetBtn = document.getElementById('resetFilters');
        const exportBtn = document.getElementById('exportBtn');

        const updateFilters = () => {
            tableService.setExtraParams({
                scholarship_id: scholarshipFilter.value,
                status: statusFilter.value
            });
        };

        scholarshipFilter.addEventListener('change', updateFilters);
        statusFilter.addEventListener('change', updateFilters);
        
        resetBtn.addEventListener('click', () => {
            scholarshipFilter.value = '';
            statusFilter.value = '';
            document.getElementById('reportSearch').value = '';
            tableService.searchQuery = '';
            updateFilters();
        });

        // Export logic
        exportBtn.addEventListener('click', (e) => {
            e.preventDefault();
            const url = new URL('/admin/reports/export/applications', window.location.origin);
            if (scholarshipFilter.value) url.searchParams.append('scholarship_id', scholarshipFilter.value);
            window.location.href = url.toString();
        });
    }

    createIcons({ icons });
});
