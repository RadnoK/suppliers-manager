<?php

declare(strict_types=1);

namespace Integration\Supplier\Provider;

use Integration\IntegrationEvents;
use Integration\Supplier\Event\SupplierSynchronized;
use Integration\Supplier\Exception\ParserNotFoundException;
use Integration\Supplier\Model\Supplier;
use Integration\Supplier\Model\SupplierInterface;
use Integration\Supplier\Parser\Products\FirstSupplierProductsParser;
use Integration\Supplier\Parser\Products\ProductsParserInterface;
use Integration\Supplier\Parser\Products\SecondSupplierProductsParser;
use Integration\Supplier\Parser\Products\ThirdSupplierProductsParser;
use Integration\Supplier\Resolver\ResolverInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

final class SupplierProvider implements ProviderInterface
{
    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * @var ResolverInterface
     */
    private $supplierResourceResolver;

    public function __construct(
        EventDispatcherInterface $eventDispatcher,
        ResolverInterface $supplierResourceResolver
    ) {
        $this->eventDispatcher = $eventDispatcher;
        $this->supplierResourceResolver = $supplierResourceResolver;
    }

    public function getByName(string $name): SupplierInterface
    {
        $response = $this->supplierResourceResolver->findByName($name);

        $products = $this->getSupplierParser($name)->parse($response);

        $this->dispatchSupplierSynchronizedEvent($name, $products->toArray());

        return new Supplier($name, $products);
    }

    private function getSupplierParser(string $supplierName): ProductsParserInterface
    {
        /**
         * TODO Make it a dynamic configuration loader
         */
        switch ($supplierName) {
            case FirstSupplierProductsParser::NAME:
                return new FirstSupplierProductsParser();
            case SecondSupplierProductsParser::NAME:
                return new SecondSupplierProductsParser();
            case ThirdSupplierProductsParser::NAME:
                return new ThirdSupplierProductsParser();
        }

        throw new ParserNotFoundException();
    }

    private function dispatchSupplierSynchronizedEvent(string $name, array $products): void
    {
        $this->eventDispatcher->dispatch(
            IntegrationEvents::SUPPLIER_GET_PRODUCTS,
            new SupplierSynchronized($name, $products)
        );
    }
}
