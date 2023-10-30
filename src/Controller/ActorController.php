<?php

namespace App\Controller;

use App\Entity\Actor;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ActorController extends AbstractController
{
    #[Route('/acteur/{slug}', name: 'actor_posts')]
    public function actorPosts(Actor $actor, PostRepository $postRepository): Response
    {
        if ($actor === null) {
            throw $this->createNotFoundException('Actor not found');
        }

        $actorPosts = $postRepository->findByActors($actor);

        return $this->render('actor/index.html.twig', [
            'actor' => $actor,
            'posts' => $actorPosts,
        ]);
    }
}
