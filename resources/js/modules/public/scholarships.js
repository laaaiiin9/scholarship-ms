import { get } from '../../services/api';

const container = document.querySelector('#scholarship-container');
const searchBar = document.querySelector('#searchbar');
const prevBtn = document.querySelector('#prevBtn');
const nextBtn = document.querySelector('#nextBtn');
const pageText = document.querySelector('p');

let page = 1;
let search = '';
let lastResponse = null;

async function fetchData() {
    try {
        const url = `/public/scholarships/list?page=${page}&search=${search}`;

        const response = await get(url);
        lastResponse = response;

        render(response.data);

        updatePagination(response);
    } catch (err) {
        console.error(err);
    }
}

function render(data) {
    container.innerHTML = ''; // IMPORTANT: prevent duplicates

    data.forEach(result => {
        const col = document.createElement('div');
        const card = document.createElement('div');
        const cardTitle = document.createElement('h3');
        const cardContent = document.createElement('div');

        col.classList.add('col-12', 'col-md-6', 'col-xl-4');
        card.classList.add('feature-card', 'app-card', 'app-card--interactive', 'h-100');
        cardContent.classList.add('app-card-copy-soft');

        cardTitle.textContent = result.name;
        cardContent.textContent = result.description;

        card.appendChild(cardTitle);
        card.appendChild(cardContent);
        col.appendChild(card);
        container.appendChild(col);
    });
}

function updatePagination(res) {
    pageText.textContent = `Page ${res.current_page} of ${res.last_page}`;

    prevBtn.disabled = res.current_page <= 1;
    nextBtn.disabled = res.current_page >= res.last_page;
}

// Pagination buttons
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

// Debounced search
let timeout = null;

searchBar.addEventListener('input', (e) => {
    clearTimeout(timeout);

    timeout = setTimeout(() => {
        search = e.target.value;
        page = 1; // reset page when searching
        fetchData();
    }, 400);
});

// Initial load
fetchData();