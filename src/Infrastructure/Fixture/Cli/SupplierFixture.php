<?php

declare(strict_types=1);

namespace App\Infrastructure\Fixture\Cli;

use App\Application\Command\CreateSupplier;
use App\Domain\Supplier\Model\Id;
use Prooph\ServiceBus\CommandBus;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

final class SupplierFixture extends Command
{
    /** @var array */
    private $suppliers = [
        'first',
        'second',
        'third',
    ];

    /** @var CommandBus */
    private $commandBus;

    /** @var SymfonyStyle */
    private $io;

    public function __construct(CommandBus $commandBus)
    {
        parent::__construct();

        $this->commandBus = $commandBus;
    }

    protected function configure(): void
    {
        $this
            ->setName('app:fixtures:load')
            ->setDescription('Fill the database with test data')
        ;
    }

    protected function initialize(InputInterface $input, OutputInterface $output): void
    {
        $this->io = new SymfonyStyle($input, $output);
    }

    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        foreach ($this->suppliers as $supplierName) {
            $id = Id::fromUuidInstance(Uuid::uuid4());

            $this->commandBus->dispatch(CreateSupplier::create($id, $supplierName));
        }

        $this->io->success(sprintf('Successfully created %d suppliers', count($this->suppliers)));
    }
}

