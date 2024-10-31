<?php

namespace App\Tests\Service;

use App\Service\MovieService;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class MovieServiceTest extends TestCase
{
    private $httpClient;
    private $movieService;

    protected function setUp(): void
    {
        $this->httpClient = $this->createMock(HttpClientInterface::class);
        $this->movieService = new MovieService($this->httpClient, 'fake_api_key');
    }

    public function testGetPopularMovies()
    {
        $response = $this->createMock(ResponseInterface::class);
        $response->method('toArray')->willReturn(['results' => []]);

        $this->httpClient->method('request')->willReturn($response);

        $result = $this->movieService->getPopularMovies(1);
        $this->assertIsArray($result);
    }

    public function testGetMovieDetails()
    {
        $response = $this->createMock(ResponseInterface::class);
        $response->method('toArray')->willReturn(['id' => 1, 'title' => 'Test Movie']);

        $this->httpClient->method('request')->willReturn($response);

        $result = $this->movieService->getMovieDetails(1);
        $this->assertIsArray($result);
        $this->assertEquals(1, $result['id']);
    }

    public function testGetGenres()
    {
        $response = $this->createMock(ResponseInterface::class);
        $response->method('toArray')->willReturn(['genres' => []]);

        $this->httpClient->method('request')->willReturn($response);

        $result = $this->movieService->getGenres();
        $this->assertIsArray($result);
    }

    public function testSearchMovies()
    {
        $response = $this->createMock(ResponseInterface::class);
        $response->method('toArray')->willReturn(['results' => [['id' => 1, 'title' => 'Test Movie']]]);

        $this->httpClient->method('request')->willReturn($response);

        $result = $this->movieService->searchMovies('Test');
        $this->assertIsArray($result);
        $this->assertCount(1, $result);
    }

    public function testGetMovieVideos()
    {
        $response = $this->createMock(ResponseInterface::class);
        $response->method('toArray')->willReturn(['results' => []]);

        $this->httpClient->method('request')->willReturn($response);

        $result = $this->movieService->getMovieVideos(1);
        $this->assertIsArray($result);
    }

    public function testGetMoviesByGenre()
    {
        $response = $this->createMock(ResponseInterface::class);
        $response->method('toArray')->willReturn(['results' => []]);

        $this->httpClient->method('request')->willReturn($response);

        $result = $this->movieService->getMoviesByGenre(1, 1);
        $this->assertIsArray($result);
    }
}