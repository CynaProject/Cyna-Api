<?php

namespace App\Repository;

use App\Entity\UserPaymentMethod;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<userPaymentMethod>
 *
 * @method userPaymentMethod|null find($id, $lockMode = null, $lockVersion = null)
 * @method userPaymentMethod|null findOneBy(array $criteria, array $orderBy = null)
 * @method userPaymentMethod[]    findAll()
 * @method userPaymentMethod[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserPaymentMethodRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, userPaymentMethod::class);
    }

//    /**
//     * @return userPaymentMethod[] Returns an array of userPaymentMethod objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?userPaymentMethod
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
