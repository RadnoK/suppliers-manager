<?php

declare(strict_types=1);

namespace spec\App\Application\Event;

use App\Domain\Supplier\Model\Id;
use PhpSpec\ObjectBehavior;

final class SupplierCreatedSpec extends ObjectBehavior
{
    function it_represents_an_immutable_fact_that_a_supplier_has_been_created(): void
    {
        $id = Id::fromString('5a1b2f12-6842-4a74-8b4a-735b143df67e');

        $this->beConstructedThrough('occur', [$id, 'Solaris Bus&Coach']);

        $this->id()->shouldBeLike($id);
        $this->name()->shouldBe('Solaris Bus&Coach');
    }
}
