/**
 * Handle client-side items filtering.
 * Get all .item elements and remove based on search term.
*/

const items = document.getElementsByClassName('item');
const normalize = str => str.toUpperCase().normalize('NFD').replace(/\p{Diacritic}/gu, "");

const filterItems = term => {
    const upper_term = normalize(term);
    for (let i = 0; i < items.length; i++) {
        const item = items[i];
        const name = normalize(item.dataset.name);
        if (name.indexOf(upper_term) > -1) {
            item.classList.remove('is-hidden');
        } else {
            item.classList.add('is-hidden');
        }
    }
}

document.getElementById('search').addEventListener('keyup', e => filterItems(e.target.value));
