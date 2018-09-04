<?php

declare(strict_types=1);

namespace Integration\Supplier\Provider;

use Integration\Supplier\Model\SupplierInterface;

interface ProviderInterface
{
    public function getByName(string $name): SupplierInterface;
}
