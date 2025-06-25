<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;

use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;


#[ApiResource(operations: [
    new GetCollection(normalizationContext: ['groups' => 'categorie:list']),
    new Get(normalizationContext: ['groups' => 'categorie:item']),
    new Patch(security: "is_granted('ROLE_ADMIN') or object == user"),
    new Post(security: "is_granted('ROLE_ADMIN') or object == user"),
    ],)]
    
#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['categorie:list', 'categorie:item','product:list', 'product:item','topproduct:list', 'topproduct:item','user:list', 'user:item'])]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Groups(['categorie:list', 'categorie:item','product:list', 'product:item','topproduct:list', 'topproduct:item','user:list', 'user:item',])]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['categorie:list', 'categorie:item','topproduct:list', 'topproduct:item','user:list', 'user:item',])]
    private ?string $image = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['categorie:list', 'categorie:item','topproduct:list', 'topproduct:item'])]
    private ?int $position = null;

    #[ORM\OneToMany(targetEntity: Product::class, mappedBy: 'category')]
    private Collection $products;
    
    public function __construct()
    {
        $this->products = new ArrayCollection();
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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $position): static
    {
        $this->position = $position;

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }    

    public function addProduct(Product $product): static
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
            $product->setCategory($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): static
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getCategory() === $this) {
                $product->setCategory(null);
            }
        }

        return $this;
    }

}
