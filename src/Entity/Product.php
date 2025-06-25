<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;

use App\Dto\ProductInput;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;

use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;

use App\DataTransformer\ProductDataInputTransformer;



#[ApiResource(
    input: ProductInput::class,
    output: Product::class,
    processor: ProductDataInputTransformer::class, 
    operations: [
        new GetCollection(normalizationContext: ['groups' => 'product:list']),
        new Get(normalizationContext: ['groups' => 'product:item']),
        new Post(
            normalizationContext: ['groups' => ['package:item']],
            security: "is_granted('ROLE_ADMIN') or object == user",
            securityMessage: "Seuls les admins ou le propriétaire peuvent créer/modifier."
        ),
    ],
)]

#[ApiFilter(SearchFilter::class, properties: ['category.id' => 'exact'])]

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['product:list', 'product:item','topproduct:list', 'topproduct:item','subscription:list', 'subscription:item','user:list', 'user:item',])]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Groups(['product:list', 'product:item','topproduct:list', 'topproduct:item','subscription:list', 'subscription:item','user:list', 'user:item'])]
    private ?string $name = null;
    
    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['product:list', 'product:item','topproduct:list', 'topproduct:item','subscription:item', 'subscription:list','user:list', 'user:item',])]
    private ?string $description = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['product:list', 'product:item','topproduct:list', 'topproduct:item','subscription:item', 'subscription:list','user:list', 'user:item',])]
    private ?string $details = null;

    #[ORM\Column]
    #[Groups(['product:list', 'product:item','topproduct:list', 'topproduct:item','subscription:item', 'subscription:list','user:list', 'user:item',])]
    private ?bool $available = null;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['product:list', 'product:item','topproduct:list', 'topproduct:item','subscription:item', 'subscription:list','user:list', 'user:item',])]
    private ?Category $category = null;
    
    #[ORM\OneToMany(targetEntity: TopProducts::class, mappedBy: 'product')]

    private Collection $topProducts;

    #[ORM\OneToMany(targetEntity: CartDetails::class, mappedBy: 'product')]
    private Collection $cartDetails;

#[ApiSubresource()]
#[ORM\OneToMany(targetEntity: ProductPrice::class, mappedBy: 'product', cascade: ['persist', 'remove'])]
#[Groups(['product:list', 'product:item', 'productprice:list', 'productprice:item', 'topproduct:list', 'topproduct:item'])]
private Collection $productPrices;

    #[ORM\OneToMany(targetEntity: Subscription::class, mappedBy: 'product')]
    #[Groups(['productprice:item','topproduct:list'])]
    private Collection $subscriptions;

    #[ApiSubresource()]
    #[ORM\OneToMany(mappedBy: 'product', targetEntity: ProductImage::class, cascade: ['persist'], orphanRemoval: true)]
    #[Groups(['product:list', 'product:item','topproduct:list', 'topproduct:item','subscription:item', 'subscription:list'])]
    private Collection $images;

    #[ORM\OneToMany(targetEntity: OrderDetails::class, mappedBy: 'product', orphanRemoval: true)]
    private Collection $orderDetails;

    public function __construct()
    {
        $this->topProducts = new ArrayCollection();
        $this->cartDetails = new ArrayCollection();
        $this->productPrices = new ArrayCollection();
        $this->subscriptions = new ArrayCollection();
        $this->images = new ArrayCollection();
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
// Getters and setters for the missing methods:

    public function getAvailable(): ?bool
    {
        return $this->available;
    }
    
    public function setAvailable(bool $available): static
    {
        $this->available = $available;
    
        return $this;
    }
    
    public function getDetails(): ?string
    {
        return $this->details;
    }
    
    public function setDetails(string $details): static
    {
        $this->details = $details;
    
        return $this;
    }
    
    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }


    public function addImage(ProductImage $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setProduct($this); 
        }
    
        return $this;
    }


    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function isIsAvailable(): ?bool
    {
        return $this->isAvailable;
    }

    public function setIsAvailable(bool $isAvailable): static
    {
        $this->isAvailable = $isAvailable;

        return $this;
    }

    /**
     * @return Collection<int, TopProducts>
     */
    public function getTopProducts(): Collection
    {
        return $this->topProducts;
    }

    public function addTopProduct(TopProducts $topProduct): static
    {
        if (!$this->topProducts->contains($topProduct)) {
            $this->topProducts->add($topProduct);
            $topProduct->setServices($this);
        }

        return $this;
    }

    public function removeTopProduct(TopProducts $topProduct): static
    {
        if ($this->topProducts->removeElement($topProduct)) {
            // set the owning side to null (unless already changed)
            if ($topProduct->getServices() === $this) {
                $topProduct->setServices(null);
            }
        }

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
            $cartDetail->setIdProduct($this);
        }

        return $this;
    }

    public function removeCartDetail(CartDetails $cartDetail): static
    {
        if ($this->cartDetails->removeElement($cartDetail)) {
            // set the owning side to null (unless already changed)
            if ($cartDetail->getIdProduct() === $this) {
                $cartDetail->setIdProduct(null);
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

    public function addProductPrice(ProductPrice $productPrice): self
    {
        if (!$this->productPrices->contains($productPrice)) {
            $this->productPrices->add($productPrice);
            $productPrice->setProduct($this);
        }
        return $this;
    }
    

    public function removeProductPrice(ProductPrice $productPrice): self
    {
        if ($this->productPrices->removeElement($productPrice)) {
            if ($productPrice->getProduct() === $this) {
                $productPrice->setProduct(null);
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
            $subscription->setProduct($this);
        }

        return $this;
    }

    public function removeSubscription(Subscription $subscription): static
    {
        if ($this->subscriptions->removeElement($subscription)) {
            // set the owning side to null (unless already changed)
            if ($subscription->getProduct() === $this) {
                $subscription->setProduct(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ProductImage>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }



    public function removeImage(ProductImage $image): static
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getProduct() === $this) {
                $image->setProduct(null);
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
            $orderDetail->setProduct($this);
        }

        return $this;
    }

    public function removeOrderDetail(OrderDetails $orderDetail): static
    {
        if ($this->orderDetails->removeElement($orderDetail)) {
            // set the owning side to null (unless already changed)
            if ($orderDetail->getProduct() === $this) {
                $orderDetail->setProduct(null);
            }
        }

        return $this;
    }


}
