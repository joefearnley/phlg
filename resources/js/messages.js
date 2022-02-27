
const searchForm = document.querySelector('#search-form');
const searchTeam = document.querySelector('#search-term');

if (searchForm !== null) {
    searchForm.addEventListener('submit', event => {
        event.preventDefault();

        if (searchTeam.value.trim() !== '') {
            window.location = `/messages/search/${searchTeam.value}`;
        }
    });
}
