<?php

declare(strict_types=1);

namespace App\Infrastructure\Parser\Products;

final class FirstSupplierProductsResponseParser implements ProductsResponseParserInterface
{
    public const NAME = 'first';

    public function parse(string $response): array
    {
        $this->validateResponse($response);

        $content = \simplexml_load_string($response);

        foreach ($content as $product) {
            $this->validateProduct($product);

            $products->add(new Product(
                (string) $product->id,
                (string) $product->name,
                (string) $product->desc
            ));
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

    private function validateProduct(object $product): void
    {
        if (property_exists($product, 'id') &&
            property_exists($product, 'name') &&
            property_exists($product, 'desc')
        ) {
            return;
        }

        throw new InvalidSupplierProductException();
    }
}
