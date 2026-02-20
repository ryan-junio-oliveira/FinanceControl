<?php

namespace App\Modules\Expense\Application\UseCases;

use App\Modules\Expense\Domain\Contracts\ExpenseRepositoryInterface;

final class ListExpenses
{
    private ExpenseRepositoryInterface $repository;

    public function __construct(ExpenseRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(int $organizationId): array
    {
        return $this->repository->listByOrganization($organizationId);
    }
}
