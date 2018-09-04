<?php

declare(strict_types=1);

namespace spec\Integration\Listener;

use Integration\Supplier\Event\SupplierSynchronized;
use PhpSpec\ObjectBehavior;
use Psr\Log\LoggerInterface;

final class SuppliersListenerSpec extends ObjectBehavior
{
    function let(LoggerInterface $logger): void
    {
        $this->beConstructedWith($logger);
    }

    function it_logs_supplier_synchronization_action(LoggerInterface $logger): void
    {
        $event = new SupplierSynchronized('first', [
            '123-456-1' => [
                'id' => '123-456-1',
                'name' => 'Product 1',
                'description' => '',
            ],
        ]);

        $logger
            ->info(
                'Added product: Product 1',
                [
                    'supplier' => $event->name(),
                ]
            )
            ->shouldBeCalled()
        ;

        $this->onReadFromStream($event);
    }
}
