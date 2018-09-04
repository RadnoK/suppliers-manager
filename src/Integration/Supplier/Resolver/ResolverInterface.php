<?php

declare(strict_types=1);

namespace Integration\Supplier\Resolver;

interface ResolverInterface
{
    public function findByName(string $name): string;
}
