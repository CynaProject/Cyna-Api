<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    private ?User $user = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column]
    private ?float $amount = null;

    public const STATUS_TERMINEE = 'Terminée';
    public const STATUS_ACTIVE = 'Active';
    public const STATUS_RENOUVELLEE = 'Renouvelée';
    public const STATUS_A_FACTURER = 'A facturer';

    #[ORM\Column(type: "string", length: 50)]
    #[Assert\Choice(choices: [
        self::STATUS_TERMINEE, 
        self::STATUS_ACTIVE, 
        self::STATUS_RENOUVELLEE, 
        self::STATUS_A_FACTURER
    ], message: "Choisissez un statut valide.")]
    private ?string $status = null;

    #[ORM\Column(length: 50)]
    private ?string $invoiceNumber = null;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    private ?Address $address = null;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    private ?PaymentMethod $payment = null;

    #[ORM\OneToMany(targetEntity: Subscription::class, mappedBy: 'order')]
    private Collection $subscriptions;

    public function __construct()
    {
        $this->subscriptions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $userId): static
    {
        $this->user = $userId;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): static
    {
        $this->amount = $amount;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getInvoiceNumber(): ?string
    {
        return $this->invoiceNumber;
    }

    public function setInvoiceNumber(string $invoiceNumber): static
    {
        $this->invoiceNumber = $invoiceNumber;

        return $this;
    }

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(?Address $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getPayment(): ?PaymentMethod
    {
        return $this->payment;
    }

    public function setPayment(?PaymentMethod $payment): static
    {
        $this->payment = $payment;

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
            $subscription->setOrder($this);
        }

        return $this;
    }

    public function removeSubscription(Subscription $subscription): static
    {
        if ($this->subscriptions->removeElement($subscription)) {
            // set the owning side to null (unless already changed)
            if ($subscription->getOrder() === $this) {
                $subscription->setOrder(null);
            }
        }

        return $this;
    }
}
