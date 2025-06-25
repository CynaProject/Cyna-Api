<?php

namespace App\EventListener;

use App\Entity\PaymentMethod;
use App\Entity\UserPaymentMethod;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\PostPersistEventArgs;
use Symfony\Component\Security\Core\Security;

class PaymentMethodListener
{
    private EntityManagerInterface $entityManager;
    private Security $security;

    public function __construct(EntityManagerInterface $entityManager, Security $security)
    {
        $this->entityManager = $entityManager;
        $this->security = $security;
    }

    public function postPersist(PostPersistEventArgs $args): void
    {
        $paymentMethod = $args->getObject(); 

        if ($paymentMethod instanceof PaymentMethod) {
            $user = $this->security->getUser();
            if ($user) {

                $userPaymentMethod = new UserPaymentMethod();
                $userPaymentMethod->setUser($user);
                $userPaymentMethod->setMethod($paymentMethod);

                $this->entityManager->persist($userPaymentMethod);
                $this->entityManager->flush();
            }
        }
    }
}
