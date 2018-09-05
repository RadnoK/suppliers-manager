<?php

declare(strict_types=1);

namespace spec\App\Supplier\Parser\Products;

use App\Supplier\Exception\InvalidSupplierProductException;
use App\Supplier\Exception\InvalidSupplierResponseException;
use App\Supplier\Model\Collection\ProductCollection;
use App\Supplier\Model\Product;
use App\Supplier\Parser\Products\ProductsParserInterface;
use PhpSpec\ObjectBehavior;

final class FirstSupplierProductsParserSpec extends ObjectBehavior
{
    function it_is_a_parser(): void
    {
        $this->shouldImplement(ProductsParserInterface::class);
    }

    function it_parses_a_valid_supplier_xml_response(): void
    {
        $this
            ->parse('<?xml version="1.0" encoding="UTF-8"?><products><product><id>123-456-1</id><name>Product 1</name><desc>Product 1 description</desc></product></products>')
            ->shouldBeLike(ProductCollection::fromArray([
                new Product('123-456-1', 'Product 1', 'Product 1 description'),
            ]))
        ;
    }

    function it_throws_an_exception_when_xml_response_is_invalid(): void
    {
        $this
            ->shouldThrow(InvalidSupplierResponseException::class)
            ->during('parse', [''])
        ;

        $this
            ->shouldThrow(InvalidSupplierProductException::class)
            ->during('parse', ['<?xml version="1.0" encoding="UTF-8"?><products><product><key>123-456-1</key><title>Product 1</title><description>Product 1 description</description></product></products>'])
        ;
    }
}
