<?php

namespace App\Entity;

use App\Repository\ProductPriceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductPriceRepository::class)]
class ProductPrice
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'productPrices')]
    private ?Product $product = null;

    #[ORM\ManyToOne(inversedBy: 'productPrices')]
    private ?Package $package = null;

    #[ORM\Column]
    private ?float $price = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }
}
