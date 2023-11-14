<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route(path: '/', name: 'app_home')]
    public function index(PostRepository $postRepo): Response
    {
        return $this->render('home/index.html.twig', [
            'posts' => $postRepo->findAll(),
        ]);
    }
}
