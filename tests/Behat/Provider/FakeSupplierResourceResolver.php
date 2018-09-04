<?php

declare(strict_types=1);

namespace Tests\Integration\Behat\Provider;

use Integration\Supplier\Resolver\ResolverInterface;

class FakeSupplierResourceResolver implements ResolverInterface
{
    private static $suppliers = [
        'first' => 'supplier1.xml',
        'second' => 'supplier2.xml',
        'third' => 'supplier3.json',
    ];

    public function findByName(string $name): string
    {
        return file_get_contents(sprintf('%s/../Resources/fixtures/%s', __DIR__, self::$suppliers[$name]));
    }
}
