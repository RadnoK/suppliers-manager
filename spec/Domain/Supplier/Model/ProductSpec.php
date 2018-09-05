<?php

declare(strict_types=1);

namespace spec\App\Domain\Supplier\Model;

use App\Domain\Supplier\Model\Product;
use PhpSpec\ObjectBehavior;

final class ProductSpec extends ObjectBehavior
{
    function let(): void
    {
        $this->beConstructedWith('super-tram', 'Solaris Tramino', '2-directional version');
    }

    function it_is_a_product(): void
    {
        $this->shouldImplement(Product::class);
    }

    function it_has_a_code(): void
    {
        $this->code()->shouldReturn('super-tram');
    }

    function it_has_a_name(): void
    {
        $this->name()->shouldReturn('Solaris Tramino');
    }

    function it_has_a_description(): void
    {
        $this->description()->shouldReturn('2-directional version');
    }

    function its_description_can_be_empty(): void
    {
        $this->beConstructedWith('super-tram', 'Solaris Tramino');

        $this->description()->shouldReturn(null);
    }
}
