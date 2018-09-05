<?php

declare(strict_types=1);

namespace App\Infrastructure\Parser\Response\Product;

interface ProductParserInterface
{
    public function parseResponse(string $response): array;
}
