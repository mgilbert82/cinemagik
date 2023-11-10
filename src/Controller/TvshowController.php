<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TvshowController extends AbstractController
{
    #[Route('/series-tv', name: 'app_tvshow')]
    public function index(PostRepository $postRepo): Response
    {
        $tvShow = $postRepo->findBy(['type' => 'TVSHOW']);

        return $this->render('tvshow/tvshowList.html.twig', [
            'posts' => $tvShow,
        ]);
    }
}
