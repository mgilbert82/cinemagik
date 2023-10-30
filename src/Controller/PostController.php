<?php

namespace App\Controller;

use App\Entity\Director;
use App\Entity\Post;
use App\Entity\Source;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    #[Route('/post/{slug}', name: 'post_detail')]
    public function index(?Post $post): Response
    {
        if (!$post) {
            return $this->redirectToRoute('app_home');
        }

        return $this->render('post/postDetail.html.twig', [
            'post' => $post,
        ]);
    }
}
