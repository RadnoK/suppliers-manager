<?php

declare(strict_types=1);

namespace spec\App\Application\Handler;

use App\Application\Command\CreateSupplier;
use App\Application\Event\SupplierCreated;
use App\Application\Repository\Suppliers;
use App\Domain\Supplier\Model\Id;
use App\Domain\Supplier\Model\Supplier;
use PhpSpec\ObjectBehavior;
use Prooph\ServiceBus\EventBus;
use Prophecy\Argument;

final class CreateSupplierHandlerSpec extends ObjectBehavior
{
    function let(Suppliers $suppliers, EventBus $eventBus): void
    {
        $this->beConstructedWith($suppliers, $eventBus);
    }

    function it_creates_a_new_supplier(Suppliers $suppliers, EventBus $eventBus): void
    {
        $id = Id::fromString('22561254-a575-46b1-803b-b941fd9410eb');

        $suppliers
            ->add(Argument::exact(Supplier::create(
                $id,
                'Solaris Bus&Coach'
            )))
            ->shouldBeCalled()
        ;

        $eventBus
            ->dispatch(Argument::that(function (SupplierCreated $event) use ($id): bool {
                return
                    $event->id() == $id &&
                    $event->name() === 'Solaris Bus&Coach'
                ;
            }))
            ->shouldBeCalled()
        ;

        $this(CreateSupplier::create($id, 'Solaris Bus&Coach'));
    }
}
