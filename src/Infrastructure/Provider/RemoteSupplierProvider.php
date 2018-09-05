<?php

declare(strict_types=1);

namespace App\Infrastructure\Provider;

use App\Infrastructure\Parser\Response\Product\FirstSupplierProductParser;
use App\Infrastructure\Parser\Response\Product\ProductParserInterface;
use App\Infrastructure\Parser\Response\Product\SecondSupplierProductParser;
use App\Infrastructure\Parser\Response\Product\ThirdSupplierProductParser;
use App\Infrastructure\Provider\Exception\ProviderNotFoundException;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Symfony\Component\HttpFoundation\Request;

final class RemoteSupplierProvider implements SupplierProviderInterface
{
    /** @var ClientInterface */
    private $client;

    public function __construct(string $resourceUrl)
    {
        $this->client = new Client(['base_uri' => $resourceUrl]);
    }

    public function getProducts(string $supplierName): array
    {
        $response = $this->client->request(Request::METHOD_GET);

        $parser = $this->getSupplierParser($supplierName);

        return $parser->parseResponse($response->getBody()->getContents());
    }

    private function getSupplierParser(string $supplierName): ProductParserInterface
    {
        switch ($supplierName) {
            case FirstSupplierProductParser::NAME:
                return new FirstSupplierProductParser();
            case SecondSupplierProductParser::NAME:
                return new SecondSupplierProductParser();
            case ThirdSupplierProductParser::NAME:
                return new ThirdSupplierProductParser();
        }

        throw new ProviderNotFoundException();
    }
}
