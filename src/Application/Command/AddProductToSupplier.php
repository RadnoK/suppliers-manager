<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Domain\Supplier\Model\Id;
use App\Domain\Supplier\Model\Product;
use Prooph\Common\Messaging\Command;
use Prooph\Common\Messaging\PayloadTrait;

final class AddProductToSupplier extends Command
{
    use PayloadTrait;

    private function __construct(array $payload)
    {
        $this->init();
        $this->setPayload($payload);
    }

    public static function create(Id $supplierId, Product $product): self
    {
        return new self([
            'supplier_id' => $supplierId->toString(),
            'product' => [
                'code' => $product->code(),
                'name' => $product->name(),
            ],
        ]);
    }

    public function supplierId(): Id
    {
        return Id::fromString($this->payload()['supplier_id']);
    }

    public function product(): Product
    {
        return new Product(
            $this->payload()['product']['code'],
            $this->payload()['product']['name']
        );
    }
}
