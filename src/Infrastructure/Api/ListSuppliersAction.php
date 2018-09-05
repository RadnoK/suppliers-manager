<?php

declare(strict_types=1);

namespace App\Infrastructure\Api;

use App\Infrastructure\ReadModel\Repository\SupplierViewRepositoryInterface;
use App\Infrastructure\ReadModel\View\SupplierView;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class ListSuppliersAction
{
    /** @var SupplierViewRepositoryInterface */
    private $supplierViewRepository;

    public function __construct(SupplierViewRepositoryInterface $supplierViewRepository)
    {
        $this->supplierViewRepository = $supplierViewRepository;
    }

    public function __invoke(): Response
    {
        $suppliers = $this->supplierViewRepository->findAll();

        return JsonResponse::create($this->serializeSuppliers($suppliers), Response::HTTP_OK);
    }

    /**
     * TODO Implement JSMSerializer
     */
    private function serializeSuppliers(array $suppliers): array
    {
        $result = [];

        /** @var SupplierView $supplier */
        foreach ($suppliers as $supplier) {
            $result[] = [
                'id' => $supplier->getId(),
                'name' => $supplier->getName(),
            ];
        }

        return $result;
    }
}
