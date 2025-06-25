<?php

namespace App\EventListener;

use App\Entity\Address;
use App\Entity\UserAddress;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\PostPersistEventArgs;
use Symfony\Component\Security\Core\Security;

class AddressListener
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
        $address = $args->getObject();

        if (!$address instanceof Address) {
            return;
        }

        $user = $this->security->getUser();

        if ($user) {
            $userAddress = new UserAddress();
            $userAddress->setUser($user);
            $userAddress->setAddress($address);

            $this->entityManager->persist($userAddress);
            $this->entityManager->flush();
        }
    }
}
