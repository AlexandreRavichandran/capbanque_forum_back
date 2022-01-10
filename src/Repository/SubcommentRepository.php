<?php

namespace App\Repository;

use App\Entity\Subcomment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Subcomment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Subcomment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Subcomment[]    findAll()
 * @method Subcomment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SubcommentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Subcomment::class);
    }

    // /**
    //  * @return Subcomment[] Returns an array of Subcomment objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Subcomment
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
