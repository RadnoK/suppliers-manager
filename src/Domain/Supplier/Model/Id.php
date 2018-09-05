<?php

declare(strict_types=1);

namespace App\Domain\Supplier\Model;

use App\Domain\Supplier\Exception\InvalidUuidFormatException;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class Id
{
    /** @var string */
    private $id;

    private function __construct(string $id)
    {
        if (!Uuid::isValid($id)) {
            throw new InvalidUuidFormatException();
        }

        $this->id = $id;
    }

    public static function fromString(string $id): self
    {
        return new self($id);
    }

    public static function fromUuidInstance(UuidInterface $id): self
    {
        return new self($id->toString());
    }

    public function toString(): string
    {
        return $this->id;
    }

    public function __toString(): string
    {
        return $this->toString();
    }
}
