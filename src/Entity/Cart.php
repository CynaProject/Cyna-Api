<?php

namespace App\Entity;

use App\Repository\CartRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CartRepository::class)]
class Cart
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'cart', cascade: ['persist', 'remove'])]
    private ?User $user = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $creationDate = null;

    #[ORM\OneToMany(targetEntity: CartDetails::class, mappedBy: 'idCart')]
    private Collection $cartDetails;

    public function __construct()
    {
        $this->cartDetails = new ArrayCollection();
    }

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

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creationDate;
    }

    public function setCreationDate(\DateTimeInterface $creationDate): static
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * @return Collection<int, CartDetails>
     */
    public function getCartDetails(): Collection
    {
        return $this->cartDetails;
    }

    public function addCartDetail(CartDetails $cartDetail): static
    {
        if (!$this->cartDetails->contains($cartDetail)) {
            $this->cartDetails->add($cartDetail);
            $cartDetail->setIdCart($this);
        }

        return $this;
    }

    public function removeCartDetail(CartDetails $cartDetail): static
    {
        if ($this->cartDetails->removeElement($cartDetail)) {
            // set the owning side to null (unless already changed)
            if ($cartDetail->getIdCart() === $this) {
                $cartDetail->setIdCart(null);
            }
        }

        return $this;
    }
}
