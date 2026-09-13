
/* =========================
   Search Overlay
   ========================= */

const searchOverlay = document.getElementById('searchOverlay');
const searchBox = document.getElementById('searchBox');
const searchInput = document.getElementById('searchInput');
const searchSubmit = document.getElementById('searchSubmit');


/* Open search */

function toggleSearch() {

    searchOverlay.classList.add('open');

    setTimeout(() => {
        searchInput.focus();
    }, 700);
}


/* Close when clicking outside */

searchOverlay.addEventListener('click', (event) => {

    if (!searchBox.contains(event.target)) {
        searchOverlay.classList.remove('open');
    }

});


/* Close with Escape */

document.addEventListener('keydown', (event) => {

    if (event.key === 'Escape') {
        searchOverlay.classList.remove('open');
    }

});


/* =========================
   Perform Search
   ========================= */

function performSearch() {

    const query = searchInput.value.trim();

    if (query !== '') {

        window.location.href =
            '../../search.php?search=' + encodeURIComponent(query);

    }

}


/* Search button */

searchSubmit.addEventListener('click', (event) => {

    event.preventDefault();

    performSearch();

});


/* Search with Enter key */

searchInput.addEventListener('keydown', (event) => {

    if (event.key === 'Enter') {

        event.preventDefault();

        performSearch();

    }

});

