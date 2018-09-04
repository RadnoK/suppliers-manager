<?php

declare(strict_types=1);

namespace Integration\Supplier\Parser\Products;

use Integration\Supplier\Exception\InvalidSupplierProductException;
use Integration\Supplier\Exception\InvalidSupplierResponseException;
use Integration\Supplier\Model\Collection\ProductCollection;
use Integration\Supplier\Model\Collection\ProductCollectionInterface;
use Integration\Supplier\Model\Product;

final class FirstSupplierProductsParser implements ProductsParserInterface
{
    public const NAME = 'first';

    public function parse(string $response): ProductCollectionInterface
    {
        $products = ProductCollection::createEmpty();

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
