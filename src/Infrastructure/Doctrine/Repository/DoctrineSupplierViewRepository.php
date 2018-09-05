<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Repository;

use App\Application\Exception\SupplierNotFoundException;
use App\Infrastructure\Exception\SupplierViewNotFoundException;
use App\Infrastructure\ReadModel\Repository\SupplierViewRepositoryInterface;
use App\Infrastructure\ReadModel\View\SupplierView;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;

final class DoctrineSupplierViewRepository implements SupplierViewRepositoryInterface
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

    public function findOneByName(string $name): SupplierView
    {
        /** @var SupplierView $supplierView */
        $supplierView = $this->objectRepository->findOneBy(['name' => $name]);

        if (null === $supplierView) {
            throw new SupplierViewNotFoundException();
        }

        return $supplierView;
    }

    public function findAll(): array
    {
        return $this->objectRepository->findAll();
    }
}
