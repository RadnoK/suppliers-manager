<?php

declare(strict_types=1);

namespace spec\App\Supplier\Provider;

use App\Supplier\Event\SupplierCreated;
use App\Supplier\Model\Collection\ProductCollection;
use App\Supplier\Model\Collection\ProductCollectionInterface;
use App\Supplier\Model\Product;
use App\Supplier\Model\Supplier;
use App\Supplier\Parser\Products\ProductsParserInterface;
use App\Supplier\Resolver\ResolverInterface;
use PhpSpec\ObjectBehavior;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

final class SupplierProviderSpec extends ObjectBehavior
{
    function let(EventDispatcherInterface $eventDispatcher, ResolverInterface $supplierResolver): void
    {
        $this->beConstructedWith($eventDispatcher, $supplierResolver);
    }

    function it_provides_a_supplier_when_it_exists(
        ResolverInterface $supplierResolver,
        ProductsParserInterface $productsParser,
        ProductCollectionInterface $productCollection,
        EventDispatcherInterface $eventDispatcher
    ): void {
        $supplierResolver
            ->findByName('third')
            ->willReturn('{"list": [{"id": "999-ABC-DEF-1","name": "Product 1"}]}')
        ;

        $productsParser
            ->parse('{"list": [{"id": "999-ABC-DEF-1","name": "Product 1"}]}')
            ->willReturn($productCollection)
        ;

        $productCollection->toArray()->willReturn([
            new Product('999-ABC-DEF-1', 'Product 1'),
        ]);

        $eventDispatcher->dispatch(
            'supplier.getProducts',
            new SupplierCreated(
                'third',
                [
                    new Product('999-ABC-DEF-1', 'Product 1'),
                ]
            )
        );

        $this
            ->getByName('third')
            ->shouldBeLike(new Supplier('third', ProductCollection::fromArray([
                new Product('999-ABC-DEF-1', 'Product 1'),
            ])))
        ;
    }
}
