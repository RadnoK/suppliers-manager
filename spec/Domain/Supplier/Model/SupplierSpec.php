<?php

declare(strict_types=1);

namespace spec\App\Domain\Supplier\Model;

use App\Domain\Supplier\Model\Id;
use App\Domain\Supplier\Model\Product;
use PhpSpec\ObjectBehavior;

final class SupplierSpec extends ObjectBehavior
{
    function let(): void
    {
        $this->beConstructedThrough('create', [
            Id::fromString('94edf90b-efbc-42db-af0e-6ea163922148'),
            'Solaris Bus&Coach',
        ]);
    }

    function it_has_an_id(): void
    {
        $id = Id::fromString('94edf90b-efbc-42db-af0e-6ea163922148');

        $this->beConstructedThrough('create', [
            $id,
            'Solaris Bus&Coach',
        ]);

        $this->id()->shouldBeLike($id);
    }

    function it_has_a_name(): void
    {
        $this->name()->shouldReturn('Solaris Bus&Coach');
    }

    function it_can_have_products(): void
    {
        $this->addProduct(new Product(
            'super-tram',
            'Solaris Tramino'
        ));
    }
}
