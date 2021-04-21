<?php

namespace App\Repository;

use App\Entity\Exposition;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Exposition|null find($id, $lockMode = null, $lockVersion = null)
 * @method Exposition|null findOneBy(array $criteria, array $orderBy = null)
 * @method Exposition[]    findAll()
 * @method Exposition[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExpositionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Exposition::class);
    }

    public function SortExpo()
    {
        return $this->createQueryBuilder('e')
            ->orderBy('e.dateExpo', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function getavecOeuvres($code)
    {
        $qb = $this->createQueryBuilder('a');
        $qb ->join('a.codeExposition', 'c')
            ->addSelect('c')
            ->where('c.codeExpo = :code')
            ->setParameter('code',$code);

        return $qb->getQuery()
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

    public function findexpoByCode($codeExpo){
        return $this->createQueryBuilder('r')
            ->where('r.codeExpo  LIKE :codeExpo')
            ->setParameter('codeExpo', '%'.$codeExpo.'%')
            ->getQuery()
            ->getResult();
    }
}
