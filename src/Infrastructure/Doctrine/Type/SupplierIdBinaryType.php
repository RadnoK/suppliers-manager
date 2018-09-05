<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Type;

use App\Domain\Supplier\Model\Id;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Ramsey\Uuid\Doctrine\UuidBinaryOrderedTimeType;
use Ramsey\Uuid\Uuid;

final class SupplierIdBinaryType extends UuidBinaryOrderedTimeType
{
    public function convertToPHPValue($value, AbstractPlatform $platform): Id
    {
        return Id::fromUuidInstance(parent::convertToPHPValue($value, $platform));
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value instanceof Id) {
            $value = Uuid::fromString($value->toString());
        }

        return parent::convertToDatabaseValue($value, $platform);
    }
}
