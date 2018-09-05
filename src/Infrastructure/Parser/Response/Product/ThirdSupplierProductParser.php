<?php

declare(strict_types=1);

namespace App\Infrastructure\Parser\Response\Product;

use App\Infrastructure\Parser\Exception\InvalidProductException;
use App\Infrastructure\Parser\Exception\InvalidSupplierException;
use App\Infrastructure\Parser\Response\ProductResponse;

final class ThirdSupplierProductParser implements ProductParserInterface
{
    public const NAME = 'third';

    public const FILE = 'supplier3.json';

    public function parseResponse(string $response): array
    {
        $this->validateResponse($response);

        $products = [];

        $content = \json_decode($response, true);

        foreach ($content['list'] as $product) {
            $this->validateProduct($product);

            $products[] = new ProductResponse(
                (string) $product['id'],
                (string) $product['name']
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

    private function validateProduct(array $product): void
    {
        if (array_key_exists('id', $product) && array_key_exists('name', $product)) {
            return;
        }

        throw new InvalidProductException();
    }
}
