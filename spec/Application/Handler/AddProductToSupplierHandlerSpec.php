<?php

declare(strict_types=1);

namespace spec\App\Application\Handler;

use App\Application\Command\AddProductToSupplier;
use App\Application\Event\ProductAddedToSupplier;
use App\Application\Repository\Suppliers;
use App\Domain\Supplier\Model\Id;
use App\Domain\Supplier\Model\Product;
use App\Domain\Supplier\Model\Supplier;
use PhpSpec\ObjectBehavior;
use Prooph\ServiceBus\EventBus;
use Prophecy\Argument;

final class AddProductToSupplierHandlerSpec extends ObjectBehavior
{
    function let(Suppliers $suppliers, EventBus $eventBus): void
    {
        $this->beConstructedWith($suppliers, $eventBus);
    }

    function it_adds_products_to_supplier(Suppliers $suppliers, EventBus $eventBus, Supplier $supplier): void
    {
        $supplierId = Id::fromString('a4ab6209-4260-4aeb-b76b-ce77f053cf8b');

        $suppliers->get($supplierId)->willReturn($supplier);

        $supplier->addProduct(new Product('super-tram', 'Solaris Tramino'))->shouldBeCalled();

        $suppliers->save()->shouldBeCalled();

        $eventBus
            ->dispatch(Argument::that(function (ProductAddedToSupplier $event) use ($supplierId): bool {
                return
                    $event->supplierId() == $supplierId &&
                    $event->product() == new Product('super-tram', 'Solaris Tramino')
                ;
            }))
            ->shouldBeCalled()
        ;

        $this(AddProductToSupplier::create($supplierId, new Product('super-tram', 'Solaris Tramino')));
    }
}
