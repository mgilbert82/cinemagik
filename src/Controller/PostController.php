<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Post;
use App\Form\Type\CommentType;
use App\Repository\PostRepository;
use App\Service\CommentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    #[Route(path: '/article/{slug}', name: 'post_detail')]
    public function index(?Post $post, CommentService $commentService): Response
    {
        if (!$post) {
            return $this->redirectToRoute('app_home');
        }

        $comment = new Comment($post);
        $commentForm = $this->createForm(CommentType::class, $comment);


        return $this->render('post/postDetail.html.twig', [
            'post' => $post,
            'comments' => $commentService->getPaginatedComments($post),
            'commentForm' => $commentForm
        ]);
    }

    #[Route(path: '/noscoupsdecoeur', name: 'post_bestRate')]
    public function getPostsWithRateGreaterThanSeven(PostRepository $postRepository): Response
    {

        $posts = $postRepository->findPostsWithRateGreaterThanSeven();

        return $this->render('bestPosts/mostLikePost.html.twig', [
            'posts' => $posts,
        ]);
    }
}
