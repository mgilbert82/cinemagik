<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    #[Route(path: '/categorie/{slug}', name: 'category_posts')]
    public function getCategoryPosts(Category $category, PostRepository $postRepository): Response
    {
        $categoryPosts = $postRepository->findByCategory($category);

        return $this->render('category/index.html.twig', [
            'posts' => $categoryPosts,
            'category' => $category
        ]);
    }

    #[Route(path: 'categories/', name: 'app_category')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();

        return $this->render('category/categoryList.html.twig', [
            'categories' => $categories,
        ]);
    }
}
