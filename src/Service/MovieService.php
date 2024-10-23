<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class MovieService
{
    private HttpClientInterface $client;
    private $apiKey;

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
    public function getPopularMovies(): array
    {
        $response = $this->client->request('GET', 'https://api.themoviedb.org/3/movie/popular', [
            'query' => [
                'api_key' => $this->apiKey,
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
        $response = $this->client->request('GET', "https://api.themoviedb.org/3/movie/{$movieId}", [
            'query' => [
                'api_key' => $this->apiKey,
            ],
        ]);

        return $response->toArray();
    }

    public function getTopRatedMovies(): array
    {
        $response = $this->client->request('GET', 'https://api.themoviedb.org/3/movie/top_rated', [
            'query' => [
                'api_key' => $this->apiKey,
            ],
        ]);


        return $response->toArray();
    }


    public function getGenres(): array
    {
        $response = $this->client->request('GET', 'https://api.themoviedb.org/3/genre/movie/list', [
            'query' => [
                'api_key' => $this->apiKey,
            ],
        ]);


        return $response->toArray();
    }

    public function searchMovies(string $query): array
    {
        $response = $this->client->request('GET', 'https://api.themoviedb.org/3/search/movie', [
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
        $response = $this->client->request('GET', "https://api.themoviedb.org/3/movie/{$movieId}/videos", [
            'query' => [
                'api_key' => $this->apiKey,
            ],
        ]);


        return $response->toArray();
    }

}