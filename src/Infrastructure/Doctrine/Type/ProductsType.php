<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Type;

use App\Domain\Supplier\Model\Collection\ProductCollection;
use App\Domain\Supplier\Model\Product;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;

final class ProductsType extends Type
{
    private const NAME = 'products';

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform): string
    {
        return $platform->getVarcharTypeDeclarationSQL($fieldDeclaration);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if (null === $value) {
            return null;
        }

        if ($value instanceof ProductCollection) {
            return json_encode($value);
        }

        throw ConversionException::conversionFailed($value, static::NAME);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?ProductCollection
    {
        if (null === $value) {
            return null;
        }

        if ($value instanceof ProductCollection) {
            return $value;
        }

        try {
            $productCollection = ProductCollection::createEmpty();

            $rawProducts = json_decode($value, true);
            foreach ($rawProducts['products'] as $rawProduct) {
                $productCollection->add(new Product($rawProduct['code'], $rawProduct['name'], $rawProduct['description']));
            }

            return $productCollection;
        } catch (\InvalidArgumentException $e) {
            throw ConversionException::conversionFailed($value, static::NAME);
        }
    }

    public function getName(): string
    {
        return static::NAME;
    }
}
