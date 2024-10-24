var modalCreator = function() {
    fetch(`/movies/${this.dataset.movieId}`)
        .then(response => response.json())
        .then(movieDetails => {
            const modal = document.getElementById('movie-modal');
            const trailer = document.getElementById('modal-trailer');
            const title = document.getElementById('modal-title');
            const ratingContainer = document.getElementById('modal-rating');
            ratingContainer.innerHTML = '';
            const voteAverage = movieDetails.movie.vote_average;

            title.textContent = movieDetails.movie.title;
            trailer.src = movieDetails.trailer;


            for (let i = 1; i <= 5; i++) {
                const star = document.createElement('span');
                star.classList.add('star');
                if (i <= Math.round(voteAverage / 2)) {
                    star.classList.add('filled');
                    star.innerHTML = '&#9733;';
                } else {
                    star.innerHTML = '&#9734;';
                }
                ratingContainer.appendChild(star);
            }

            ratingContainer.innerHTML += "<b> ( " + movieDetails.movie.vote_count + " Votes )</b>";

            modal.style.display = 'block';
        });
}
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
                    li.addEventListener('click', modalCreator);
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