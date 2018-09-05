<?php

declare(strict_types=1);

namespace App\Infrastructure\Listener;

use App\Application\Event\ProductAddedToSupplier;
use Psr\Log\LoggerInterface;

final class SuppliersListener
{
    /** @var LoggerInterface */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function __invoke(ProductAddedToSupplier $event): void
    {
        $this->logger->info(
            sprintf('Added product: %s', $event->product()->name()),
            [
                'supplier' => $event->supplierId(),
            ]
        );
    }
}
