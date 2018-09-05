<?php

declare(strict_types=1);

namespace App\Infrastructure\Api;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class SynchronizeSuppliersAction
{
    /** @var ProviderInterface */
    private $supplierProvider;

    public function __construct(ProviderInterface $supplierProvider)
    {
        $this->supplierProvider = $supplierProvider;
    }

    public function __invoke(Request $request): Response
    {
        $supplierName = $request->query->get('supplier');

        try {
            /** @var SupplierInterface $supplier */
            $supplier = $this->supplierProvider->getByName($supplierName);

            return JsonResponse::create($supplier->products()->toArray(), Response::HTTP_OK);
        } catch (\Exception $exception) {
            return JsonResponse::create(['error' => 'Supplier not found'], Response::HTTP_NOT_FOUND);
        }
    }
}
