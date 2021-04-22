<?php


namespace App\Repository;

use App\Entity\Blog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Blog|null find($id, $lockMode = null, $lockVersion = null)
 * @method Blog|null findOneBy(array $criteria, array $orderBy = null)
 * @method Blog[]    findAll()
 * @method Blog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BlogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Blog::class);
    }

    /**
     * @param int $page
     * @param int $limit
     * @return Paginator
     */
    public function getPaginatedBlogs(int $page, int $limit): Paginator
    {
        return new Paginator( $this->createQueryBuilder("p")
            ->addSelect("c")
            ->join("p.commentaires", "c")
            ->setMaxResults($limit)
            ->setFirstResult(($page - 1) * $limit)
        );
    }
}