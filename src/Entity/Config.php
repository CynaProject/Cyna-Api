<?php

namespace App\Entity;

use App\Repository\ConfigRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConfigRepository::class)]
class Config
{
  

    #[ORM\Id]
    #[ORM\Column(length: 50)]
    private ?string $keyy = null;

    #[ORM\Column(type: Types::TEXT)]
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
