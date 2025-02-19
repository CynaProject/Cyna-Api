<?php

namespace App\Entity;

use App\Repository\PaymentMethodRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PaymentMethodRepository::class)]
class PaymentMethod
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\Column(length: 50)]
    private ?string $number = null;

    #[ORM\Column(length: 7)]
    private ?string $expirationDate = null;

    #[ORM\Column(length: 50)]
    private ?string $cvv = null;

    #[ORM\OneToMany(targetEntity: Order::class, mappedBy: 'payment')]
    private Collection $orders;

    #[ORM\OneToMany(targetEntity: UserPaymentMode::class, mappedBy: 'method')]
    private Collection $userPaymentModes;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
        $this->userPaymentModes = new ArrayCollection();
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

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(string $number): static
    {
        $this->number = $number;

        return $this;
    }

    public function getExpirationDate(): ?string
    {
        return $this->expirationDate;
    }

    public function setExpirationDate(string $expirationDate): static
    {
        $this->expirationDate = $expirationDate;

        return $this;
    }

    public function getCvv(): ?string
    {
        return $this->cvv;
    }

    public function setCvv(string $cvv): static
    {
        $this->cvv = $cvv;

        return $this;
    }

    /**
     * @return Collection<int, Order>
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): static
    {
        if (!$this->orders->contains($order)) {
            $this->orders->add($order);
            $order->setPayment($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): static
    {
        if ($this->order->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getPayment() === $this) {
                $order->setPayment(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, UserPaymentMode>
     */
    public function getUserPaymentModes(): Collection
    {
        return $this->userPaymentModes;
    }

    public function addUserPaymentMode(UserPaymentMode $userPaymentMode): static
    {
        if (!$this->userPaymentModes->contains($userPaymentMode)) {
            $this->userPaymentModes->add($userPaymentMode);
            $userPaymentMode->setMethod($this);
        }

        return $this;
    }

    public function removeUserPaymentMode(UserPaymentMode $userPaymentMode): static
    {
        if ($this->userPaymentModes->removeElement($userPaymentMode)) {
            // set the owning side to null (unless already changed)
            if ($userPaymentMode->getMethod() === $this) {
                $userPaymentMode->setMethod(null);
            }
        }

        return $this;
    }
}
