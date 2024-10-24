<?php

namespace App\Tests\Service;

use App\Service\DecoratorService;
use App\Service\MovieService;
use PHPUnit\Framework\TestCase;

class DecoratorServiceTest extends TestCase
{
    private $movieService;
    private $decoratorService;

    protected function setUp(): void
    {
        $this->movieService = $this->createMock(MovieService::class);
        $this->decoratorService = new DecoratorService($this->movieService);
    }

    public function testHomeDecorator()
    {
        $data = [
            'page' => 1,
            'genre_id' => null
        ];

        $this->movieService->method('getGenres')->willReturn(['genres' => []]);
        $this->movieService->method('getPopularMovies')->willReturn([
            'results' => [['id' => 1, 'title' => 'Test Movie']],
            'total_pages' => 1
        ]);
        $this->movieService->method('getMovieVideos')->willReturn([
            'results' => [['type' => 'Trailer', 'key' => 'test_key']]
        ]);

        $result = $this->decoratorService->homeDecorator($data);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('genres', $result);
        $this->assertArrayHasKey('movies', $result);
        $this->assertArrayHasKey('best_rated_movie', $result);
        $this->assertArrayHasKey('best_rated_movie_trailer', $result);
        $this->assertArrayHasKey('current_page', $result);
        $this->assertArrayHasKey('total_pages', $result);
        $this->assertArrayHasKey('genre_id', $result);
    }

    public function testGetTrailer()
    {
        $movieId = 1;

        $this->movieService->method('getMovieVideos')->willReturn([
            'results' => [['type' => 'Trailer', 'key' => 'test_key']]
        ]);

        $result = $this->decoratorService->getTrailer($movieId);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('type', $result);
        $this->assertArrayHasKey('key', $result);
        $this->assertArrayHasKey('url', $result);
    }

    public function testGenerateImageUrl()
    {
        $imagePath = 'test_path.jpg';

        $result = $this->decoratorService->generateImageUrl($imagePath);

        $this->assertIsString($result);
        $this->assertStringContainsString($imagePath, $result);
    }
}