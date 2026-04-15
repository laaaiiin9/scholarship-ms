import { get } from '../../services/api';
import { createIcons, icons } from 'lucide';

const container = document.querySelector('#scholarship-container');
const searchBar = document.querySelector('#searchbar');
const prevBtn = document.querySelector('#prevBtn');
const nextBtn = document.querySelector('#nextBtn');
const pageText = document.querySelector('p');

let page = 1;
let search = '';
let lastResponse = null;

if (container) {
    function spinner() {
        const spinner = document.createElement('div');
        spinner.classList.add('d-flex', 'justify-content-center');
        spinner.innerHTML = `
        <div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    `;

        return spinner;
    }

    async function fetchData() {
        try {
            const url = `/scholarships/list?page=${page}&search=${search}`;

            container.innerHTML = '';
            container.appendChild(spinner());
            const response = await get(url);
            lastResponse = response;

            render(response.data);

            updatePagination(response);
        } catch (err) {
            console.error(err);
        }
    }

    function render(data) {

        if (data.length === 0) {
            const col = document.createElement('div');
            const card = document.createElement('div');
            const cardTitle = document.createElement('h3');
            const cardContent = document.createElement('div');

            col.classList.add('col-12');
            card.classList.add('feature-card', 'app-card', 'app-card--interactive', 'h-100');
            cardContent.classList.add('app-card-copy-soft');

            cardTitle.textContent = "No Data";
            cardContent.textContent = "";

            card.appendChild(cardTitle);
            card.appendChild(cardContent);
            col.appendChild(card);
            container.appendChild(col);
        }

        let html = '';

        data.forEach(result => {
            html += `
        <div class="col-12 col-md-6 col-lg-4">
                    <div class="feature-card app-card app-card--interactive h-100 g-0">

                        <div class="row justify-content-between align-items-center">
                            <div class="col-auto">
                                <div data-lucide="GraduationCap"></div>
                            </div>
                            <div class="col-auto">
                                <h5 class="m-0">$${result.max_amount}</h5>
                            </div>
                        </div>
                        
                        <h3 class="m-0">${result.name}</h3>
                        <div class="app-card-copy-soft">
                            ${result.description}
                        </div>

                        <div class="row">
                            <p><i data-lucide="Calendar1"></i> Deadline: Feb 9, 2026</p>
                            <p><i data-lucide="User"></i> Eligibility: SHS Graduate</p>
                        </div>

                        <div class="d-flex align-items-center">
                            <button class="btn btn-custom-primary text-white btn-cta">Apply Now</button>
                        </div>
                    </div>
                </div>
        `;
            // container.innerHTML += `

            // `;
        });

        container.innerHTML = html;
        createIcons({ icons });

        // data.forEach(result => {
        //     const col = document.createElement('div');
        //     const card = document.createElement('div');
        //     const cardTitle = document.createElement('h3');
        //     const cardContent = document.createElement('div');

        //     col.classList.add('col-12', 'col-md-6', 'col-xl-4');
        //     card.classList.add('feature-card', 'app-card', 'app-card--interactive', 'h-100');
        //     cardContent.classList.add('app-card-copy-soft');

        //     cardTitle.textContent = result.name;
        //     cardContent.textContent = result.description;

        //     card.appendChild(cardTitle);
        //     card.appendChild(cardContent);
        //     col.appendChild(card);
        //     container.appendChild(col);
        // });
    }

    function updatePagination(res) {
        pageText.textContent = `Page ${res.current_page} of ${res.last_page}`;

        prevBtn.disabled = res.current_page <= 1;
        nextBtn.disabled = res.current_page >= res.last_page;
    }

    prevBtn.addEventListener('click', () => {
        if (page > 1) {
            page--;
            fetchData();
        }
    });

    nextBtn.addEventListener('click', () => {
        if (lastResponse && page < lastResponse.last_page) {
            page++;
            fetchData();
        }
    });

    let timeout = null;

    searchBar.addEventListener('input', (e) => {
        clearTimeout(timeout);

        timeout = setTimeout(() => {
            search = e.target.value;
            page = 1;
            fetchData();
        }, 400);
    });

    fetchData();
}