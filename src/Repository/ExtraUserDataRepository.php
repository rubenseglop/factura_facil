<?php

namespace App\Repository;

use App\Entity\ExtraUserData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ExtraUserData|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExtraUserData|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExtraUserData[]    findAll()
 * @method ExtraUserData[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExtraUserDataRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExtraUserData::class);
    }

    // /**
    //  * @return ExtraUserData[] Returns an array of ExtraUserData objects
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
    public function findOneBySomeField($value): ?ExtraUserData
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
