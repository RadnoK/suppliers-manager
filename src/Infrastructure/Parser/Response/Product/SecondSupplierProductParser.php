<?php

declare(strict_types=1);

namespace App\Infrastructure\Parser\Response\Product;

use App\Infrastructure\Parser\Exception\InvalidProductException;
use App\Infrastructure\Parser\Exception\InvalidSupplierException;
use App\Infrastructure\Parser\Response\ProductResponse;

final class SecondSupplierProductParser implements ProductParserInterface
{
    public const NAME = 'second';

    public const FILE = 'supplier2.xml';

    public function parseResponse(string $response): array
    {
        $this->validateResponse($response);

        $products = [];

        $content = \simplexml_load_string($response);

        foreach ($content as $product) {
            $this->validateProduct($product);

            $products[] = new ProductResponse(
                (string) $product->key,
                (string) $product->title,
                (string) $product->description
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
        if (property_exists($product, 'key') &&
            property_exists($product, 'title') &&
            property_exists($product, 'description')
        ) {
            return;
        }

        throw new InvalidProductException();
    }
}
