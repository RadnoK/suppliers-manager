<?php

declare(strict_types=1);

namespace Integration\Supplier\Model\Collection;

use Integration\Supplier\Exception\ProductAlreadyExistsException;
use Integration\Supplier\Exception\ProductNotFoundException;
use Integration\Supplier\Model\ProductInterface;

final class ProductCollection implements ProductCollectionInterface
{
    /**
     * @var array
     */
    private $products = [];

    public function __construct(array $products = [])
    {
        $this->products = $products;
    }

    public static function fromArray(array $products): self
    {
        $productCollection = self::createEmpty();
        foreach ($products as $product) {
            $productCollection->add($product);
        }

        return $productCollection;
    }

    public static function createEmpty(): self
    {
        return new self();
    }

    public function add(ProductInterface $product): void
    {
        $id = $product->id();

        if ($this->exists($id)) {
            throw new ProductAlreadyExistsException();
        }

        $this->products[$id] = $product;
    }

    public function remove(string $id): void
    {
        $product = $this->get($id);

        unset($this->products[$product->id()]);
    }

    public function get(string $id): ProductInterface
    {
        if (!$this->exists($id)) {
            throw new ProductNotFoundException();
        }

        return $this->products[$id];
    }

    public function exists(string $id): bool
    {
        return array_key_exists($id, $this->products);
    }

    public function count(): int
    {
        return count($this->products);
    }

    public function toArray(): array
    {
        $products = [];

        /** @var ProductInterface $product */
        foreach ($this->products as $product) {
            $products[$product->id()] = $product->toArray();
        }

        return $products;
    }
}
