<?php

declare(strict_types=1);

namespace spec\Integration\Supplier\Provider;

use Integration\Supplier\Event\SupplierSynchronized;
use Integration\Supplier\Model\Collection\ProductCollection;
use Integration\Supplier\Model\Collection\ProductCollectionInterface;
use Integration\Supplier\Model\Product;
use Integration\Supplier\Model\Supplier;
use Integration\Supplier\Parser\Products\ProductsParserInterface;
use Integration\Supplier\Resolver\ResolverInterface;
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
            new SupplierSynchronized(
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
