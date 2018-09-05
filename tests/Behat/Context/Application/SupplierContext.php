<?php

declare(strict_types=1);

namespace Tests\App\Behat\Context\Application;

use App\Application\Command\CreateSupplier;
use App\Application\Repository\Suppliers;
use App\Domain\Supplier\Model\Id;
use Behat\Behat\Context\Context;
use Prooph\ServiceBus\CommandBus;
use Ramsey\Uuid\Uuid;

final class SupplierContext implements Context
{
    /** @var CommandBus */
    private $commandBus;

    /** @var Suppliers */
    private $suppliers;

    public function __construct(CommandBus $commandBus, Suppliers $suppliers)
    {
        $this->commandBus = $commandBus;
        $this->suppliers = $suppliers;
    }

    /**
     * @When I create a :name supplier
     */
    public function iCreateSupplier(string $name): void
    {
        $id = Id::fromUuidInstance(Uuid::uuid4());

        $this->commandBus->dispatch(CreateSupplier::create($id, $name));
    }

    /**
     * @Then the :name supplier should be in the system
     */
    public function theSupplierShouldBeInTheSystem(string $name): void
    {
        $this->suppliers->getOneByName($name);
    }
}
