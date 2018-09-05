<?php

declare(strict_types=1);

namespace App\Infrastructure\ReadModel\View;

class ProductView
{
    /** @var string */
    private $id;

    /** @var SupplierView */
    private $supplier;

    /** @var string */
    private $code;

    /** @var string|null */
    private $description;

    public function __construct(string $id, SupplierView $supplierView, string $code, ?string $description)
    {
        $this->id = $id;
        $this->supplier = $supplierView;
        $this->code = $code;
        $this->description = $description;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getSupplier(): SupplierView
    {
        return $this->supplier;
    }

    public function setSupplier(SupplierView $supplier): void
    {
        $this->supplier = $supplier;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }
}
