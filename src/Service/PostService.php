<?php

namespace App\Service;

use App\Entity\Category;
use App\Repository\PostRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class PostService
{

    public function __construct(
        private RequestStack $requestStack,
        private PostRepository $postRepository,
        private PaginatorInterface $paginator,
    ) {
    }

    public function getPaginatedPosts(?Category $category = null): PaginationInterface
    {
        $request = $this->requestStack->getMainRequest();
        $page = $request->query->getInt('page', 1);

        $postsQuery = $this->postRepository->findForPagination($category);

        return $this->paginator->paginate($postsQuery, $page, 6);
    }
}
