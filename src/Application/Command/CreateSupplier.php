<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Domain\Supplier\Model\Id;
use Prooph\Common\Messaging\Command;
use Prooph\Common\Messaging\PayloadTrait;

final class CreateSupplier extends Command
{
    use PayloadTrait;

    private function __construct(array $payload)
    {
        $this->init();
        $this->setPayload($payload);
    }

    public static function create(Id $id, string $name): self
    {
        return new self([
            'id' => $id->toString(),
            'name' => $name,
        ]);
    }

    public function id(): Id
    {
        return Id::fromString($this->payload()['id']);
    }

    public function name(): string
    {
        return $this->payload()['name'];
    }
}
