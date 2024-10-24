<?php

namespace App\Service;

use App\Constant\TMDBConstant;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class MovieService
{
    private HttpClientInterface $client;
    private string $apiKey;

    public function __construct(HttpClientInterface $client, string $apiKey)
    {
        $this->client = $client;
        $this->apiKey = $apiKey;
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function getPopularMovies(int $page): array
    {
        $response = $this->client->request('GET', TMDBConstant::TMDB_HOST . TMDBConstant::TMDB_POPULAR_ENDPOINT, [
            'query' => [
                'api_key' => $this->apiKey,
                'page' => $page
            ],
        ]);

        return $response->toArray();
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function getMovieDetails(int $movieId): array
    {
        $response = $this->client->request('GET', TMDBConstant::TMDB_HOST . TMDBConstant::TMDB_MOVIE_DETAIL_ENDPOINT . $movieId, [
            'query' => [
                'api_key' => $this->apiKey,
            ],
        ]);

        return $response->toArray();
    }

    public function getGenres(): array
    {
        $response = $this->client->request('GET', TMDBConstant::TMDB_HOST . TMDBConstant::TMDB_GENRE_LIST_ENDPOINT, [
            'query' => [
                'api_key' => $this->apiKey,
            ],
        ]);

        return $response->toArray();
    }

    public function searchMovies(string $query): array
    {
        $response = $this->client->request('GET', TMDBConstant::TMDB_HOST . TMDBConstant::TMDB_MOVIE_SEARCH_ENDPOINT, [
            'query' => [
                'api_key' => $this->apiKey,
                'query' => $query,
            ],
        ]);
        $results = $response->toArray()['results'];

        return array_slice($results, 0, 5);
    }

    public function getMovieVideos(int $movieId): array
    {
        $response = $this->client->request('GET', TMDBConstant::TMDB_HOST . "/movie/{$movieId}/videos", [
            'query' => [
                'api_key' => $this->apiKey,
            ],
        ]);

        return $response->toArray();
    }

    public function getMoviesByGenre(int $genreId, int $page): array
    {
        $response = $this->client->request('GET', TMDBConstant::TMDB_HOST . TMDBConstant::TMDB_MOVIE_PER_GENRE, [
            'query' => [
                'api_key' => $this->apiKey,
                'with_genres' => $genreId,
                'page' => $page
            ],
        ]);

        return $response->toArray();
    }

}