<?php

declare(strict_types=1);

namespace spec\App\Infrastructure\ReadModel\View;

use PhpSpec\ObjectBehavior;

final class ProductViewSpec extends ObjectBehavior
{
    function it_has_no_id_by_default(): void
    {
        $this->getId()->shouldReturn(null);
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
