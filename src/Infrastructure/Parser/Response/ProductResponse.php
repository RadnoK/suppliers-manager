<?php

declare(strict_types=1);

namespace App\Infrastructure\Parser\Response;

final class ProductResponse
{
    /** @var string */
    private $code;

    /** @var string */
    private $name;

    /** @var string|null */
    private $description;

    public function __construct(string $code, string $name, ?string $description = null)
    {
        $this->code = $code;
        $this->name = $name;
        $this->description = $description;
    }

    public function code(): string
    {
        return $this->code;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function description(): ?string
    {
        return $this->description;
    }
}
