<?php

namespace App\Repository;

use App\Entity\PendingOrders;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PendingOrders|null find($id, $lockMode = null, $lockVersion = null)
 * @method PendingOrders|null findOneBy(array $criteria, array $orderBy = null)
 * @method PendingOrders[]    findAll()
 * @method PendingOrders[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PendingOrdersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PendingOrders::class);
    }

    // /**
    //  * @return PendingOrders[] Returns an array of PendingOrders objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PendingOrders
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
