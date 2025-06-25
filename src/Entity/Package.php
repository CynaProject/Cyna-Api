<?php

namespace App\Entity;

use App\Repository\PackageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;

use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;

#[ApiResource(operations: [
    new GetCollection(normalizationContext: ['groups' => 'package:list']),
    new Get(normalizationContext: ['groups' => 'package:item']),
    ],)]

#[ApiResource]
#[ORM\Entity(repositoryClass: PackageRepository::class)]
class Package
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['package:list', 'package:item','user:list', 'user:item','product:item','product:list','topproduct:item','topproduct:list'])]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Groups(['package:list', 'package:item','subscription:list','subscription:item','product:item','product:list','topproduct:item','topproduct:list','user:list', 'user:item',])]
    private ?string $name = null;

    #[ORM\OneToMany(targetEntity: CartDetails::class, mappedBy: 'package')]
    #[Groups(['package:list', 'package:item'])]
    private Collection $cartDetails;

    #[ORM\OneToMany(targetEntity: ProductPrice::class, mappedBy: 'package')]
    #[Groups(['package:list', 'package:item'])]
    private Collection $productPrices;

    #[ORM\OneToMany(targetEntity: Subscription::class, mappedBy: 'package')]
    #[Groups(['package:list', 'package:item'])]
    private Collection $subscriptions;

    #[ORM\OneToMany(targetEntity: OrderDetails::class, mappedBy: 'package', orphanRemoval: true)]
    #[Groups(['package:list', 'package:item'])]
    private Collection $orderDetails;

    public function __construct()
    {
        $this->cartDetails = new ArrayCollection();
        $this->productPrices = new ArrayCollection();
        $this->subscriptions = new ArrayCollection();
        $this->orderDetails = new ArrayCollection();
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

    /**
     * @return Collection<int, OrderDetails>
     */
    public function getOrderDetails(): Collection
    {
        return $this->orderDetails;
    }

    public function addOrderDetail(OrderDetails $orderDetail): static
    {
        if (!$this->orderDetails->contains($orderDetail)) {
            $this->orderDetails->add($orderDetail);
            $orderDetail->setPackage($this);
        }

        return $this;
    }

    public function removeOrderDetail(OrderDetails $orderDetail): static
    {
        if ($this->orderDetails->removeElement($orderDetail)) {
            // set the owning side to null (unless already changed)
            if ($orderDetail->getPackage() === $this) {
                $orderDetail->setPackage(null);
            }
        }

        return $this;
    }
}
