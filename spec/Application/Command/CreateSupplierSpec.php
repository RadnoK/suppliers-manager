<?php

declare(strict_types=1);

namespace spec\App\Application\Command;

use App\Domain\Supplier\Model\Id;
use PhpSpec\ObjectBehavior;

final class CreateSupplierSpec extends ObjectBehavior
{
    function it_represents_an_immutable_intention_of_creating_a_supplier(): void
    {
        $id = Id::fromString('5a1b2f12-6842-4a74-8b4a-735b143df67e');

        $this->beConstructedThrough('create', [$id, 'Solaris Bus&Coach']);

        $this->id()->shouldBeLike($id);
        $this->name()->shouldBe('Solaris Bus&Coach');
    }
}
