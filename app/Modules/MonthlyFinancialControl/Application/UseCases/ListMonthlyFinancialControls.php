<?php

namespace App\Modules\MonthlyFinancialControl\Application\UseCases;

use App\Modules\MonthlyFinancialControl\Domain\Contracts\MonthlyFinancialControlRepositoryInterface;

final class ListMonthlyFinancialControls
{
    private MonthlyFinancialControlRepositoryInterface $repository;

    public function __construct(MonthlyFinancialControlRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(int $organizationId): array
    {
        return $this->repository->listByOrganization($organizationId);
    }
}
