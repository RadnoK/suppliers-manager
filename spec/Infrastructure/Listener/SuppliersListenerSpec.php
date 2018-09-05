<?php

declare(strict_types=1);

namespace spec\App\Infrastructure\Listener;

use App\Application\Event\ProductAddedToSupplier;
use App\Domain\Supplier\Model\Id;
use App\Domain\Supplier\Model\Product;
use PhpSpec\ObjectBehavior;
use Psr\Log\LoggerInterface;

final class SuppliersListenerSpec extends ObjectBehavior
{
    function let(LoggerInterface $logger): void
    {
        $this->beConstructedWith($logger);
    }

    function it_logs_product_added_to_supplier(LoggerInterface $logger): void
    {
        $id = Id::fromString('4449be3c-9667-4d19-b551-36b1d71b0679');

        $logger
            ->info(
                'Added product: Solaris Tramino',
                [
                    'supplier' => $id->toString(),
                ]
            )
            ->shouldBeCalled()
        ;

        $this(ProductAddedToSupplier::occur($id, new Product('super-tram', 'Solaris Tramino')));
    }
}
