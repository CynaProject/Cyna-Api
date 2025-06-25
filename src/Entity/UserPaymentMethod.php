<?php

namespace App\Entity;

use App\Repository\UserPaymentMethodRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;

#[ApiResource(operations: [
    new GetCollection(normalizationContext: ['groups' => 'userpayments:list']),
    new Get(normalizationContext: ['groups' => 'userpayments:item']),
    ],)]
#[ApiFilter(SearchFilter::class, properties: ['user.id' => 'exact'])]

#[ORM\Entity(repositoryClass: UserPaymentMethodRepository::class)]
class UserPaymentMethod
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['userpayments:list', 'userpayments:item'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'userPaymentMethods')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['userpayments:list', 'userpayments:item'])]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'userPaymentMethods')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    #[Groups(['userpayments:list', 'userpayments:item','user:list', 'user:item'])]
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
