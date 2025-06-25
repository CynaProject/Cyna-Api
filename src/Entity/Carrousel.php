<?php

namespace App\Entity;

use App\Repository\CarrouselRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Delete;

use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;

#[ApiResource(operations: [
    new GetCollection(normalizationContext: ['groups' => 'carrousel:list'], order: ['position' => 'ASC']),
    new Get(normalizationContext: ['groups' => 'carrousel:item']),
    new Patch(security: "is_granted('ROLE_ADMIN') or object == user"),
    new Delete(security: "is_granted('ROLE_ADMIN') or object == user"),
    new Post(security: "is_granted('ROLE_ADMIN') or object == user"),
    ],
)]

#[ORM\Entity(repositoryClass: CarrouselRepository::class)]
class Carrousel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['carrousel:list', 'carrousel:item'])]
    private ?int $id = null;

    #[ORM\Column(length: 255,nullable: true)]
    #[Groups(['carrousel:list', 'carrousel:item'])]
    private ?string $image = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['carrousel:list', 'carrousel:item'])]
    private ?int $position = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['carrousel:list', 'carrousel:item'])]
    private ?string $text = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

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

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): static
    {
        $this->text = $text;

        return $this;
    }
}
