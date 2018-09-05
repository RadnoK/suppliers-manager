<?php

declare(strict_types=1);

namespace App\Infrastructure\ReadModel\Repository;

use App\Infrastructure\ReadModel\View\SupplierView;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineSupplierViewRepository implements SupplierViewRepositoryInterface
{
    /** @var EntityManagerInterface */
    private $objectManager;

    /** @var ObjectRepository */
    private $objectRepository;

    public function __construct(EntityManagerInterface $objectManager)
    {
        $this->objectManager = $objectManager;
        $this->objectRepository = $objectManager->getRepository(SupplierView::class);
    }

    public function save(SupplierView $supplierView): void
    {
        $this->objectManager->persist($supplierView);
        $this->objectManager->flush();
    }
}
