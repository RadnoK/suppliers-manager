<?php

declare(strict_types=1);

namespace Integration\Supplier\Parser\Products;

use Integration\Supplier\Model\Collection\ProductCollectionInterface;

interface ProductsParserInterface
{
    public function parse(string $response): ProductCollectionInterface;
}
