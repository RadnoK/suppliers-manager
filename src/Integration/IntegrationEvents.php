<?php

declare(strict_types=1);

namespace Integration;

final class IntegrationEvents
{
    /**
     * This event is thrown each time products are get from supplier.
     */
    const SUPPLIER_GET_PRODUCTS = 'supplier.getProducts';
}
