<?php

namespace App\Repository;

use App\Entity\Rib;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Rib|null find($id, $lockMode = null, $lockVersion = null)
 * @method Rib|null findOneBy(array $criteria, array $orderBy = null)
 * @method Rib[]    findAll()
 * @method Rib[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RibRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Rib::class);
    }

    // /**
    //  * @return Rib[] Returns an array of Rib objects
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
    public function findOneBySomeField($value): ?Rib
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
