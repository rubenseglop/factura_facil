<?php

namespace App\Repository;

use App\Entity\BillLine;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method BillLine|null find($id, $lockMode = null, $lockVersion = null)
 * @method BillLine|null findOneBy(array $criteria, array $orderBy = null)
 * @method BillLine[]    findAll()
 * @method BillLine[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BillLineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BillLine::class);
    }

    // /**
    //  * @return BillLine[] Returns an array of BillLine objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BillLine
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findById($id): ?BillLine
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function findByBill($value): array
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.bill = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult()
        ;
    }


}
