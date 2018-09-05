<?php

declare(strict_types=1);

namespace App\Infrastructure\Provider;

use App\Infrastructure\Provider\Exception\ProviderNotFoundException;

final class SupplierProvider implements ProviderInterface
{
    public function __invoke(string $name)
    {
        $response = $this->supplierResourceResolver->findByName($name);

        $products = $this->getSupplierParser($name)->parse($response);

    }

    private function getSupplierParser(string $supplierName)
    {
        switch ($supplierName) {
            case FirstSupplierProductsParser::NAME:
                return new FirstSupplierProductsParser();
            case SecondSupplierProductsParser::NAME:
                return new SecondSupplierProductsParser();
            case ThirdSupplierProductsParser::NAME:
                return new ThirdSupplierProductsParser();
        }

        throw new ProviderNotFoundException();
    }
}
