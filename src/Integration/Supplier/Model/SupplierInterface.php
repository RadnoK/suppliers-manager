<?php

declare(strict_types=1);

namespace Integration\Supplier\Model;

use Integration\Supplier\Model\Collection\ProductCollectionInterface;

interface SupplierInterface
{
    public function name(): string;

    public function products(): ProductCollectionInterface;
}
