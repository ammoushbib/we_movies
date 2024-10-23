<?php

namespace App\Controller;

use App\Service\MovieService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MovieController extends AbstractController
{
    public function __construct(MovieService $movieService)
    {
        $this->movieService = $movieService;
    }

    #[Route('/movie', name: 'app_movie')]
    public function index(): Response
    {
        $movies = $this->movieService->getPopularMovies();

        return $this->render('movie/index.html.twig', [
            'movies' => $movies['results'],
        ]);
    }


    #[Route('/movie/{id}', name: 'movie_plays')]
    public function play(int $id): Response
    {
        $movie = $this->movieService->getMovieDetails($id);
        $videos = $this->movieService->getMovieVideos($id);

        $trailer = array_filter($videos['results'], function($video) {
            return $video['type'] === 'Trailer';
        });

        $trailer = reset($trailer);
        if ($trailer) {
            $trailer['url'] = 'https://www.youtube.com/embed/' . $trailer['key'];
        }

        return $this->render('movie/play.html.twig', [
            'movie' => $movie,
            'trailer' => $trailer
        ]);
    }
    #[Route('/movies/{id}', name: 'movie_play')]
    public function plays(int $id): Response
    {
        $movie = $this->movieService->getMovieDetails($id);

        return new JsonResponse($movie);
    }
}
