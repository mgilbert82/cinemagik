<?php

namespace App\Controller;

use App\Entity\Director;
use App\Repository\DirectorRepository;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DirectorController extends AbstractController
{
    #[Route('/realisateur/{slug}', name: 'director_posts')]
    public function directorPosts(Director $director, PostRepository $postRepository): Response
    {
        $directorPosts = $postRepository->findByDirector($director);

        return $this->render('director/index.html.twig', [
            'director' => $director,
            'posts' => $directorPosts,
        ]);
    }

    #[Route('/realisateurs', name: 'app_director')]
    public function getDirectorsName(DirectorRepository $directorRepo)
    {

        $directors = $directorRepo->findAll();

        return $this->render('director/directorList.html.twig', [
            'directors' => $directors,
        ]);
    }
}
