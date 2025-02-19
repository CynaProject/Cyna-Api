<?php

namespace App\Repository;

use App\Entity\UserPaymentMode;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserPaymentMode>
 *
 * @method UserPaymentMode|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserPaymentMode|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserPaymentMode[]    findAll()
 * @method UserPaymentMode[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserPaymentModeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserPaymentMode::class);
    }

//    /**
//     * @return UserPaymentMode[] Returns an array of UserPaymentMode objects
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

//    public function findOneBySomeField($value): ?UserPaymentMode
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
