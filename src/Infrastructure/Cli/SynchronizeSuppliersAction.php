<?php

declare(strict_types=1);

namespace App\Infrastructure\Cli;

use App\Application\Command\AddProductToSupplier;
use App\Domain\Supplier\Model\Id;
use App\Domain\Supplier\Model\Product;
use App\Infrastructure\Parser\Response\ProductResponse;
use App\Infrastructure\Provider\SupplierProviderInterface;
use App\Infrastructure\ReadModel\Repository\SupplierViewRepositoryInterface;
use Prooph\ServiceBus\CommandBus;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Stopwatch\Stopwatch;

final class SynchronizeSuppliersAction extends Command
{
    private const COMMAND_ID = 'app.synchronize.suppliers';

    /** @var SymfonyStyle */
    private $io;

    /** @var string */
    private $supplierName;

    /** @var SupplierProviderInterface */
    private $supplierProvider;

    /** @var SupplierViewRepositoryInterface */
    private $supplierViewRepository;

    /** @var CommandBus */
    private $commandBus;

    public function __construct(
        SupplierProviderInterface $supplierProvider,
        SupplierViewRepositoryInterface $supplierViewRepository,
        CommandBus $commandBus
    ) {
        parent::__construct();

        $this->supplierProvider = $supplierProvider;
        $this->supplierViewRepository = $supplierViewRepository;
        $this->commandBus = $commandBus;
    }

    protected function configure(): void
    {
        $this
            ->setName('app:synchronize:suppliers')
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
            $supplier = $this->supplierViewRepository->findOneByName($this->supplierName);

            $newProducts = $this->supplierProvider->getProducts($this->supplierName);

            /** @var ProductResponse $product */
            foreach ($newProducts as $product) {
                $this->commandBus->dispatch(AddProductToSupplier::create(
                    Id::fromString($supplier->getId()),
                    new Product($product->code(), $product->name(), $product->description())
                ));
            }

            $supplier = $this->supplierViewRepository->findOneByName($this->supplierName);

            $this->io->table(['ID', 'Name', 'Desc'], $supplier->getProducts()->toArray());
            $this->io->success(sprintf('Successfully synchronized supplier "%s"', $supplier->name()));
        } catch (\InvalidArgumentException | \Exception $e) {
            var_dump($e->getMessage());die;
            throw new \RuntimeException('Cannot synchronize given supplier.');
        }

        $event = $stopwatch->stop(self::COMMAND_ID);

        if ($output->isVerbose()) {
            $this->io->comment(sprintf(
                'Synchronized suppliers: %d / Elapsed time: %.2f ms / Consumed memory: %.2f MB',
                1,//$supplier->products()->count(),
                $event->getDuration(),
                $event->getMemory() / (1024 ** 2)
            ));
        }
    }
}
