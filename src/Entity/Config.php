<?php

namespace App\Entity;

use App\Repository\ConfigRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;

use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;

#[ApiResource(operations: [
    new Get(normalizationContext: ['groups' => 'config:item']),
    new Patch(security: "is_granted('ROLE_ADMIN') or object == user"),
])]
    
#[ORM\Entity(repositoryClass: ConfigRepository::class)]
class Config
{

    #[ORM\Id]
    #[ORM\Column(length: 50)]
    #[Groups(['config:item'])]
    private ?string $keyy = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['config:item'])]
    private ?string $value = null;

    public function getKeyy(): ?string
    {
        return $this->keyy;
    }

    public function setKeyy(string $keyy): static
    {
        $this->keyy = $keyy;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): static
    {
        $this->value = $value;

        return $this;
    }


}
