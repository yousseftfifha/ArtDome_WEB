<?php

namespace App\Repository;

use App\Entity\ExpoOeuvre;
use App\Entity\Exposition;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ExpoOeuvre|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExpoOeuvre|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExpoOeuvre[]    findAll()
 * @method ExpoOeuvre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExpoOeuvreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExpoOeuvre::class);
    }




  /*  public function SortExpo()
    {
        return $this->createQueryBuilder('e')
            ->orderBy('e.dateExpo', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }*/

    public function getavecOeuvres($code)
    {
        return  $this->createQueryBuilder('a')
         ->join('a.codeExpo', 'c')
        /*$qb ->join('a.codeOeuvre', 'o')*/
            ->addSelect('c')
            ->where('c.codeExpo = :code')
            ->setParameter('code',$code)

        ->getQuery()
            ->getResult();
    }
    // /**
    //  * @return Exposition[] Returns an array of Exposition objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Exposition
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

  /*  public function findexpoByCode($codeExpo){
        return $this->createQueryBuilder('r')
            ->where('r.codeExpo  LIKE :codeExpo')
            ->setParameter('codeExpo', '%'.$codeExpo.'%')
            ->getQuery()
            ->getResult();
    }*/
}
