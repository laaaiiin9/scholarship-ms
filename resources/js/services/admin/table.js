import { createIcons, icons } from 'lucide';

export default class TableService {
    constructor({ tableBodyId, paginationContainerId, searchInputId, endpoint, renderRow, onPageChangeCallback }) {
        this.tableBody = document.getElementById(tableBodyId);
        this.paginationContainer = document.getElementById(paginationContainerId);
        this.searchInput = document.getElementById(searchInputId);
        this.endpoint = endpoint;
        this.renderRow = renderRow;
        this.onPageChangeCallback = onPageChangeCallback;
        
        this.currentPage = 1;
        this.searchQuery = '';
        this.searchTimeout = null;
        this.extraParams = {};

        this.init();
    }

    init() {
        if (!this.tableBody) return;

        if (this.searchInput) {
            this.searchInput.addEventListener('input', (e) => {
                clearTimeout(this.searchTimeout);
                this.searchTimeout = setTimeout(() => {
                    this.searchQuery = e.target.value;
                    this.currentPage = 1;
                    this.fetchData();
                }, 500);
            });
        }
        
        if (this.paginationContainer) {
             this.paginationContainer.addEventListener('click', (e) => {
                 const link = e.target.closest('[data-page]');
                 if (link) {
                     e.preventDefault();
                     const page = link.getAttribute('data-page');
                     if (page && page !== 'null') {
                         this.goToPage(parseInt(page));
                     }
                 }
             });
        }

        this.fetchData();
    }

    setExtraParams(params) {
        this.extraParams = params;
        this.currentPage = 1;
        this.fetchData();
    }

    async fetchData() {
        if (!this.tableBody) return;
        this.tableBody.innerHTML = `<tr><td colspan="100%" class="text-center py-4 text-muted"><span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Loading...</td></tr>`;

        try {
            const url = new URL(this.endpoint, window.location.origin);
            url.searchParams.append('page', this.currentPage);
            url.searchParams.append('search', this.searchQuery);
            
            Object.keys(this.extraParams).forEach(key => {
                url.searchParams.append(key, this.extraParams[key]);
            });

            const response = await fetch(url.toString(), {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            
            if (!response.ok) throw new Error('Network response was not ok');
            
            const paginator = await response.json();
            this.renderTable(paginator.data);
            if (this.paginationContainer) {
                this.renderPagination(paginator);
            }
        } catch (error) {
            console.error('Error fetching data:', error);
            this.tableBody.innerHTML = `<tr><td colspan="100%" class="text-center text-danger py-4">Failed to load data.</td></tr>`;
            if (this.paginationContainer) this.paginationContainer.innerHTML = '';
        }
    }

    renderTable(data) {
        if (data.length === 0) {
            this.tableBody.innerHTML = `<tr><td colspan="100%" class="text-center py-4 text-muted">No records found.</td></tr>`;
            return;
        }

        let html = '';
        data.forEach(item => {
            html += this.renderRow(item);
        });
        
        this.tableBody.innerHTML = html;
        createIcons({ icons });
    }

    renderPagination(paginator) {
        if (paginator.total === 0) {
            this.paginationContainer.innerHTML = '';
            return;
        }

        const from = paginator.from || 0;
        const to = paginator.to || 0;
        const total = paginator.total || 0;

        let linksHtml = '';
        paginator.links.forEach(link => {
            let activeClass = link.active ? 'active' : '';
            let disabledClass = link.url === null ? 'disabled' : '';
            
            let label = link.label;
            if (label.includes('&laquo;')) {
                label = '<i data-lucide="chevron-left" style="width: 16px;"></i>';
            } else if (label.includes('&raquo;')) {
                label = '<i data-lucide="chevron-right" style="width: 16px;"></i>';
            }

            let pageNum = 'null';
            if (link.url) {
                const urlObj = new URL(link.url, window.location.origin);
                pageNum = urlObj.searchParams.get('page');
            }

            linksHtml += `
                <li class="page-item ${activeClass} ${disabledClass}">
                    <a class="page-link shadow-sm transition-all ${link.active ? 'fw-bold' : ''}" 
                       href="#" 
                       ${link.url === null ? 'tabindex="-1" aria-disabled="true"' : `data-page="${pageNum}"`}>
                       ${label}
                    </a>
                </li>
            `;
        });

        this.paginationContainer.innerHTML = `
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 w-100">
                <span class="text-muted" style="font-size: 0.85rem;">Showing <span class="fw-medium text-body">${from}</span> to <span class="fw-medium text-body">${to}</span> of <span class="fw-medium text-body">${total}</span> records</span>
                <nav aria-label="Pagination">
                    <ul class="pagination mb-0">
                        ${linksHtml}
                    </ul>
                </nav>
            </div>
        `;
        createIcons({ icons });
    }

    goToPage(page) {
        if (!page) return;
        this.currentPage = page;
        this.fetchData();
        if (this.onPageChangeCallback) {
            this.onPageChangeCallback(page);
        }
    }
}
