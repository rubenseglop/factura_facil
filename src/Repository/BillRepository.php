<?php

namespace App\Repository;

use App\Entity\Bill;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Bill|null find($id, $lockMode = null, $lockVersion = null)
 * @method Bill|null findOneBy(array $criteria, array $orderBy = null)
 * @method Bill[]    findAll()
 * @method Bill[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BillRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bill::class);
    }

    // /**
    //  * @return Bill[] Returns an array of Bill objects
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
    public function findOneBySomeField($value): ?Bill
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findById($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.id = :val')
            ->andWhere('c.status = true')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    public function findByIdCompany($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.company = :val')
            ->andWhere('c.status = true')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
    public function findByDateBill($start_date, $end_date, $id)
    {       
        return $this->createQueryBuilder('c')
            ->andWhere('c.dateBill BETWEEN :start_date and :end_date')
            ->andWhere('c.company = :id')
            ->andWhere('c.status = true')
            ->setParameter('start_date', $start_date)
            ->setParameter('end_date', $end_date)
            ->setParameter('id', $id)
            ->orderBy('c.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
}
