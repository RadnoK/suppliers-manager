<?php

declare(strict_types=1);

namespace App\Infrastructure\Parser\Products;

use App\Supplier\Exception\InvalidSupplierProductException;
use App\Supplier\Exception\InvalidSupplierResponseException;
use App\Supplier\Model\Collection\ProductCollection;
use App\Supplier\Model\Collection\ProductCollectionInterface;
use App\Supplier\Model\Product;

final class ThirdSupplierProductsResponseParser implements ProductsResponseParserInterface
{
    public const NAME = 'third';

    public function parse(string $response): ProductCollectionInterface
    {
        $products = ProductCollection::createEmpty();

        $this->validateResponse($response);

        $content = \json_decode($response, true);

        foreach ($content['list'] as $product) {
            $this->validateProduct($product);

            $products->add(new Product(
                (string) $product['id'],
                (string) $product['name'])
            );
        }

        return $products;
    }

    private function validateResponse(string $response): void
    {
        if (!empty($response)) {
            return;
        }

        throw new InvalidSupplierResponseException();
    }

    private function validateProduct(array $product): void
    {
        if (array_key_exists('id', $product) && array_key_exists('name', $product)) {
            return;
        }

        throw new InvalidSupplierProductException();
    }
}
