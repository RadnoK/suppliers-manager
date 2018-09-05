<?php

declare(strict_types=1);

namespace App\Infrastructure\Parser\Products;

use App\Supplier\Exception\InvalidSupplierProductException;
use App\Supplier\Exception\InvalidSupplierResponseException;
use App\Supplier\Model\Collection\ProductCollection;
use App\Supplier\Model\Collection\ProductCollectionInterface;
use App\Supplier\Model\Product;

final class SecondSupplierProductsResponseParser implements ProductsResponseParserInterface
{
    public const NAME = 'second';

    public function parse($response): ProductCollectionInterface
    {
        $products = ProductCollection::createEmpty();

        $this->validateResponse($response);

        $content = \simplexml_load_string($response);

        foreach ($content as $product) {
            $this->validateProduct($product);

            $products->add(new Product(
                (string) $product->key,
                (string) $product->title,
                (string) $product->description
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
        if (property_exists($product, 'key') && property_exists($product, 'title') && property_exists($product, 'description')) {
            return;
        }

        throw new InvalidSupplierProductException();
    }
}
