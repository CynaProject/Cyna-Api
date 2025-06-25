<?php

namespace App\Entity;

use App\Repository\PaymentMethodRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;

use Doctrine\ORM\Event\LifecycleEventArgs;


#[ApiResource(operations: [
    new GetCollection(normalizationContext: ['groups' => 'paymentmethod:list']),
    new Get(normalizationContext: ['groups' => 'paymentmethod:item']),
    new Post(security: "is_granted('IS_AUTHENTICATED_FULLY')"),
    new Patch(security: "is_granted('ROLE_ADMIN') or object == user"),
    new Delete(security: "is_granted('PAYMENTMETHOD_DELETE', object)"),
    ],
    )]
    
#[ORM\Entity(repositoryClass: PaymentMethodRepository::class)]
class PaymentMethod
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['paymentmethod:list', 'paymentmethod:item','user:list', 'user:item','order:list', 'order:item'])]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Groups(['paymentmethod:list', 'paymentmethod:item','user:list', 'user:item','order:list', 'order:item','subscription:list', 'subscription:item'])]
    private ?string $name = null;

    #[ORM\Column(length: 50)]
    #[Groups(['paymentmethod:list', 'paymentmethod:item','user:list', 'user:item','order:list', 'order:item','subscription:list', 'subscription:item',])]
    private ?string $number = null;

    #[ORM\Column(length: 7)]
    #[Groups(['paymentmethod:list', 'paymentmethod:item','user:list', 'user:item','order:list', 'order:item','subscription:list', 'subscription:item',])]
    private ?string $expirationDate = null;

    #[ORM\Column(length: 50)]
    #[Groups(['paymentmethod:list', 'paymentmethod:item','user:list', 'user:item','order:list', 'order:item','subscription:list', 'subscription:item',])]
    private ?string $cvv = null;

    #[ORM\OneToMany(targetEntity: Order::class, mappedBy: 'payment')]
    #[Groups(['paymentmethod:list', 'paymentmethod:item','order:list', 'order:item'])]
    private Collection $orders;

    #[ORM\OneToMany(targetEntity: UserPaymentMethod::class, mappedBy: 'method', orphanRemoval: true, cascade: ['persist', 'remove'])]
    #[Groups(['paymentmethod:list', 'paymentmethod:item','order:list', 'order:item'])]
    private Collection $userPaymentMethods;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
        $this->userPaymentMethods = new ArrayCollection();
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
     * @return Collection<int, userPaymentMethod>
     */
    public function getuserPaymentMethods(): Collection
    {
        return $this->userPaymentMethods;
    }

    public function adduserPaymentMethod(UserPaymentMethod $userPaymentMethod): static
    {
        if (!$this->userPaymentMethods->contains($userPaymentMethod)) {
            $this->userPaymentMethods->add($userPaymentMethod);
            $userPaymentMethod->setMethod($this);
        }

        return $this;
    }

    public function removeuserPaymentMethod(UserPaymentMethod $userPaymentMethod): static
    {
        if ($this->userPaymentMethods->removeElement($userPaymentMethod)) {
            // set the owning side to null (unless already changed)
            if ($userPaymentMethod->getMethod() === $this) {
                $userPaymentMethod->setMethod(null);
            }
        }

        return $this;
    }
}
