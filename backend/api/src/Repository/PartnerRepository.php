<?php

namespace App\Repository;

use App\Entity\Partner;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Partner>
 */
class PartnerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Partner::class);
    }

        /**
        * @return Company[] Returns an array of Company objects
        */
        public function getAll(): array
        {
            return $this->createQueryBuilder('p')
                ->getQuery()
                ->getResult()
            ;
        }

       /**
        * @return Partner|null Returns a single Partner by id or null if not found
        */
       public function getById(int $id): ?Partner
       {
           return $this->createQueryBuilder('p')
               ->andWhere('p.id = :id')
               ->setParameter('id', $id)
               ->getQuery()
               ->getOneOrNullResult();
           ;
       }
}
