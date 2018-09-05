<?php

declare(strict_types=1);

namespace App\Application\Handler;

use App\Application\Command\AddProductToSupplier;
use App\Application\Event\ProductAddedToSupplier;
use App\Application\Repository\Suppliers;
use Prooph\ServiceBus\EventBus;

final class AddProductToSupplierHandler
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

    public function __invoke(AddProductToSupplier $command): void
    {
        $supplier = $this->suppliers->get($command->supplierId());
        $supplier->addProduct($command->product());

        $this->suppliers->save();

        $this->eventBus->dispatch(ProductAddedToSupplier::occur(
            $command->supplierId(),
            $command->product()
        ));
    }
}
