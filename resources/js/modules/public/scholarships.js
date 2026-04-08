const container = document.querySelector('#grid_scholarships');

if (container) {
    const prevBtn = document.querySelector('#prevBtn');
    const nextBtn = document.querySelector('#nextBtn');

    let url = null;
    let currentPage = 1;

    function getUrl(page = 1) {
        url = '/public/scholarships/list/?page=' + page;
    }

    prevBtn.addEventListener('click', () => {
        currentPage++;
    });

    getUrl(1);

    const response = await fetch(url, {
        headers: {
            'Accept': 'application/json',
        }
    });

    if (!response.ok) {
        throw new 'Error fetching data';
    }

    const resolve = await response.json();

    displayData(resolve.data);

    console.log(resolve);

    function displayData(data) {
        data.forEach(result => {
            const col = document.createElement('div');
            const card = document.createElement('div');
            const cardBody = document.createElement('div');
            col.classList.add('col-12', 'col-md-6', 'col-xl-4');
            card.classList.add('card');
            cardBody.classList.add('card-body');

            container.appendChild(col);
            col.appendChild(card);
            card.appendChild(cardBody);

            cardBody.innerHTML = `<p>${result.name}</p>`;
        });
    }

}