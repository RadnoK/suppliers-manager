<?php

declare(strict_types=1);

namespace Integration\Supplier\Resolver;

use GuzzleHttp\ClientInterface;
use Integration\Supplier\Exception\MissingSupplierConfigurationException;
use Symfony\Component\HttpFoundation\Request;

final class SupplierResourceResolver implements ResolverInterface
{
    /**
     * @var ClientInterface
     */
    private $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function findByName(string $name): string
    {
        if (!$supplier = getenv(sprintf('SUPPLIER_%s', strtoupper($name)))) {
            throw new MissingSupplierConfigurationException();
        }

        $response = $this->client->request(
            Request::METHOD_GET,
            sprintf('%s/%s', getenv('BASE_URL'), $supplier)
        );

        return $response->getBody()->getContents();
    }
}
