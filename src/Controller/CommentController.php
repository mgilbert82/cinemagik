<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Repository\CommentRepository;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{
    #[Route('/ajax/comment', name: 'comment_add')]
    public function index(Request $request, PostRepository $postRepository, CommentRepository $commentRepository, EntityManagerInterface $em): Response
    {
        //Récupération des données du formulaire
        $commentData = $request->request->all('comment');

        //Vérification du token
        if (!$this->isCsrfTokenValid('commentTokenId', $commentData['_token'])) {
            return $this->json([
                'code' => 'INVALID_CSRF_TOKEN'
            ], Response::HTTP_BAD_REQUEST);
        }

        $post = $postRepository->findOneBy(['id' => $commentData['post']]);

        if (!$post) {
            return $this->json(['code' => 'POST_NOT_FOUND'], Response::HTTP_BAD_REQUEST);
        }
        $user = $this->getUser();
        if (!$user) {
            return $this->json(
                ['code' => 'USER_NON_AUTHENTICATED¨FULLY'],
                Response::HTTP_BAD_REQUEST
            );
        }

        //Création du commentaire
        $comment = new Comment($post);
        $comment->setMessage($commentData['message']);
        $comment->setAuthor($user);
        $comment->setCreatedAt(new \DateTime());

        //Persistance du commentaire et enregistrement en base de données
        $em->persist($comment);
        $em->flush();

        //Affichage du commentaire
        $html = $this->renderView('comment/showComment.html.twig', ['comment' => $comment]);

        return $this->json([
            'code' => 'COMMENT_ADDED_SUCCESSFULLY',
            'message' => $html,
            'numberOfComments' => $commentRepository->count(['post' => $post])
        ]);
    }
}
