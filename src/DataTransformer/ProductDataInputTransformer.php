<?php

namespace App\DataTransformer;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Dto\ProductInput;
use App\Entity\Product;
use App\Entity\Category;
use App\Entity\Package;
use App\Entity\ProductPrice;
use App\Entity\ProductImage;
use Doctrine\ORM\EntityManagerInterface;

class ProductDataInputTransformer implements ProcessorInterface
{
    public function __construct(private EntityManagerInterface $em) {}

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): Product
    {
        /** @var ProductInput $data */
        $product = new Product();

        $product->setName($data->name);
        $product->setDescription($data->description ?? '');
        $product->setDetails($data->details ?? '');
        $product->setAvailable($data->available ?? true);

        // Récupération de la catégorie via IRI
        $category = $this->em->getReference(Category::class, (int) basename($data->category));
        $product->setCategory($category);

        // Ajout des prix liés aux packages
        foreach ($data->productPrices as $priceData) {
            $package = $this->em->getReference(Package::class, (int) basename($priceData['package']));
            $productPrice = new ProductPrice();
            $productPrice->setPackage($package);
            $productPrice->setPrice((float) $priceData['price']);
            $productPrice->setProduct($product);

            $product->addProductPrice($productPrice);
            $this->em->persist($productPrice);
        }
        
        if (!empty($data->images)) {
            foreach ($data->images as $imgPath) {
                $image = new ProductImage();
                $image->setPath($imgPath);
                $product->addImage($image);
            }
        }
        
        $this->em->persist($product);
        $this->em->flush();

        return $product;
    }
}
