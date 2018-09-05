<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Repository;

use App\Application\Exception\SupplierNotFoundException;
use App\Application\Repository\Suppliers;
use App\Domain\Supplier\Model\Id;
use App\Domain\Supplier\Model\Supplier;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;

final class DoctrineSupplierRepository implements Suppliers
{
    /** @var ObjectManager */
    private $objectManager;

    /** @var ObjectRepository */
    private $supplierRepository;

    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
        $this->supplierRepository = $objectManager->getRepository(Supplier::class);
    }

    public function add(Supplier $supplier): void
    {
        $this->objectManager->persist($supplier);
        $this->objectManager->flush();
    }

    public function save(): void
    {
        $this->objectManager->flush();
    }

    public function get(Id $id): Supplier
    {
        /** @var Supplier|null $supplier */
        $supplier = $this->supplierRepository->find($id);

        if (null === $supplier) {
            throw new SupplierNotFoundException();
        }

        return $supplier;
    }

    public function getOneByName(string $name): Supplier
    {
        /** @var Supplier|null $supplier */
        $supplier = $this->supplierRepository->findOneBy(['name' => $name]);

        if (null === $supplier) {
            throw new SupplierNotFoundException();
        }

        return $supplier;
    }

    public function getAll(): array
    {
        return $this->supplierRepository->findAll();
    }
}
