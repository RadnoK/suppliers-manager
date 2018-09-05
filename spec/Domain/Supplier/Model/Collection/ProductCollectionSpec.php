<?php

declare(strict_types=1);

namespace spec\App\Domain\Supplier\Model\Collection;

use App\Domain\Supplier\Exception\ProductAlreadyExistsException;
use App\Domain\Supplier\Exception\ProductNotFoundException;
use App\Domain\Supplier\Model\Collection\ProductCollection;
use App\Domain\Supplier\Model\Product;
use PhpSpec\ObjectBehavior;

final class ProductCollectionSpec extends ObjectBehavior
{
    function let(): void
    {
        $this->beConstructedThrough('createEmpty');
    }

    function it_is_a_product_collection(): void
    {
        $this->shouldImplement(ProductCollection::class);
    }

    function it_can_be_created_empty(): void
    {
        $this->count()->shouldReturn(0);
    }

    function it_can_be_created_from_an_array(): void
    {
        $this->beConstructedThrough('fromArray', [[
            new Product('123-456-1', 'Product 1'),
            new Product('123-456-2', 'Product 2'),
        ]]);

        $this->exists('123-456-1')->shouldReturn(true);
        $this->exists('123-456-2')->shouldReturn(true);
        $this->count()->shouldReturn(2);
    }

    function it_can_add_a_product(): void
    {
        $this->add(new Product('123-456-1', 'Product 1'));

        $this->exists('123-456-1')->shouldReturn(true);
        $this->count()->shouldReturn(1);
    }

    function it_can_remove_a_product(): void
    {
        $this->add(new Product('123-456-1', 'Product 1'));

        $this->remove('123-456-1');

        $this->exists('123-456-1')->shouldReturn(false);
        $this->count()->shouldReturn(0);
    }

    function it_can_be_converted_to_array(): void
    {
        $this->add(new Product('123-456-1', 'Product 1'));

        $this->toArray()->shouldBeLike(['123-456-1' => new Product('123-456-1', 'Product 1')]);
    }

    function it_throws_an_exception_when_a_product_already_exists(): void
    {
        $this->add(new Product('123-456-1', 'Product 1'));

        $this
            ->shouldThrow(ProductAlreadyExistsException::class)
            ->during('add', [new Product('123-456-1', 'Product 1')])
        ;
    }

    function it_throws_an_exception_when_a_product_is_not_found(): void
    {
        $this
            ->shouldThrow(ProductNotFoundException::class)
            ->during('get', ['123-456-1'])
        ;
    }
}
