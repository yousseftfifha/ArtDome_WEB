<?php

namespace App\Repository;

use App\Entity\Oeuvre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Oeuvre|null find($id, $lockMode = null, $lockVersion = null)
 * @method Oeuvre|null findOneBy(array $criteria, array $orderBy = null)
 * @method Oeuvre[]    findAll()
 * @method Oeuvre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class oeuvreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Oeuvre::class);
    }

    // /**
    //  * @return Oeuvre[] Returns an array of Oeuvre objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Oeuvre
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */


    /**
     * retourne le nombre de formations par jour
     *
     */
    public function CountByDate()
    {
        $query=$this->createQueryBuilder('a')
            ->select('SUBSTRING(a.dateoeuvre,1,10) as dateOeuvres, COUNT(a) as count')
            ->groupBy('dateOeuvres')
        ;
        return $query->getQuery()->getResult();


    }
    public function ajax($name)
    {
        return $this->createQueryBuilder('f')
            ->where('f.nomoeuvre LIKE :nom')
            ->setParameter('nom','%'.$name.'%')
            ->getQuery()
            ->getResult();
    }
}
