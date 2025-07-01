<?php

namespace App\Entity;

use App\Repository\AddressRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Delete;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;

#[ApiResource(operations: [
    new GetCollection(normalizationContext: ['groups' => 'address:list']),
    new Get(normalizationContext: ['groups' => 'address:item']),
    new Post(security: "is_granted('IS_AUTHENTICATED_FULLY')"),
    new Delete(security: "is_granted('IS_AUTHENTICATED_FULLY')"),
    new Patch(security: "is_granted('ROLE_ADMIN') or object == user"),
    new Put(security: "is_granted('ROLE_ADMIN') or object == user")
    ],)]
#[ApiFilter(SearchFilter::class, properties: ['id' => 'exact'])]  
#[ORM\Entity(repositoryClass: AddressRepository::class)]
class Address
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['address:list', 'address:item','user:list', 'user:item'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['address:list', 'address:item','user:list', 'user:item'])]

    private ?string $address1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['address:list', 'address:item','user:list', 'user:item'])]
    private ?string $address2 = null;

    #[ORM\Column(length: 50)]
    #[Groups(['address:list', 'address:item','user:list', 'user:item'])]
    private ?string $postalcode = null;

    #[ORM\Column(length: 255)]
    #[Groups(['address:list', 'address:item','user:list', 'user:item'])]
    private ?string $city = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['address:list', 'address:item','user:list', 'user:item'])]
    private ?string $state = null;

    #[ORM\Column(length: 255)]
    #[Groups(['address:list', 'address:item','user:list', 'user:item'])]
    private ?string $country = null;

    #[ORM\OneToMany(targetEntity: UserAddress::class, mappedBy: 'address', orphanRemoval: true)]
    private Collection $userAddresses;

    #[ORM\OneToMany(targetEntity: Order::class, mappedBy: 'address')]
    private Collection $orders;

    public function __construct()
    {
        $this->userAddresses = new ArrayCollection();
        $this->orders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAddress1(): ?string
    {
        return $this->address1;
    }

    public function setAddress1(string $address1): static
    {
        $this->address1 = $address1;

        return $this;
    }

    public function getAddress2(): ?string
    {
        return $this->address2;
    }

    public function setAddress2(?string $address2): static
    {
        $this->address2 = $address2;

        return $this;
    }

    public function getPostalcode(): ?string
    {
        return $this->postalcode;
    }

    public function setPostalcode(string $postalcode): static
    {
        $this->postalcode = $postalcode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(?string $state): static
    {
        $this->state = $state;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): static
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return Collection<int, UserAddress>
     */
    public function getUserAddresses(): Collection
    {
        return $this->userAddresses;
    }

    public function addUserAddress(UserAddress $userAddress): static
    {
        if (!$this->userAddresses->contains($userAddress)) {
            $this->userAddresses->add($userAddress);
            $userAddress->setAddress($this);
        }

        return $this;
    }

    public function removeUserAddress(UserAddress $userAddress): static
    {
        if ($this->userAddresses->removeElement($userAddress)) {
            // set the owning side to null (unless already changed)
            if ($userAddress->getAddress() === $this) {
                $userAddress->setAddress(null);
            }
        }

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
            $order->setAddress($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): static
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getAddress() === $this) {
                $order->setAddress(null);
            }
        }

        return $this;
    }
}
