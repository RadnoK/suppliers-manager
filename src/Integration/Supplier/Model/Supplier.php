<?php

declare(strict_types=1);

namespace Integration\Supplier\Model;

use Integration\Supplier\Model\Collection\ProductCollectionInterface;

final class Supplier implements SupplierInterface
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var ProductCollectionInterface
     */
    private $products;

    public function __construct(string $name, ProductCollectionInterface $products)
    {
        $this->name = $name;
        $this->products = $products;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function products(): ProductCollectionInterface
    {
        return $this->products;
    }
}
