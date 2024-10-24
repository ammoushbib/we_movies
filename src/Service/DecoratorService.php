<?php

namespace App\Controller;

use App\Constant\TMDBConstant;
use App\Service\MovieService;

class DecoratorService
{
    private MovieService $movieService;

    public function __construct(MovieService $movieService)
    {
        $this->movieService = $movieService;
    }

    public function homeDecorator(array $data): array
    {
        $currentPage = $data['page'];
        $genreId = $data['genre_id'];
        $genres = $this->movieService->getGenres();
        $moviesResult = $genreId ? $this->movieService->getMoviesByGenre($genreId, $currentPage) : $this->movieService->getPopularMovies($currentPage);

        $movies = $moviesResult['results'];
        $totalPages = ($moviesResult['total_pages'] > 500) ? 500 : $moviesResult['total_pages'];

        $bestRatedMovie = array_shift($movies);

        $bestRatedMovieTrailer = $this->getTrailer($bestRatedMovie['id']);

        return [
            'genres' => $genres['genres'],
            'movies' => $movies,
            'best_rated_movie' => $bestRatedMovie,
            'best_rated_movie_trailer' => $bestRatedMovieTrailer,
            'current_page' => $currentPage,
            'total_pages' => $totalPages,
            'genre_id' => $genreId,
        ];
    }
    public function getTrailer(int $movieId): array
    {
        $bestRatedMovieVideos = $this->movieService->getMovieVideos($movieId);

        $bestRatedMovieTrailer = array_filter($bestRatedMovieVideos['results'], function($video) {
            return $video['type'] === 'Trailer';
        });

        $bestRatedMovieTrailer = reset($bestRatedMovieTrailer);
        if ($bestRatedMovieTrailer) {
            $bestRatedMovieTrailer['url'] = TMDBConstant::YOUTUBE_EMBED_URL . $bestRatedMovieTrailer['key'];
        }

        return $bestRatedMovieTrailer;
    }

    public function generateImageUrl(?string $imagePath): string
    {

        return TMDBConstant::TMDB_POSTER_URL . $imagePath;
    }
}