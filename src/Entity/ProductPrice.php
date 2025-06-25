<?php

namespace App\Entity;

use App\Repository\ProductPriceRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;
use Symfony\Component\Serializer\Annotation\MaxDepth;


#[ApiResource(operations: [
    new GetCollection(normalizationContext: ['groups' => 'productprice:list']),
    new Get(normalizationContext: ['groups' => 'productprice:item']),
    ],)]

#[ORM\Entity(repositoryClass: ProductPriceRepository::class)]
class ProductPrice
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['productprice:list', 'productprice:item'])]
    private ?int $id = null;


    #[ORM\ManyToOne(inversedBy: 'productPrices')]
    #[ORM\JoinColumn(nullable: false, onDelete: "CASCADE")]
    #[MaxDepth(1)]  
    #[Groups(['productprice:list', 'productprice:item'])]
    private ?Product $product = null;

    #[ORM\ManyToOne(inversedBy: 'productPrices')]
    #[ORM\JoinColumn(nullable: false)]
    #[MaxDepth(1)]  
    #[Groups(['productprice:list', 'productprice:item','product:list','product:item','topproduct:list', 'topproduct:item'])]
    private ?Package $package = null;

    #[ORM\Column]
    #[Groups(['productprice:list', 'productprice:item','subscription:list','subscription:item','product:list','product:item','topproduct:list', 'topproduct:item'])]
    private ?float $price = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): static
    {
        $this->product = $product;

        return $this;
    }

    public function getPackage(): ?Package
    {
        return $this->package;
    }

    public function setPackage(?Package $package): static
    {
        $this->package = $package;
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
