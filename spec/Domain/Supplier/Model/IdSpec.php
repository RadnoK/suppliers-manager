<?php

declare(strict_types=1);

namespace spec\App\Domain\Supplier\Model;

use PhpSpec\ObjectBehavior;
use Ramsey\Uuid\UuidInterface;

final class IdSpec extends ObjectBehavior
{
    function it_can_be_created_from_string(): void
    {
        $this->beConstructedThrough('fromString', ['b95ef608-4963-401d-93f6-cdf69d3e3550']);

        $this->toString()->shouldReturn('b95ef608-4963-401d-93f6-cdf69d3e3550');
    }

    function it_can_be_created_from_uuid_instance(UuidInterface $id): void
    {
        $id->toString()->willReturn('b95ef608-4963-401d-93f6-cdf69d3e3550');

        $this->beConstructedThrough('fromUuidInstance', [$id]);

        $this->toString()->shouldReturn('b95ef608-4963-401d-93f6-cdf69d3e3550');
    }
}
