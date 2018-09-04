<?php

declare(strict_types=1);

namespace spec\Integration\Supplier\Event;

use PhpSpec\ObjectBehavior;

final class SupplierSynchronizedSpec extends ObjectBehavior
{
    function let(): void
    {
        $this->beConstructedWith('Supplier 1', []);
    }

    function it_has_a_name(): void
    {
        $this->name()->shouldReturn('Supplier 1');
    }

    function it_has_products(): void
    {
        $this->products()->shouldBeArray();
    }
}
