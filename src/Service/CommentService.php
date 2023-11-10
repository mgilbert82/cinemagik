<?php

namespace App\Service;

use App\Entity\Post;
use App\Repository\CommentRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class CommentService
{
    public function __construct(
        private RequestStack $requestStack,
        private CommentRepository $commentRepository,
        private PaginatorInterface $paginator
    ) {
    }

    public function getPaginatedComments(?Post $post = null, int $limit = 2): PaginationInterface
    {
        $page = $this->requestStack->getMainRequest()->query->getInt('page', 1);
        $postQuery = $this->commentRepository->findForPagination($post);

        return $this->paginator->paginate($postQuery, $page, $limit);
    }
}
