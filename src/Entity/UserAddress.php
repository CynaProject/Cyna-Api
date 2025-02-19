<?php

namespace App\Entity;

use App\Repository\UserAddressRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserAddressRepository::class)]
class UserAddress
{

    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'userAddresses')]
    private ?User $user = null;

    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'userAddresses')]
    private ?Address $address = null;

    public function getIdUser(): ?User
    {
        return $this->user;
    }

    public function setIdUser(?User $idUser): static
    {
        $this->user = $idUser;

        return $this;
    }

    public function getAddressId(): ?Address
    {
        return $this->address;
    }

    public function setAddressId(?Address $addressId): static
    {
        $this->address = $addressId;

        return $this;
    }
}
