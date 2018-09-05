<?php

declare(strict_types=1);

namespace App\Domain\Supplier\Model;

use App\Domain\Supplier\Model\Collection\ProductCollection;

class Supplier
{
    /** @var Id */
    private $id;

    /** @var string */
    private $name;

    /** @var ProductCollection */
    private $products;

    private function __construct(Id $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
        $this->products = ProductCollection::createEmpty();
    }

    public static function create(Id $id, string $name): self
    {
        return new self($id, $name);
    }

    public function id(): Id
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function addProduct(Product $product): void
    {
        $this->products->add($product);
    }
}
