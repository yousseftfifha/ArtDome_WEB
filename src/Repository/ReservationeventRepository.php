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

    public function findReservationEventByName($codeReservation)
    {
        return $this->createQueryBuilder('reservationevent')
            ->where('reservationevent.codeReservation LIKE :codeReservation')
            ->setParameter('codeReservation', '%'.$codeReservation.'%')
            ->getQuery()
            ->getResult();
    }

    public function SortReservation()
    {
        return $this->createQueryBuilder('r')
            ->orderBy('r.codeReservation', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }

  /*  public function countByNbPlace(){
        // $query = $this->createQueryBuilder('a')
        //     ->select('SUBSTRING(a.created_at, 1, 10) as dateAnnonces, COUNT(a) as count')
        //     ->groupBy('dateAnnonces')
        // ;
        // return $query->getQuery()->getResult();
        $query = $this->getEntityManager()->createQuery("
            SELECT codeEvent as code, COUNT(a) as count FROM App\Entity\Reservationevent a GROUP BY code
        ");
        return $query->getResult();
    }*/

   /* public function findOneBySomeField($codeEvent): ?Reservationevent
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.codeEvent = :codeEvent')
            ->setParameter('codeEvent', $codeEvent)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }*/

    public function findByClient($codeClient)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.codeClient = :codeClient')
            ->setParameter('codeClient', $codeClient)
            ->orderBy('e.codeReservation', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }
}
