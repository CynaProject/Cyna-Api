<?php

namespace App\Entity;

use App\Repository\TopProductsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;

use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;

#[ApiResource(operations: [
    new GetCollection(normalizationContext: ['groups' => 'topproduct:list']),
    new Get(normalizationContext: ['groups' => 'topproduct:item']),
    new Patch(security: "is_granted('ROLE_ADMIN') or object == user"),
    ],)]

#[ORM\Entity(repositoryClass: TopProductsRepository::class)]
class TopProducts
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['topproduct:list', 'topproduct:item'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['topproduct:list', 'topproduct:item'])]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['topproduct:list', 'topproduct:item'])]
    private ?int $position = null;

    #[ORM\ManyToOne(inversedBy: 'topProducts')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['topproduct:list', 'topproduct:item', 'product:list', 'product:item'])]
    private ?Product $product = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?ProductImage $image = null;

    public function __construct()
    {
        $this->topProducts = new ArrayCollection();
        $this->product = new ArrayCollection();
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

    #[Groups(['topproduct:list', 'topproduct:item'])]
    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): static
    {
        $this->product = $product;

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
