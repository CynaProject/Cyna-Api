<?php

namespace App\Entity;

use App\Repository\CartDetailsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CartDetailsRepository::class)]
class CartDetails
{
    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'cartDetails')]
    private ?Cart $cart = null;

    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'cartDetails')]
    private ?Product $product = null;

    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'cartDetails')]
    private ?Package $package = null;

    #[ORM\Column]
    private ?int $quantity = null;

    public function getIdCart(): ?Cart
    {
        return $this->cart;
    }

    public function setIdCart(?Cart $idCart): static
    {
        $this->cart = $idCart;

        return $this;
    }

    public function getIdProduct(): ?Product
    {
        return $this->product;
    }

    public function setIdProduct(?Product $idProduct): static
    {
        $this->product = $idProduct;

        return $this;
    }

    public function getIdPackage(): ?Package
    {
        return $this->package;
    }

    public function setIdPackage(?Package $idPackage): static
    {
        $this->package = $idPackage;

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
