<?php

namespace App\Controller;

use App\Entity\Actor;
use App\Repository\ActorRepository;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ActorController extends AbstractController
{
    #[Route(path: '/acteur/{slug}', name: 'actor_posts')]
    public function getActorPosts(Actor $actor, PostRepository $postRepository): Response
    {
        $actorPosts = $postRepository->findByActor($actor);

        return $this->render('actor/index.html.twig', [
            'actor' => $actor,
            'posts' => $actorPosts,
        ]);
    }

    #[Route(path: 'acteurs/', name: 'app_actor')]
    public function getActorsName(ActorRepository $actorRepo)
    {

        $actors = $actorRepo->findAll();

        return $this->render('actor/actorList.html.twig', [
            'actors' => $actors,
        ]);
    }
}
