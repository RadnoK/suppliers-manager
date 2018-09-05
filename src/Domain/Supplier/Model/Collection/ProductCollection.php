<?php

declare(strict_types=1);

namespace App\Domain\Supplier\Model\Collection;

use App\Domain\Supplier\Exception\ProductAlreadyExistsException;
use App\Domain\Supplier\Exception\ProductNotFoundException;
use App\Domain\Supplier\Model\Product;

final class ProductCollection implements \JsonSerializable
{
    /** @var array */
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

    public function add(Product $product): void
    {
        $code = $product->code();

        if ($this->exists($code)) {
            throw new ProductAlreadyExistsException();
        }

        $this->products[$code] = $product;
    }

    public function remove(string $code): void
    {
        $product = $this->get($code);

        unset($this->products[$product->code()]);
    }

    public function get(string $code): Product
    {
        if (!$this->exists($code)) {
            throw new ProductNotFoundException();
        }

        return $this->products[$code];
    }

    public function exists(string $code): bool
    {
        return array_key_exists($code, $this->products);
    }

    public function count(): int
    {
        return count($this->products);
    }

    public function toArray(): array
    {
        return $this->products;
    }

    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }
}
