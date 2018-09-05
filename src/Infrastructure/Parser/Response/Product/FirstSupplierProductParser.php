<?php

declare(strict_types=1);

namespace App\Infrastructure\Parser\Response\Product;

use App\Infrastructure\Parser\Exception\InvalidProductException;
use App\Infrastructure\Parser\Exception\InvalidSupplierException;
use App\Infrastructure\Parser\Response\ProductResponse;

final class FirstSupplierProductParser implements ProductParserInterface
{
    public const NAME = 'first';

    public const FILE = 'supplier1.xml';

    public function parseResponse(string $response): array
    {
        $this->validateResponse($response);

        $products = [];

        $content = \simplexml_load_string($response);

        foreach ($content as $product) {
            $this->validateProduct($product);

            $products[] = new ProductResponse(
                (string) $product->id,
                (string) $product->name,
                (string) $product->desc
            );
        }

        return $products;
    }

    private function validateResponse(string $response): void
    {
        if (!empty($response)) {
            return;
        }

        throw new InvalidSupplierException();
    }

    private function validateProduct(object $product): void
    {
        if (property_exists($product, 'id') &&
            property_exists($product, 'name') &&
            property_exists($product, 'desc')
        ) {
            return;
        }

        throw new InvalidProductException();
    }
}
