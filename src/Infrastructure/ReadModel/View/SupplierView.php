<?php

declare(strict_types=1);

namespace App\Infrastructure\ReadModel\View;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class SupplierView
{
    /** @var string */
    private $id;

    /** @var string */
    private $name;

    /** @var Collection */
    private $products;

    public function __construct(string $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
        $this->products = new ArrayCollection();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(ProductView $productView): void
    {
        $this->products->add($productView);
    }
}
