<?php

declare(strict_types=1);

namespace spec\App\Infrastructure\ReadModel\View;

use App\Infrastructure\ReadModel\View\ProductView;
use Doctrine\Common\Collections\ArrayCollection;
use PhpSpec\ObjectBehavior;

final class SupplierViewSpec extends ObjectBehavior
{
    function its_has_no_id_by_default(): void
    {
        $this->getId()->shouldReturn(null);
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
