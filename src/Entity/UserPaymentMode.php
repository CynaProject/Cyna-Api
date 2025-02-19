<?php

namespace App\Entity;

use App\Repository\UserPaymentModeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserPaymentModeRepository::class)]
class UserPaymentMode
{
    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'userPaymentModes')]
    private ?User $user = null;

    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'userPaymentModes')]
    private ?PaymentMethod $method = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getMethod(): ?PaymentMethod
    {
        return $this->method;
    }

    public function setMethod(?PaymentMethod $method): static
    {
        $this->method = $method;

        return $this;
    }
}
