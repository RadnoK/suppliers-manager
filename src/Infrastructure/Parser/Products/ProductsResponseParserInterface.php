<?php

declare(strict_types=1);

namespace App\Infrastructure\Parser\Products;

interface ProductsResponseParserInterface
{
    public function parseResponse(string $response): array;
}
