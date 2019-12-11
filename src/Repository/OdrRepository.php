<?php

namespace App\Repository;

use App\Entity\Odr;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Odr|null find($id, $lockMode = null, $lockVersion = null)
 * @method Odr|null findOneBy(array $criteria, array $orderBy = null)
 * @method Odr[]    findAll()
 * @method Odr[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OdrRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Odr::class);
    }

    // /**
    //  * @return Odr[] Returns an array of Odr objects
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
    public function findOneBySomeField($value): ?Odr
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
