<?php

namespace App\Controller;

use App\Entity\Source;
use App\Repository\SourceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SourceController extends AbstractController
{
    #[Route('/svod/{slug}', name: 'source_posts')]
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

    #[Route('/svod', name: 'app_source')]
    public function getSourcesName(SourceRepository $sourceRepository): Response
    {

        $sources = $sourceRepository->findAll();

        return $this->render('source/dropdown.html.twig', [
            'sources' => $sources,
        ]);
    }
}
