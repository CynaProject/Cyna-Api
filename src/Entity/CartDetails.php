<?php

namespace App\Entity;

use App\Repository\CartDetailsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;

#[ApiResource(operations: [
    new GetCollection(normalizationContext: ['groups' => 'cartdetails:list']),
    new Get(normalizationContext: ['groups' => 'cartdetails:item']),
    ],)]
#[ORM\Entity(repositoryClass: CartDetailsRepository::class)]
class CartDetails
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['cartdetails:list', 'cartdetails:item'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'cartDetails')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['cartdetails:list', 'cartdetails:item'])]
    private ?Cart $cart = null;

    #[ORM\ManyToOne(inversedBy: 'cartDetails')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['cartdetails:list', 'cartdetails:item'])]
    private ?Product $product = null;

    #[ORM\ManyToOne(inversedBy: 'cartDetails')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['cartdetails:list', 'cartdetails:item'])]
    private ?Package $package = null;

    #[ORM\Column]
    private ?int $quantity = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCart(): ?Cart
    {
        return $this->cart;
    }

    public function setCart(?Cart $cart): static
    {
        $this->cart = $cart;
        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $Product): static
    {
        $this->product = $Product;
        return $this;
    }

    public function getPackage(): ?Package
    {
        return $this->package;
    }

    public function setPackage(?Package $Package): static
    {
        $this->package = $Package;
        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;
        return $this;
    }
}

