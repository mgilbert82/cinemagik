<?php

namespace App\Controller;

use App\Entity\Source;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SourceController extends AbstractController
{
    #[Route('/plateforme/{slug}', name: 'source_posts')]
    public function sourcePosts(Source $source, EntityManagerInterface $entityManager): Response
    {
        $sourceId = $source->getId();

        $source = $entityManager->getRepository(Source::class)->findOneBy(['id' => $sourceId]);

        $sourcePosts = $source->getPosts();

        return $this->render('source/index.html.twig', [
            'source' => $source,
            'posts' => $sourcePosts,
        ]);
    }
}
