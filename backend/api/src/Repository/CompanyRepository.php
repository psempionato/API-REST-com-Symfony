<?php

namespace App\Repository;

use App\Entity\Company;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Company>
 */
class CompanyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Company::class);
    }

       /**
        * @return Company[] Returns an array of Company objects
        */
       public function getAll(): array
       {
           return $this->createQueryBuilder('c')
               ->getQuery()
               ->getResult()
           ;
       }

        /**
        * @return Company[]|null Returns a single Company or null if not found
        */
       public function getById($id): ?Company
       {
           return $this->createQueryBuilder('c')
               ->andWhere('c.id = :id')
               ->setParameter('id', $id)
               ->getQuery()
               ->getOneOrNullResult()
           ;
       }
}
