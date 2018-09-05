<?php

declare(strict_types=1);

namespace spec\App\Application\Command;

use App\Domain\Supplier\Model\Id;
use App\Domain\Supplier\Model\Product;
use PhpSpec\ObjectBehavior;

final class AddProductToSupplierSpec extends ObjectBehavior
{
    function it_represents_an_immutable_intention_of_adding_a_product_to_the_supplier(): void
    {
        $supplierId = Id::fromString('16484838-0cb5-4c63-8f55-0ec8f0039b2f');

        $this->beConstructedThrough('create', [
            $supplierId,
            new Product('super-tram', 'Solaris Tramino'),
        ]);

        $this->supplierId()->shouldBeLike($supplierId);
        $this->product()->shouldBeLike(new Product('super-tram', 'Solaris Tramino'));
    }
}
