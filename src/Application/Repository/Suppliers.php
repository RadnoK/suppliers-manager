<?php

declare(strict_types=1);

namespace App\Application\Repository;

use App\Application\Exception\SupplierNotFoundException;
use App\Domain\Supplier\Model\Id;
use App\Domain\Supplier\Model\Supplier;

interface Suppliers
{
    public function add(Supplier $supplier): void;

    public function save(): void;

    /**
     * @throws SupplierNotFoundException
     */
    public function get(Id $id): Supplier;

    /**
     * @throws SupplierNotFoundException
     */
    public function getOneByName(string $name): Supplier;

    public function getAll(): array;
}
