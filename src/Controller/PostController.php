<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
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

    #[Route('/source/{slug}', name: 'post_source')]
    public function getPostBySource($slug, PostRepository $postRepository): Response
    {

        $sourcePosts = $postRepository->getPostBySource($slug);

        return $this->render('post/sourceList.html.twig', [
            'posts' => $sourcePosts,
            'source' => $slug
        ]);
    }
}
