<?php

declare(strict_types=1);

namespace App\Infrastructure\Provider;

interface SupplierProviderInterface
{
    public function getProducts(string $supplierName): array;
}
