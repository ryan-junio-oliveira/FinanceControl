<?php

namespace App\Modules\Budget\Application\UseCases;

use App\Modules\Budget\Domain\Contracts\BudgetRepositoryInterface;

final class ListBudgets
{
    private BudgetRepositoryInterface $repository;

    public function __construct(BudgetRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return \App\Modules\Budget\Domain\Entities\Budget[]
     */
    public function execute(int $organizationId): array
    {
        return $this->repository->listByOrganization($organizationId);
    }
}
