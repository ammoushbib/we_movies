# Movie Search Application

This project is a web application that allows users to search for movies, view details, and watch trailers. It uses The Movie Database (TMDb) API to fetch movie data.

## Technologies Used

- PHP 8.0 or higher
- Symfony 5.4
- JavaScript
- Twig
- Composer
- HTML/CSS

## Setup Instructions

1. Clone the repository:
    ```bash
    git clone https://github.com/ammoushbib/we_movies.git
    cd we_movies
    ```

2. Install dependencies:
    ```bash
    composer install
    ```

3. Set up environment variables:
    - Create a `.env.local` file in the root directory.
    - Add your TMDb API key:
        php bin/console secrets:set TMDB_API_KEY

4. Start the Symfony server:
    ```bash
    symfony server:start
    ```

## Running the Project

1. Open your web browser and navigate to `http://localhost:8000`.

## Usage Instructions

- Use the search bar to find movies by title.
- Click on a movie to view its details and watch the trailer.
- Browse popular and top-rated movies.
- Filter movies by genre.

## Additional Information

- This project uses The Movie Database (TMDb) API. You need to sign up for an API key at [TMDb](https://developer.themoviedb.org/docs/getting-started).

## Acknowledgments

- Thanks to [TMDb](https://www.themoviedb.org/) for providing the movie data API.