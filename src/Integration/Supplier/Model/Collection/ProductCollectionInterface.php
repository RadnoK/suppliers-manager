<?php

declare(strict_types=1);

namespace Integration\Supplier\Model\Collection;

use Integration\Supplier\Model\ProductInterface;

interface ProductCollectionInterface
{
    public function add(ProductInterface $product): void;

    public function remove(string $id): void;

    public function get(string $id): ProductInterface;

    public function exists(string $id): bool;

    public function count(): int;

    public function toArray(): array;
}
