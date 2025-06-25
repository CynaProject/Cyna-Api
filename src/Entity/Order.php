<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;

#[ApiResource(operations: [
    new GetCollection(normalizationContext: ['groups' => 'order:list']),
    new Get(normalizationContext: ['groups' => 'order:item']),
    ],)]
#[ApiFilter(SearchFilter::class, properties: ['user.id' => 'exact'])]


#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: "orders")]    
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['order:list', 'order:item','user:list', 'user:item',])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['order:list', 'order:item','user:list', 'user:item',])]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column]
    #[Groups(['order:list', 'order:item','user:list', 'user:item',])]
    private ?float $amount = null;

    public const STATUS_PAYE = 'Payé';
    public const STATUS_EN_ATTENTE = 'En attente de paiement';
    public const STATUS_REMBOURSE = 'Remboursé';
    public const STATUS_ANNULE = 'Annulé';

    #[ORM\Column(type: "string", length: 50)]
    #[Assert\Choice(choices: [
        self::STATUS_PAYE,
        self::STATUS_EN_ATTENTE,
        self::STATUS_REMBOURSE, 
        self::STATUS_ANNULE
    ], message: "Choisissez un statut valide.")]
    #[Groups(['order:list', 'order:item','user:list', 'user:item',])]
    private ?string $status = null;

    #[ORM\Column(length: 50)]
    #[Groups(['order:list', 'order:item','user:list', 'user:item',])]
    private ?string $invoiceNumber = null;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['order:list', 'order:item','user:list', 'user:item',])]
    private ?Address $address = null;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['order:list', 'order:item','subscription:list', 'subscription:item','paymentmethod:list', 'paymentmethod:item','user:list', 'user:item'])]
    private ?PaymentMethod $payment = null;

    #[ORM\OneToMany(targetEntity: Subscription::class, mappedBy: 'order')]
    #[Groups(['order:list', 'order:item'])]
    private Collection $subscriptions;

    #[ORM\OneToMany(targetEntity: OrderDetails::class, mappedBy: 'orders', orphanRemoval: true)]
    #[Groups(['order:list', 'order:item','user:list', 'user:item',])]
    private Collection $orderDetails;

    public function __construct()
    {
        $this->subscriptions = new ArrayCollection();
        $this->orderDetails = new ArrayCollection();
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
            $orderDetail->setOrders($this);
        }

        return $this;
    }

    public function removeOrderDetail(OrderDetails $orderDetail): static
    {
        if ($this->orderDetails->removeElement($orderDetail)) {
            // set the owning side to null (unless already changed)
            if ($orderDetail->getOrders() === $this) {
                $orderDetail->setOrders(null);
            }
        }

        return $this;
    }
}
