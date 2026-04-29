import { createIcons, icons } from 'lucide';

document.addEventListener('DOMContentLoaded', () => {
    const container = document.getElementById('public-scholarships-container');
    if (!container) return;

    fetchScholarships();

    async function fetchScholarships() {
        const isAuth = container.dataset.auth === 'true';
        const registerUrl = container.dataset.registerUrl;
        const studentUrl = container.dataset.studentUrl;
        const applyUrl = isAuth ? studentUrl : registerUrl;

        container.innerHTML = `
            <div class="col-12 text-center py-5">
                <div class="spinner-border text-eskoylar-primary mb-3" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="text-secondary">Discovering opportunities for you...</p>
            </div>
        `;

        try {
            const response = await fetch('/api/public/scholarships');
            const scholarships = await response.json();

            if (scholarships.length === 0) {
                container.innerHTML = `
                    <div class="col-12 text-center py-5">
                        <div class="text-muted mb-3">
                            <i data-lucide="search-x" style="width: 48px; height: 48px;"></i>
                        </div>
                        <h5>No scholarships available at the moment.</h5>
                        <p class="text-secondary small">Please check back later or contact support.</p>
                    </div>
                `;
            } else {
                container.innerHTML = scholarships.map(scholarship => `
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 glass-card border-0 shadow-sm overflow-hidden transition-all hover-translate-y">
                            <div class="card-body p-4 d-flex flex-column">
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <div class="avatar-circle bg-eskoylar-primary bg-opacity-10 text-eskoylar-primary">
                                        <i data-lucide="award" style="width: 24px;"></i>
                                    </div>
                                    <h5 class="card-title fw-bold mb-0">${scholarship.name}</h5>
                                </div>
                                
                                <p class="text-secondary small mb-4 flex-grow-1">
                                    ${scholarship.description ? (scholarship.description.length > 120 ? scholarship.description.substring(0, 120) + '...' : scholarship.description) : 'No description available.'}
                                </p>

                                <div class="pt-3 border-top border-secondary border-opacity-10 d-flex justify-content-between align-items-center mt-auto">
                                    <div class="text-xs text-muted">
                                        <i data-lucide="calendar" style="width:12px;" class="me-1"></i> Open for Applications
                                    </div>
                                    <a href="${applyUrl}" class="btn btn-eskoylar-primary btn-sm px-4 rounded-pill text-white fw-bold shadow-sm">
                                        Apply Now
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                `).join('');
            }

            createIcons({ icons });
        } catch (error) {
            console.error('Error fetching scholarships:', error);
            container.innerHTML = `
                <div class="col-12 text-center py-5">
                    <div class="text-danger mb-3">
                        <i data-lucide="alert-circle" style="width: 48px; height: 48px;"></i>
                    </div>
                    <h5>Oops! Something went wrong.</h5>
                    <p class="text-secondary small">Failed to load scholarships. Please try refreshing the page.</p>
                </div>
            `;
            createIcons({ icons });
        }
    }
});
