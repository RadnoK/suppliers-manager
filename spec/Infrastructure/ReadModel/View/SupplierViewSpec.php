<?php

declare(strict_types=1);

namespace spec\App\Infrastructure\ReadModel\View;

use App\Infrastructure\ReadModel\View\ProductView;
use Doctrine\Common\Collections\ArrayCollection;
use PhpSpec\ObjectBehavior;

final class SupplierViewSpec extends ObjectBehavior
{
    function let(): void
    {
        $this->beConstructedWith(
            '4f8e0c44-6d5a-47b0-8748-2d5abfbe690b',
            'Solaris Bus&Coach'
        );
    }

    function its_id_is_mutable(): void
    {
        $this->setId('ad22786f-4245-46ac-a4e6-700c0108531e');
        $this->getId()->shouldReturn('ad22786f-4245-46ac-a4e6-700c0108531e');
    }

    function its_name_is_mutable(): void
    {
        $this->setName('Solaris Bus&Coach');
        $this->getName()->shouldReturn('Solaris Bus&Coach');
    }

    function it_can_have_products(ProductView $product): void
    {
        $this->getProducts()->shouldBeLike(new ArrayCollection());
        $this->addProduct($product);
        $this->getProducts()->shouldBeLike(new ArrayCollection([$product->getWrappedObject()]));
    }
}
