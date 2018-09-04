<?php

declare(strict_types=1);

namespace Integration\Supplier\Event;

use Symfony\Component\EventDispatcher\Event;

final class SupplierSynchronized extends Event
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var array
     */
    protected $products;

    public function __construct(string $supplierName, array $products)
    {
        $this->name = $supplierName;
        $this->products = $products;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function products(): array
    {
        return $this->products;
    }
}
