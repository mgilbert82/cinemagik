<?php

namespace App\Repository;

use App\Entity\Actor;
use App\Entity\Category;
use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Post>
 *
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    public function getPostBySource($slug): array
    {
        $query = $this->createQueryBuilder('p')
            ->leftJoin('p.source', 's')
            ->where('s.slug = :slug')
            ->setParameter('slug', $slug)
            ->getQuery();

        return $query->getResult();
    }

    public function findByActor(Actor $actor)
    {
        return $this->createQueryBuilder('p')
            ->join('p.actors', 'a')
            ->where('a = :actor')
            ->setParameter('actor', $actor)
            ->getQuery()
            ->getResult();
    }

    public function findPostsWithRateGreaterThanSeven()
    {
        return $this->createQueryBuilder('p')
            ->Where('p.rate > 7')
            ->getQuery()
            ->getResult();
    }

    public function findForPagination(?Category $category  = null): Query
    {
        $queryBuilder = $this->createQueryBuilder('p')
            ->orderBy('p.createdAt', 'DESC');

        if ($category) {
            $queryBuilder->leftJoin('p.categories', 'c')
                ->where($queryBuilder->expr()->eq('c.id', ':categoryId'))
                ->setParameter('categoryId', $category->getId());
        }
        return $queryBuilder->getQuery();
    }

    //    /**
    //     * @return Post[] Returns an array of Post objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Post
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
