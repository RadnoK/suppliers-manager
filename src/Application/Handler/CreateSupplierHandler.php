<?php

declare(strict_types=1);

namespace App\Application\Handler;

use App\Application\Command\CreateSupplier;
use App\Application\Event\SupplierCreated;
use App\Application\Repository\Suppliers;
use App\Domain\Supplier\Model\Supplier;
use Prooph\ServiceBus\EventBus;

final class CreateSupplierHandler
{
    /** @var Suppliers */
    private $suppliers;

    /** @var EventBus */
    private $eventBus;

    public function __construct(Suppliers $suppliers, EventBus $eventBus)
    {
        $this->suppliers = $suppliers;
        $this->eventBus = $eventBus;
    }

    public function __invoke(CreateSupplier $command): void
    {
        $supplier = Supplier::create($command->id(), $command->name());

        $this->suppliers->add($supplier);

        $this->eventBus->dispatch(SupplierCreated::occur($command->id(), $command->name()));
    }
}
