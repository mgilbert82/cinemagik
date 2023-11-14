<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MoviesController extends AbstractController
{
    #[Route(path: '/films', name: 'app_movies')]
    public function index(PostRepository $postRepo): Response
    {

        $movies = $postRepo->findBy(['type' => 'MOVIE']);

        return $this->render('movies/movieList.html.twig', [
            'posts' => $movies
        ]);
    }
}
