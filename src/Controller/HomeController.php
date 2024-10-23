<?php

namespace App\Controller;

use App\Service\MovieService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    public function __construct(private MovieService $movieService)
    {
        $this->movieService = $movieService;
    }
    #[Route('/', name: 'app_home')]
    public function index(Request $request): Response
    {
        $genres = $this->movieService->getGenres();
        $genreId = $request->get('genre_id');
        $movies = $genreId ? $this->movieService->getMoviesByGenre($genreId)['results'] : $this->movieService->getPopularMovies()['results'];

        $bestRatedMovie = array_shift($movies);


        return $this->render('home/index.html.twig', [
            'genres' => $genres['genres'],
            'movies' => $movies,
            'best_rated_movie' => $bestRatedMovie
        ]);
    }

    #[Route('/search', name: 'search_movies')]
    public function search(Request $request): JsonResponse
    {
        $query = $request->query->get('query');
        $movies = $this->movieService->searchMovies($query);

        return new JsonResponse($movies);
    }
}
