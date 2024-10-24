<?php

namespace App\Constant;

final class TMDBConstant
{
    const TMDB_HOST = 'https://api.themoviedb.org/3';
    const TMDB_POPULAR_ENDPOINT = '/movie/popular';
    const TMDB_MOVIE_DETAIL_ENDPOINT = "/movie/";
    const TMDB_GENRE_LIST_ENDPOINT = '/genre/movie/list';
    const TMDB_MOVIE_SEARCH_ENDPOINT = '/search/movie';
    const TMDB_MOVIE_PER_GENRE = '/discover/movie';
    /**
     * constant MAX PAGES due to limit in third party api to 500
     */
    const TMDB_MAX_PAGINATION = 500;
    const YOUTUBE_EMBED_URL = 'https://www.youtube.com/embed/';
    const TMDB_POSTER_URL = 'https://media.themoviedb.org/t/p/w220_and_h330_face';
}