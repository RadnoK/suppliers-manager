<?php

declare(strict_types=1);

namespace Integration\Supplier\Model;

interface ProductInterface
{
    public function id(): string;

    public function name(): string;

    public function description(): ?string;

    public function toArray(): array;
}
