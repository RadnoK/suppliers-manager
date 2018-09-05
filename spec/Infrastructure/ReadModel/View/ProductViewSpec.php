<?php

declare(strict_types=1);

namespace spec\App\Infrastructure\ReadModel\View;

use App\Infrastructure\ReadModel\View\SupplierView;
use PhpSpec\ObjectBehavior;

final class ProductViewSpec extends ObjectBehavior
{
    function let(SupplierView $supplierView): void
    {
        $this->beConstructedWith(
            'ce64cfff-6d4e-46e9-ab11-8edbc2863c80',
            $supplierView,
            'super-tram',
            '2-directional version'
        );
    }

    function its_id_is_mutable(): void
    {
        $this->setId('647bafe0-9200-478c-8627-8d36c0adbc1f');
        $this->getId()->shouldReturn('647bafe0-9200-478c-8627-8d36c0adbc1f');
    }

    function its_code_is_mutable(): void
    {
        $this->setCode('Solaris Tramino');
        $this->getCode()->shouldReturn('Solaris Tramino');
    }

    function its_description_is_mutable(): void
    {
        $this->setDescription('2-directional version');
        $this->getDescription()->shouldReturn('2-directional version');

        $this->setDescription(null);
        $this->getDescription()->shouldReturn(null);
    }
}
