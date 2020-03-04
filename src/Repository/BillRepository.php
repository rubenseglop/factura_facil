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
        return $this->createQueryBuilder('b')
            ->andWhere('b.id = :val')
            ->andWhere('b.status = true')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    public function findByIdCompany($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.company = :val')
            ->andWhere('b.status = true')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
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
    public function findByNumberBill($numberBill, $id)
    {       
        return $this->createQueryBuilder('c')
            ->andWhere('c.numberBill = :numberBill')
            ->andWhere('c.company = :id')
            ->andWhere('c.status = true')
            ->setParameter('numberBill', $numberBill)
            ->setParameter('id', $id)
            ->orderBy('c.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
    public function findByDescription($description, $id)
    {       
        return $this->createQueryBuilder('c')
            ->andWhere('c.descriptionBill LIKE :description')
            ->andWhere('c.company = :id')
            ->andWhere('c.status = true')
            ->setParameter('description', $description)
            ->setParameter('id', $id)
            ->orderBy('c.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
    public function findByClient($client, $id)
    {       
        
        /*return $this->createQueryBuilder('c')
            ->andWhere('c.client.name like :client')
            ->andWhere('c.company = :id')
            ->andWhere('c.status = true')
            ->setParameter('client', $client)
            ->setParameter('id', $id)
            ->orderBy('c.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;*/
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT b
                FROM App\Entity\Bill b
                INNER JOIN App\Entity\Client c 
                WHERE c.name LIKE :client AND b.company = :id AND b.client = c.id'
        )
        ->setParameter('id', $id)
        ->setParameter('client', $client);
    
        return $query->getResult();

    }
}
