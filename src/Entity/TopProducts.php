<?php

namespace App\Entity;

use App\Repository\TopProductsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TopProductsRepository::class)]
class TopProducts
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $position = null;

    #[ORM\ManyToOne(inversedBy: 'topProducts')]
    private ?Product $services = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?ProductImage $image = null;

    public function __construct()
    {
        $this->topProducts = new ArrayCollection();
        $this->services = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $position): static
    {
        $this->position = $position;

        return $this;
    }

    public function getServices(): ?Product
    {
        return $this->services;
    }

    public function setServices(?Product $services): static
    {
        $this->services = $services;

        return $this;
    }

    public function getImage(): ?ProductImage
    {
        return $this->image;
    }

    public function setImage(?ProductImage $image): static
    {
        $this->image = $image;

        return $this;
    }

}
