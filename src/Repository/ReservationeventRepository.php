<?php

namespace App\Repository;

use App\Entity\Reservationevent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Reservationevent|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reservationevent|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reservationevent[]    findAll()
 * @method Reservationevent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReservationeventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reservationevent::class);
    }

    // /**
    //  * @return Reservationevent[] Returns an array of Reservationevent objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Reservationevent
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
