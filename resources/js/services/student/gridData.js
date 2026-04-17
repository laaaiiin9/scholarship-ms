import { createIcons, icons } from 'lucide';

export default class GridDataService {
    constructor({ containerId, paginationContainerId, searchInputId, endpoint, renderCard, onPageChangeCallback }) {
        this.container = document.getElementById(containerId);
        this.paginationContainer = document.getElementById(paginationContainerId);
        this.searchInput = document.getElementById(searchInputId);
        this.endpoint = endpoint;
        this.renderCard = renderCard;
        this.onPageChangeCallback = onPageChangeCallback;
        
        this.currentPage = 1;
        this.searchQuery = '';
        this.searchTimeout = null;
        this.extraParams = {};

        this.init();
    }

    init() {
        if (!this.container) return;

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
        if (!this.container) return;
        this.container.innerHTML = `<div class="col-12 text-center py-5 text-muted"><span class="spinner-border text-eskoylar-primary me-2" role="status" aria-hidden="true"></span><h5 class="mt-3">Loading scholarships...</h5></div>`;

        try {
            const url = new URL(this.endpoint, window.location.origin);
            url.searchParams.append('page', this.currentPage);
            url.searchParams.append('search', this.searchQuery);
            
            Object.keys(this.extraParams).forEach(key => {
                if (this.extraParams[key] !== '') {
                    url.searchParams.append(key, this.extraParams[key]);
                }
            });

            const response = await fetch(url.toString(), {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            
            if (!response.ok) throw new Error('Network response was not ok');
            
            const paginator = await response.json();
            this.renderGrid(paginator.data);
            if (this.paginationContainer) {
                this.renderPagination(paginator);
            }
        } catch (error) {
            console.error('Error fetching data:', error);
            this.container.innerHTML = `<div class="col-12 text-center text-danger py-5"><i data-lucide="alert-circle" style="width:48px;height:48px;"></i><h5 class="mt-3">Failed to load scholarships.</h5></div>`;
            createIcons({ icons });
            if (this.paginationContainer) this.paginationContainer.innerHTML = '';
        }
    }

    renderGrid(data) {
        if (data.length === 0) {
            this.container.innerHTML = `<div class="col-12 text-center py-5 text-muted"><div class="mx-auto mb-3 text-secondary"><i data-lucide="inbox" style="width:40px;height:40px;"></i></div><h5>No scholarships found.</h5><p>Try adjusting your search criteria.</p></div>`;
            createIcons({ icons });
            return;
        }

        let html = '';
        data.forEach(item => {
            html += this.renderCard(item);
        });
        
        this.container.innerHTML = html;
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
            if (label.includes('&laquo;')) label = '<i data-lucide="chevron-left" style="width: 16px;"></i>';
            else if (label.includes('&raquo;')) label = '<i data-lucide="chevron-right" style="width: 16px;"></i>';

            let pageNum = 'null';
            if (link.url) {
                const urlObj = new URL(link.url, window.location.origin);
                pageNum = urlObj.searchParams.get('page');
            }

            linksHtml += `
                <li class="page-item ${activeClass} ${disabledClass}">
                    <a class="page-link border-0 ${link.active ? 'rounded bg-primary text-white' : 'text-muted'}" 
                       href="#" 
                       ${link.url === null ? 'tabindex="-1" aria-disabled="true"' : `data-page="${pageNum}"`}>
                       ${label}
                    </a>
                </li>
            `;
        });

        this.paginationContainer.innerHTML = `
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 w-100">
                <span class="text-muted" style="font-size: 0.85rem;">Showing <span class="fw-bold text-body">${from}</span> to <span class="fw-bold text-body">${to}</span> of <span class="fw-bold text-body">${total}</span> programs</span>
                <nav aria-label="Pagination">
                    <ul class="pagination mb-0 gap-1">
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
