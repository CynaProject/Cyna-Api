<?php

namespace App\Entity;

use App\Repository\UserAddressRepository;
use Doctrine\ORM\Mapping as ORM;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;


#[ApiResource(operations: [
    new GetCollection(normalizationContext: ['groups' => 'useraddress:list']),
    new Get(normalizationContext: ['groups' => 'useraddress:item']),
    new Post(security: "is_granted('ROLE_ADMIN') or object == user"),
    ],)]
    // #[ApiResource(
    //     description: "Gère les adresses des utilisateurs.",
    //     operations: [
    //         new GetCollection(
    //             normalizationContext: ['groups' => 'useraddress:list'],
    //             description: "Récupère la liste des adresses des utilisateurs."
    //         ),
    //         new Get(
    //             normalizationContext: ['groups' => 'useraddress:item'],
    //             description: "Récupère une adresse spécifique d'un utilisateur."
    //         ),
    //     ]
    // )]
    
#[ApiFilter(SearchFilter::class, properties: ['user.id' => 'exact'])]

#[ORM\Entity(repositoryClass: UserAddressRepository::class)]
class UserAddress
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['useraddress:list', 'useraddress:item'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'userAddresses')]
    #[MaxDepth(1)]  
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['useraddress:list', 'useraddress:item'])]

    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'userAddresses')]
    #[MaxDepth(1)]  
    #[ORM\JoinColumn(nullable: false, onDelete: "CASCADE")]
    #[Groups(['useraddress:list', 'useraddress:item','user:list', 'user:item'])]
    private ?Address $address = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $User): static
    {
        $this->user = $User;

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
}
