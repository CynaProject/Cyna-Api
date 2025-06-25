<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

final class ProductInput
{
    #[Assert\NotBlank]
    public string $name;

    public ?string $description = null;

    public ?string $details = null;

    public ?bool $available = true;

    #[Assert\NotBlank]
    public string $category; // IRI

    /** @var string[] $images */
    public array $images = [];

    /**
     * @var array<array{package: string, price: float}>
     */
    #[Assert\Valid]
    public array $productPrices = [];
}
