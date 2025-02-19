<?php

namespace App\Entity;

use App\Repository\PackageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PackageRepository::class)]
class Package
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\OneToMany(targetEntity: CartDetails::class, mappedBy: 'idPackage')]
    private Collection $cartDetails;

    #[ORM\OneToMany(targetEntity: ProductPrice::class, mappedBy: 'idPackage')]
    private Collection $productPrices;

    #[ORM\OneToMany(targetEntity: Subscription::class, mappedBy: 'package')]
    private Collection $subscriptions;

    public function __construct()
    {
        $this->cartDetails = new ArrayCollection();
        $this->productPrices = new ArrayCollection();
        $this->subscriptions = new ArrayCollection();
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
            $cartDetail->setIdPackage($this);
        }

        return $this;
    }

    public function removeCartDetail(CartDetails $cartDetail): static
    {
        if ($this->cartDetails->removeElement($cartDetail)) {
            // set the owning side to null (unless already changed)
            if ($cartDetail->getIdPackage() === $this) {
                $cartDetail->setIdPackage(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ProductPrice>
     */
    public function getProductPrices(): Collection
    {
        return $this->productPrices;
    }

    public function addProductPrice(ProductPrice $productPrice): static
    {
        if (!$this->productPrices->contains($productPrice)) {
            $this->productPrices->add($productPrice);
            $productPrice->setIdPackage($this);
        }

        return $this;
    }

    public function removeProductPrice(ProductPrice $productPrice): static
    {
        if ($this->productPrices->removeElement($productPrice)) {
            // set the owning side to null (unless already changed)
            if ($productPrice->getIdPackage() === $this) {
                $productPrice->setIdPackage(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Subscription>
     */
    public function getSubscriptions(): Collection
    {
        return $this->subscriptions;
    }

    public function addSubscription(Subscription $subscription): static
    {
        if (!$this->subscriptions->contains($subscription)) {
            $this->subscriptions->add($subscription);
            $subscription->setPackage($this);
        }

        return $this;
    }

    public function removeSubscription(Subscription $subscription): static
    {
        if ($this->subscriptions->removeElement($subscription)) {
            // set the owning side to null (unless already changed)
            if ($subscription->getPackage() === $this) {
                $subscription->setPackage(null);
            }
        }

        return $this;
    }
}
