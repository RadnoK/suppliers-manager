<?php

declare(strict_types=1);

namespace spec\Integration\Supplier\Parser\Products;

use Integration\Supplier\Exception\InvalidSupplierResponseException;
use Integration\Supplier\Model\Collection\ProductCollection;
use Integration\Supplier\Model\Product;
use Integration\Supplier\Parser\Products\ProductsParserInterface;
use PhpSpec\ObjectBehavior;

final class ThirdSupplierProductsParserSpec extends ObjectBehavior
{
    function it_is_a_parser(): void
    {
        $this->shouldImplement(ProductsParserInterface::class);
    }

    function it_parses_a_supplier_json_response(): void
    {
        $this
            ->parse('{"list": [{"id": "999-ABC-DEF-1","name": "Product 1"}]}')
            ->shouldBeLike(ProductCollection::fromArray([
                new Product('999-ABC-DEF-1', 'Product 1'),
            ]))
        ;
    }

    function it_throws_an_exception_when_json_response_is_invalid(): void
    {
        $this
            ->shouldThrow(InvalidSupplierResponseException::class)
            ->during('parse', [''])
        ;
    }
}
