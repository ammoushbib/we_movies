document.getElementById('search-input').addEventListener('input', function() {
    const query = this.value;
    const clearButton = document.getElementById('clear-search');
    if (query.length > 2) {
        fetch(`/search?query=${query}`)
            .then(response => response.json())
            .then(data => {
                const results = document.getElementById('search-results');
                results.innerHTML = '';
                data.forEach(movie => {
                    const li = document.createElement('li');
                    li.textContent = movie.title;
                    li.dataset.movieId = movie.id;
                    li.addEventListener('click', function() {
                        fetch(`/movies/${this.dataset.movieId}`)
                            .then(response => response.json())
                            .then(movieDetails => {
                                const modal = document.getElementById('movie-modal');
                                const details = document.getElementById('movie-details');
                                details.innerHTML = `
                                        <h2>${movieDetails.title}</h2>
                                        <img src="{{ image_url('${movieDetails.poster_path}') }}" alt="${movieDetails.title}">
                                        <p>${movieDetails.overview}</p>
                                    `;
                                modal.style.display = 'block';
                            });
                    });
                    results.appendChild(li);
                });
            });
        clearButton.style.display = 'inline';
    } else {
        clearButton.style.display = 'none';
    }
});

document.getElementById('clear-search').addEventListener('click', function() {
    const searchInput = document.getElementById('search-input');
    searchInput.value = '';
    document.getElementById('search-results').innerHTML = '';
    this.style.display = 'none';
});