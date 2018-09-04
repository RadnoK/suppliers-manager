<?php

declare(strict_types=1);

namespace Integration\Cli;

use Integration\Supplier\Model\SupplierInterface;
use Integration\Supplier\Provider\ProviderInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Stopwatch\Stopwatch;

final class SynchronizeSuppliersAction extends Command
{
    private const COMMAND_ID = 'integration.synchronize.suppliers';

    /**
     * @var ProviderInterface
     */
    private $supplierProvider;

    /**
     * @var SymfonyStyle
     */
    private $io;

    /**
     * @var string
     */
    private $supplierName;

    public function __construct(ProviderInterface $supplierProvider)
    {
        parent::__construct();

        $this->supplierProvider = $supplierProvider;
    }

    protected function configure(): void
    {
        $this
            ->setName('integration:synchronize:suppliers')
            ->setDescription('Synchronize one or more suppliers')
            ->addArgument(
                'supplier',
                InputArgument::REQUIRED,
                'Which supplier do you want to synchronize?'
            )
        ;
    }

    protected function initialize(InputInterface $input, OutputInterface $output): void
    {
        $this->io = new SymfonyStyle($input, $output);
        $this->io->title('Supplier Synchronization');
    }

    protected function interact(InputInterface $input, OutputInterface $output): void
    {
        $this->supplierName = $input->getArgument('supplier');
    }

    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $stopwatch = new Stopwatch();
        $stopwatch->start(self::COMMAND_ID);

        try {
            /** @var SupplierInterface $supplier */
            $supplier = $this->supplierProvider->getByName($this->supplierName);

            $this->io->table(['ID', 'Name', 'Desc'], $supplier->products()->toArray());
            $this->io->success(sprintf('Successfully synchronized supplier "%s"', $supplier->name()));
        } catch (\InvalidArgumentException | \Exception $e) {
            throw new \RuntimeException('Cannot synchronize given supplier.');
        }

        $event = $stopwatch->stop(self::COMMAND_ID);

        if ($output->isVerbose()) {
            $this->io->comment(sprintf(
                'Synchronized suppliers: %d / Elapsed time: %.2f ms / Consumed memory: %.2f MB',
                $supplier->products()->count(),
                $event->getDuration(),
                $event->getMemory() / (1024 ** 2)
            ));
        }
    }
}
