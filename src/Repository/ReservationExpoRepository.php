<?php

namespace App\Repository;

use App\Entity\ReservationExpo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ReservationExpo|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReservationExpo|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReservationExpo[]    findAll()
 * @method ReservationExpo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReservationExpoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReservationExpo::class);
    }



    // /**
    //  * @return ReservationExpo[] Returns an array of ReservationExpo objects
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
    public function findOneBySomeField($value): ?ReservationExpo
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findreservationByCode($codeReservatione){
        return $this->createQueryBuilder('r')
            ->where('r.codeReservatione  LIKE :codeReservatione')
            ->setParameter('codeReservatione', '%'.$codeReservatione.'%')
            ->getQuery()
            ->getResult();
    }

}
