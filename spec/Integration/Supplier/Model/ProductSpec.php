<?php

declare(strict_types=1);

namespace spec\Integration\Supplier\Model;

use Integration\Supplier\Model\ProductInterface;
use PhpSpec\ObjectBehavior;

final class ProductSpec extends ObjectBehavior
{
    function let(): void
    {
        $this->beConstructedWith('123-456-1', 'Product 1', 'Test description');
    }

    function it_is_a_product(): void
    {
        $this->shouldImplement(ProductInterface::class);
    }

    function it_has_an_id(): void
    {
        $this->id()->shouldReturn('123-456-1');
    }

    function it_has_a_name(): void
    {
        $this->name()->shouldReturn('Product 1');
    }

    function it_has_a_description(): void
    {
        $this->description()->shouldReturn('Test description');
    }

    function its_description_can_be_empty(): void
    {
        $this->beConstructedWith('123-456-1', 'Product 1');

        $this->description()->shouldReturn(null);
    }
}
