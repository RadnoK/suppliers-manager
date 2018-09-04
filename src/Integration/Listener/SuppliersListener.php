<?php

declare(strict_types=1);

namespace Integration\Listener;

use Integration\Supplier\Event\SupplierSynchronized;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\Event;

final class SuppliersListener
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function onReadFromStream(Event $supplier): void
    {
        if (!$supplier instanceof SupplierSynchronized) {
            return;
        }

        foreach ($supplier->products() as $product) {
            $this->logger->info(
                sprintf('Added product: %s', $product['name']),
                [
                    'supplier' => $supplier->name(),
                ]
            );
        }
    }
}
