<?php

declare(strict_types=1);

namespace App\Infrastructure\ReadModel\View;

class ProductView
{
    /** @var string */
    private $id;

    /** @var string */
    private $code;

    /** @var string|null */
    private $description;

    public function __construct(string $id, string $code, ?string $description)
    {
        $this->id = $id;
        $this->code = $code;
        $this->description = $description;
    }

    public function getId(): ?string
    {
        return $this->id;
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
