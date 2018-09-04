<?php

declare(strict_types=1);

namespace spec\Integration\Supplier\Model;

use Integration\Supplier\Model\Collection\ProductCollection;
use Integration\Supplier\Model\Product;
use PhpSpec\ObjectBehavior;

final class SupplierSpec extends ObjectBehavior
{
    function let(): void
    {
        $this->beConstructedWith('Supplier 1', ProductCollection::fromArray([
            new Product('123-456-1', 'Product 1'),
            new Product('123-456-2', 'Product 2'),
        ]));
    }

    function it_has_a_name(): void
    {
        $this->name()->shouldReturn('Supplier 1');
    }

    function it_has_products(): void
    {
        $this->products()->shouldBeLike(ProductCollection::fromArray([
            new Product('123-456-1', 'Product 1'),
            new Product('123-456-2', 'Product 2'),
        ]));
    }
}
