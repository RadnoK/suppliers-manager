<?php

declare(strict_types=1);

namespace App\Infrastructure\ReadModel\Projector;

use App\Application\Event\SupplierCreated;
use App\Infrastructure\Prooph\ApplyMethodDispatcherTrait;
use App\Infrastructure\ReadModel\Repository\SupplierViewRepositoryInterface;
use App\Infrastructure\ReadModel\View\SupplierView;

final class SupplierViewProjector
{
    use ApplyMethodDispatcherTrait {
        apply as __invoke;
    }

    /** @var SupplierViewRepositoryInterface */
    private $supplierViewRepository;

    public function __construct(SupplierViewRepositoryInterface $supplierViewRepository)
    {
        $this->supplierViewRepository = $supplierViewRepository;
    }

    public function applySupplierCreated(SupplierCreated $event): void
    {
        $supplierView = new SupplierView($event->id()->toString(), $event->name());

        $this->supplierViewRepository->save($supplierView);
    }
}
