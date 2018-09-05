<?php

declare(strict_types=1);

namespace App\Infrastructure\Cli;

use App\Application\Command\CreateSupplier;
use App\Domain\Supplier\Model\Id;
use Prooph\ServiceBus\CommandBus;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Stopwatch\Stopwatch;

final class CreateSupplierAction extends Command
{
    private const COMMAND_ID = 'app.create.supplier';

    /** @var SymfonyStyle */
    private $io;

    /** @var CommandBus */
    private $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        parent::__construct();

        $this->commandBus = $commandBus;
    }

    protected function configure(): void
    {
        $this
            ->setName('app:create:supplier')
            ->setDescription('Create a new supplier')
            ->addArgument(
                'name',
                InputArgument::REQUIRED,
                'Create a new Supplier with a name'
            )
        ;
    }

    protected function initialize(InputInterface $input, OutputInterface $output): void
    {
        $this->io = new SymfonyStyle($input, $output);
    }

    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $stopwatch = new Stopwatch();
        $stopwatch->start(self::COMMAND_ID);

        $id = Uuid::uuid4();

        $name = $input->getArgument('name');

        try {
            $this->commandBus->dispatch(CreateSupplier::create(Id::fromUuidInstance($id), $name));

            $this->io->success(sprintf(
                'Successfully created a new %s Supplier [ID: %s]',
                $name,
                $id->toString()
            ));
        } catch (\Exception $e) {
            var_dump($e->getPrevious()->getMessage());die;
            throw new \RuntimeException('Cannot create a new Supplier.');
        }

        $event = $stopwatch->stop(self::COMMAND_ID);

        if ($output->isVerbose()) {
            $this->io->comment(sprintf(
                'Created supplier with ID: %s / Elapsed time: %.2f ms / Consumed memory: %.2f MB',
                $id,
                $event->getDuration(),
                $event->getMemory() / (1024 ** 2)
            ));
        }
    }
}
