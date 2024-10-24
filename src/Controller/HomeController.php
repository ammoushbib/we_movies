<?php

namespace App\Controller;

use App\Constant\TMDBConstant;
use App\Service\DecoratorService;
use App\Service\MovieService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    public function __construct(private MovieService $movieService, DecoratorService $decoratorService)
    {
        $this->movieService = $movieService;
        $this->decoratorService = $decoratorService;
    }
    #[Route('/', name: 'app_home')]
    public function index(Request $request): Response
    {
        $data = [
            'page' => $request->query->getInt('page', 1),
            'genre_id' => $request->get('genre_id')
        ];

        $data = $this->decoratorService->homeDecorator($data);

        return $this->render('home/index.html.twig', $data);

    }

    #[Route('/search', name: 'search_movies')]
    public function search(Request $request): JsonResponse
    {
        $query = $request->query->get('query');
        $movies = $this->movieService->searchMovies($query);

        return new JsonResponse($movies);
    }

    #[Route('/movies/{id}', name: 'movie_play')]
    public function plays(int $id): Response
    {
        $movie = $this->movieService->getMovieDetails($id);
        $trailer = $this->decoratorService->getTrailer($id);
        $movie['full_poster_url'] = $this->decoratorService->generateImageUrl($movie['poster_path']);

        return new JsonResponse([
            'movie' => $movie,
            'trailer' => $trailer ? TMDBConstant::YOUTUBE_EMBED_URL . $trailer['key'] : null
        ]);
    }
}
