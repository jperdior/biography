<?php

namespace App\Repository;

use App\Entity\ParentType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ParentType|null find($id, $lockMode = null, $lockVersion = null)
 * @method ParentType|null findOneBy(array $criteria, array $orderBy = null)
 * @method ParentType[]    findAll()
 * @method ParentType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParentTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ParentType::class);
    }

    // /**
    //  * @return ParentType[] Returns an array of ParentType objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ParentType
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
